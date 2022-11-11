<?php

declare(strict_types=1);

namespace Core;

use Controllers\ErrorController;

/**
 * Class App
 * @package Core
 */
class App
{

    /**
     * @return string
     */
    public static function getAppDir(): string
    {
        return ROOT . DS . 'app';
    }

    /**
     * @return string
     */
    public static function getLayoutDir(): string
    {
        return self::getAppDir() . DS . 'layouts';
    }

    /**
     * @return string
     */
    public static function getViewDir(): string
    {
        return self::getAppDir() . DS . 'views';
    }

    /**
     * @param string|null $path
     *
     * @return void
     */
    public static function run(string $path = null): void
    {
        Route::init($path);

        $controllerClass = '\\Controllers\\' . ucfirst(Route::getController()) . 'Controller';
        $controllerClassFile = self::getAppDir() . str_replace('\\', DS, $controllerClass) . '.php';
        if (!file_exists($controllerClassFile)) {
            $controllerClass = '\\Controllers\\ErrorController';
        }
        $action = Route::getAction() . 'Action';
        $controller = new $controllerClass();
        if (!method_exists($controller, $action)) {
            $controller = new ErrorController();
            $action = 'error404Action';
        }

        $controller->$action();
    }

}
