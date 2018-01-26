<?php

namespace Chat\Entity;

class Messages extends BaseEntity
{
    /**
     * @var integer
     */
    public $id;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string
     */
    public $author;
    /**
     * @var string
     */
    public $receiver;


}