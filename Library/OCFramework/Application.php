<?php

namespace OCFramework;

use \DOMDocument;
use \RuntimeException;

abstract class Application
{
    protected $httpRequest;
    protected $httpResponse;
    protected $name;
    protected $user;
    protected $config;

    public function __construct()
    {
        $this->httpRequest = new HTTPRequest($this);
        $this->httpResponse = new HTTPResponse($this);
        $this->name = '';
        $this->user = new User($this);
        $this->config = new Config($this);
    }

    /**
     * Get the value of config
     */ 
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get the value of user
     */ 
    public function getUser()
    {
        return $this->user;
    }

        /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
    

    public function HttpRequest()
    {
        return $this->httpRequest;
    }

    public function HttpResponse()
    {
        return $this->httpResponse;
    }

    abstract public function run();

    public function getController($url)
    {
        $xml = new DOMDocument();
        $ds = DIRECTORY_SEPARATOR;
        $xmlPath = $_SERVER['DOCUMENT_ROOT']."{$ds}..{$ds}App{$ds}{$this->getName()}{$ds}Config{$ds}routes.xml";
        $xml->load($xmlPath);

        $router = new Router;

        // Get all the routes
        $routes = $xml->getElementsByTagName('route');
        // Add each route to the Router
        foreach ($routes as $route)
        {
            $url = $route->getAttribute('url');
            $module = $route->getAttribute('module');
            $action = $route->getAttribute('action');
            $varnames = [];

            if($route->hasAttribute('vars'))
            {
                $varnames = explode(',', $route->getAttribute('vars'));
            }

            $router->AddRoute(new Route($url, $module, $action, $varnames));
        }

        // Get the correct Route for $url or get error404
        try {
            $correctRoute = $router->getRoute($this->httpRequest->Request_Uri());
        }
        catch (RuntimeException $e)
        {
            if ($e->getCode() == Router::NO_ROUTE)
            {
                $this->httpResponse->Redirect404();
            }
        }
        
        // Add Url vars into $_GET
        $_GET = array_merge($_GET, $correctRoute->getVars());

        // AutoPath to correct Controller
        $controllerClass = 'App\\'.$this->name.'\\Modules\\'.$correctRoute->getModule().'\\'.$correctRoute->getModule().'Controller';
        
        // Return correct Controller for Url
        return new $controllerClass($this, $correctRoute->getModule(), $correctRoute->getAction());
    }
}