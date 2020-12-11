<?php

namespace OCFramework;

use InvalidArgumentException;

session_start();

class User extends ApplicationComponent
{
    public function setAttribute($name, $value)
    {
        if(isset($name, $value)) {
            $_SESSION[$name] = $value;
        }
    }

    public function setFlash(string $flash)
    {
        $_SESSION['flash'] = $flash;
    }

    public function setAuthentication($auth = true)
    {
        if(!is_bool($auth)) {
            throw new InvalidArgumentException('Authentication must be bool value');
        }
        $_SESSION['auth'] = $auth;
    }

    public function getAttribute($name)
    {
        return isset($_SESSION[$name])? $_SESSION[$name] : false;
    }

    public function getFlash()
    {
        if($this->hasFlash())
        {
            $flash = $_SESSION['flash'];
            unset($_SESSION['flash']);
            return $flash;
        }
    }

    public function hasFlash()
    {
        return isset($_SESSION['flash']);
    }

    public function isAuthenticated()
    {
        return isset($_SESSION['auth']) && $_SESSION['auth'] === true;
    }
}