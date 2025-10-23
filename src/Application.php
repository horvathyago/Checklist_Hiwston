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

// 🔥 Importações para o sistema de autenticação
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Application setup class.
 *
 * @extends \Cake\Http\BaseApplication<\App\Application>
 */
class Application extends BaseApplication implements \Authentication\AuthenticationServiceProviderInterface
{
    /**
     * Load all the application configuration and bootstrap logic.
     */
    public function bootstrap(): void
    {
        parent::bootstrap();

        // 🔥 Carrega o plugin Authentication
        $this->addPlugin('Authentication');

        if (PHP_SAPI !== 'cli') {
            FactoryLocator::add('Table', (new TableLocator())->allowFallbackClass(false));
        }
    }

    /**
     * Setup the middleware queue your application will use.
     */
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
            // 🔥 Adiciona o middleware de autenticação
            ->add(new AuthenticationMiddleware($this));

        return $middlewareQueue;
    }

    /**
     * Configura o serviço de autenticação
     */
    public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface
    {
        $service = new AuthenticationService();

        // 🔥 Define onde redirecionar se o usuário não estiver autenticado
        $service->setConfig([
            'unauthenticatedRedirect' => '/users/login',
            'queryParam' => 'redirect',
        ]);

        // 🔥 Campos usados no login
        $fields = [
            'username' => 'email',
            'password' => 'password',
        ];

        // 🔥 Adiciona os identificadores e autenticadores
        $service->loadIdentifier('Authentication.Password', compact('fields'));
        $service->loadAuthenticator('Authentication.Session');
        $service->loadAuthenticator('Authentication.Form', [
            'fields' => $fields,
            'loginUrl' => '/users/login',
        ]);

        return $service;
    }

    /**
     * Register application container services.
     */
    public function services(ContainerInterface $container): void
    {
    }
}
