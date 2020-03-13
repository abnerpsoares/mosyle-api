<?php
    /**
     * Route, request method, controller, class method, restrict
     */
    $routes = [
        ['users', 'POST', 'UserController', 'create', false],
        ['login', 'POST', 'UserController', 'auth', false],
        ['users/:iduser', 'GET', 'UserController', 'fetch', true],
        ['users', 'GET', 'UserController', 'fetchAll', true],
        ['users/:iduser', 'PUT', 'UserController', 'edit', true],
        ['users/:iduser', 'DELETE', 'UserController', 'delete', true],
        ['users/:iduser/drink', 'POST', 'DrinkMonitorController', 'create', true],
        ['users/:iduser/drink', 'GET', 'DrinkMonitorController', 'fetchAll', true],
        ['ranking', 'GET', 'DrinkMonitorController', 'ranking', true],
    ];
?>