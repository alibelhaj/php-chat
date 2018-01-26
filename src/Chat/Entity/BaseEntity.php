<?php

namespace Chat\Entity;

abstract class BaseEntity
{
    /**
     * @var \DateTime
     */
    public $created_at;

    public function __construct()
    {
        if ($this->created_at)
        {
            return new \DateTime($this->created_at);
        }
    }
}