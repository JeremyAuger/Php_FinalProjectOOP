<?php

namespace OCFramework;

abstract class ApplicationComponent
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function App()
    {
        return $this->app;
    }
}