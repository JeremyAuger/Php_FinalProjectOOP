<?php

namespace App\Frontend;

use \OCFramework\Application;

class FrontendApplication extends Application
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'Frontend';
    }

    public function run()
    {
        $url = $this->httpRequest->Request_Uri();
        $controller = $this->getController($url);
        $controller->execute();
        $response = $this->httpResponse;
        $response->setPage($controller->getPage());
        $response->send();
    }
}