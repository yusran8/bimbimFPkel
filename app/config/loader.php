<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */

$loader->registerNamespaces(
    [
        'Phalcon\Db' => APP_PATH . '/lib/Phalcon/Db',
        'App\Forms' => APP_PATH . '/forms',
    ]
    )->register();
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
       
    ]
)->register();
