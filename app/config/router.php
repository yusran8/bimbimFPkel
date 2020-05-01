<?php

$router = $di->getRouter();

// Define your routes here
$router->add('/', ['controller' => 'index', 'action' => 'index']);

$router->add('/user/login', ['controller' => 'user', 'action' => 'login']);
$router->add('/user/login/submit', ['controller' => 'user', 'action' => 'loginSubmit']);

$router->add('/user/register', ['controller' => 'user', 'action' => 'register']);
$router->add('/user/register/submit', ['controller' => 'user', 'action' => 'registerSubmit']);

$router->add('/kelas/addClass', ['controller' => 'kelas', 'action' => 'addClass']);
$router->add('/kelas/addClass/submit', ['controller' => 'kelas', 'action' => 'addClassSubmit']);

$router->add('/kelas/delete/{id}', ['controller' => 'kelas', 'action' => 'delete']);

$router->add('/kelas/edit/{id}', ['controller' => 'kelas', 'action' => 'edit']);
$router->add('/kelas/edit/submit', ['controller' => 'kelas', 'action' => 'editSubmit']);

$router->add('/user/takeclass/{id}', ['controller' => 'user', 'action' => 'takeclass']);
$router->add('/user/unenroll/{id}', ['controller' => 'user', 'action' => 'unenroll']);

$router->add('/kelas/user', ['controller' => 'kelas', 'action' => 'user']);



$router->handle($_SERVER['REQUEST_URI']);
