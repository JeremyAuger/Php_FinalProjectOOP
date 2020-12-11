<?php

namespace OCFramework;

use \RuntimeException;

class Router
{
    protected $routes = [];

    const NO_ROUTE = 1;

    public function AddRoute(Route $route)
    {
        $this->routes[] = $route;
    }

    public function getRoute(string $url)
    {
        foreach ($this->routes as $route)
        {
            if ($varvalues = $route->Match($url) !== false)
            {
                $varvalues = $route->Match($url);
                if ($route->HasVarsNames())
                {
                    $varsnames = $route->getVarsNames();
                    $listvars = [];
                    foreach ($varvalues as $key => $match)
                    {
                        if ($key !== 0)
                        {
                            $listvars[$varsnames[$key - 1]] = $match;
                        }
                    }
                    $route->setVars($listvars);
                }
                return $route;
            }
        }
        throw new RuntimeException('There is no route matching this URL', self::NO_ROUTE);
    }
}