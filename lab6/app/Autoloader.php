<?php

declare(strict_types=1);

/**
 * Class auto loader
 */
class Autoloader
{

    /**
     * Register function for requiring needed PhP files
     *
     * @return void
     */
    public static function register(): void
    {
        spl_autoload_register(static function ($class) {
            $file = ROOT . DS . 'app' . DS . str_replace('\\', DS, $class) . '.php';
            if (file_exists($file)) {
                require $file;

                return true;
            }

            return false;
        });
    }

}
