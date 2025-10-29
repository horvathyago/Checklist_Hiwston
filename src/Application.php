<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Authentication\Middleware\AuthenticationRequiredMiddleware;
use Psr\Http\Message\ServerRequestInterface;

class Application extends BaseApplication implements \Authentication\AuthenticationServiceProviderInterface
{
    public function bootstrap(): void
    {
        parent::bootstrap();

        // 🔥 Carrega o plugin Authentication
        $this->addPlugin('Authentication');

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]))
            // 🔥 Middleware principal de autenticação
            ->add(new AuthenticationMiddleware($this));

        return $middlewareQueue;
    }

    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService([
            // 🔥 Redireciona automaticamente se não estiver autenticado
            'unauthenticatedRedirect' => '/users/login',
            'queryParam' => 'redirect',
        ]);

        // 🔥 Campos usados para login
        $fields = [
            'username' => 'email',
            'password' => 'password',
        ];

        // 🔥 Identificador (verifica email + senha com hash)
       $service->loadIdentifier('Authentication.Password', [
            'fields' => [
                'username' => 'email',
                'password' => 'password'
            ],
            'passwordHasher' => [
                'className' => 'Authentication.Default',
            ],
        ]);


        // 🔥 Autenticadores
        $service->loadAuthenticator('Authentication.Session', [
            'sessionKey' => 'Auth', // nome mais previsível e compatível
        ]);

        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => '/users/login',
        ]);

        return $service;
    }

    public function services(ContainerInterface $container): void
    {
    }
}
