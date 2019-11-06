<?php
use Cake\Routing\Router;
Router::plugin('Admin', function ($routes) {
    $routes->extensions(['json']);
    Router::connect('/admin', ['plugin' => 'Admin','controller' => 'Users', 'action' => 'index']);
    Router::connect('/UploadHandler', ['controller' => 'UploadHandler', 'action' => 'index']);
    Router::connect('/UploadHandler/:action', ['controller' => 'UploadHandler']);
    $routes->fallbacks('InflectedRoute');
});