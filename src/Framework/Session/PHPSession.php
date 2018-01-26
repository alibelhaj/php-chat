<?php

namespace Framework\Session;


class PHPSession implements SessionInterface
{

    /**
     * @param $key string
     * @param $default mixed
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $this->isStared();
       if (array_key_exists($key,$_SESSION)){
           return $_SESSION[$key];
       }
       return $default;
    }

    /**
     * @param $key string
     * @param $value mixed
     * @return mixed
     */
    public function set($key, $value)
    {
        $this->isStared();
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key string
     */
    public function delete($key)
    {
        $this->isStared();
        unset ($_SESSION[$key]);
    }

    private function isStared()
    {
        if (session_status() === PHP_SESSION_NONE)
        {
            session_start();
        }
    }
}