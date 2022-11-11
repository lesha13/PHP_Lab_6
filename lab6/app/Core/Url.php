<?php

declare(strict_types=1);

namespace Core;

/**
 * Class Helper
 */
class Url
{

    /**
     * @param string $path
     * @param string $name
     * @param array $params
     * @return string
     */
    public static function getLink(string $path, string $name, array $params = []): string
    {
        if (!empty($params)) {
            $firts_key = array_keys($params)[0];
            foreach ($params as $key => $value) {
                $path .= ($key === $firts_key ? '?' : '&');
                $path .= "$key=$value";
            }
        }
        return '<a href="' . Route::getBP() . $path . '">' . $name . '</a>';
    }

}
