<?php

define('PROJECT_URL', "http://{$_SERVER['HTTP_HOST']}/");

define('CORE', __DIR__.'/core/');

define('VIEW', __DIR__.'/templates/');

define('PLUGINS', __DIR__.'/plugins/');

spl_autoload_register(function($className) {
    $className = str_replace('\\' , '/', $className);

    $classPath = CORE . $className . '.php';
    
    require_once($classPath);
});

require_once(CORE.'Bootstrap.php');

Bootstrap::start();