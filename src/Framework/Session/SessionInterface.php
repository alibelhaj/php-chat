<?php

namespace Framework\Session;

interface SessionInterface
{
    /**
     * @param $key string
     * @param $default mixed
     * @return mixed
     */
    public function get($key,$default = null);

    /**
     * @param $key string
     * @param $value mixed
     * @return mixed
     */
    public function set($key,$value);

    /**
     * @param $key string
     */
    public function delete($key);

}