<?php

namespace Chat\Entity;

class Users extends BaseEntity
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

}