<?php

namespace OCFramework;

class HTTPResponse extends ApplicationComponent
{
    protected $page;

    public function setPage(Page $page)
    {
        $this->page = $page;
    }

    public function addHeader($header)
    {
        header($header);
    }

    public function Send()
    {
        exit($this->page->GetGeneratedPage());
    }

    public function Redirect($location)
    {
        return header('location:' . $location);
        exit;
    }

    public function Redirect404()
    {
        $this->setPage(new Page($this->app));
        $this->page->setContentFile(__DIR__.'/Errors/404.php');
        header("HTTP/1.0 404 Not Found");
        $this->send();
    }

    public function SetCookie($name, $value = '', $expires = 0, $path = null, $domain = null, $secure = false, $httponly = true)
    {
        setcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }
}