<?php

namespace Core;

/**
 * Data base model interface
 */
interface DbModelInterface
{
    /**
     * Retrieve table name
     * 
     * @return string
     */
    public function getTableName(): string;

    /**
     * Retrieve db model primary key name
     * 
     * @return string
     */
    public function getPrimaryKeyName(): string;

    /**
     * Return current model id
     * 
     * @return null|int
     */
    public function getId(): ?int;
}
