<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

/**
 * Class Menu
 */
class Menu extends Model
{
    /**
     * Menu constructor.
     */
    function __construct()
    {
        $this->tableName = 'menu';
    }
}
