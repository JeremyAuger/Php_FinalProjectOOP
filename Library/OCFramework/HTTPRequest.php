<?php

namespace OCFramework;

class HTTPRequest extends ApplicationComponent
{
  public function method()
  {
    return $_SERVER['REQUEST_METHOD'];
  }

  public function Request_Uri()
  {
    return $_SERVER['REQUEST_URI'];
  }

  public function GET_data($key)
  {
    if($this->GET_exist($key))
    {
      return isset($_GET[$key]) ? $_GET[$key] : false;
    }
  }

  public function POST_data($key)
  {
    if($this->POST_exist($key))
    {
      return isset($_POST[$key]) ? $_POST[$key] : false;
    }
  }

  public function Cookie_data($key)
  {
    if($this->Cookie_exist())
    {
      return isset($_COOKIE[$key]) ? $_COOKIE[$key] : false;
    }
  }

  public function GET_exist($key)
  {
   return isset($_GET[$key]);
  }

  public function POST_exist($key)
  {
    return isset($_POST[$key]);
  }

  public function Cookie_exist()
  {
    return isset($_COOKIE);
  }
}