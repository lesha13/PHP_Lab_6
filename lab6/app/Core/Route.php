<?php

declare(strict_types=1);

namespace Core;

/**
 * Class Route
 */
class Route
{
    /** @var string */
    private static $controller;

    /** @var string */
    private static $action;

    /**
     * @return mixed|string
     */
    public static function getBP()
    {
        return self::getBasePath();
    }

    /**
     * @return mixed|string
     */
    public static function getBasePath()
    {
        $basePath = substr(ROOT, strlen($_SERVER['DOCUMENT_ROOT']));
        if (DS !== '/') {
            $basePath = str_replace(DS, '/', $basePath);
        }

        return $basePath;
    }

    /**
     * @param string|null $route
     *
     * @return void
     */
    public static function init(string $route = null): void
    {
        if (!$route) {
            $request = explode('?', $_SERVER['REQUEST_URI']);
            $uri = $request[0];
            $route = substr($uri, strlen(self::getBasePath()));
        }
        $routePath = explode('/', $route);
        if ($routePath[0] === "") {
            array_shift($routePath);
        }
        if (isset($routePath[0]) && $routePath[0] === 'index.php') {
            array_shift($routePath);
        }
        self::$controller = !empty($routePath[0]) ? $routePath[0] : 'index';
        self::$action = !empty($routePath[1]) ? $routePath[1] : 'index';
    }

    /**
     * @return null|string
     */
    public static function getAction(): ?string
    {
        return self::$action;
    }

    /**
     * @return null|string
     */
    public static function getController(): ?string
    {
        return self::$controller;
    }

}
