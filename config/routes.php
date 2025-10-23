<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes): void {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder): void {
        // Rota principal - redireciona baseado no login
        $builder->connect('/', ['controller' => 'Checklists', 'action' => 'index']);

        // Rotas de autenticação
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);

        // Conectar outros controllers
        $builder->connect('/pages/*', 'Pages::display');
        
        // Fallbacks
        $builder->fallbacks();
    });
};