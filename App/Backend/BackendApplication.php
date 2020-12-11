<?php

namespace App\Backend;

use \OCFramework\Application;

class BackendApplication extends Application
{
    public function __construct()
    {
        parent::__construct();
        $this->name = 'Backend';
    }

    public function run()
    {
        $url = $this->httpRequest->Request_Uri();
        if ($this->user->isAuthenticated()) {
            $controller = $this->getController($url);
        }
        else {
            $controller = new Modules\Connexion\ConnexionController($this, 'Connexion', 'index');
        }
        $controller->execute();
        $response = $this->httpResponse;
        $response->setPage($controller->getPage());
        $response->send();
    }
}