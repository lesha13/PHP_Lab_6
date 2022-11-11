<?php

declare(strict_types=1);

namespace Models;

use Core\Model;

/**
 * Class Product
 */
class Product extends Model
{
    /**
     * Product constructor.
     */
    function __construct()
    {
        $this->tableName = 'products';
        $this->idColumn = 'id';
    }
}