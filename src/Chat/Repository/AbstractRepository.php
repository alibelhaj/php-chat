<?php
/**
 * Created by PhpStorm.
 * User: ali
 * Date: 26/01/18
 * Time: 17:09
 */

namespace Chat\Repository;


class AbstractRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct(\PDO $pdo)
    {

        $this->pdo = $pdo;
    }
}