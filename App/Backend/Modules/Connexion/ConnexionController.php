<?php

namespace App\Backend\Modules\Connexion;

use OCFramework\BackController;

class ConnexionController extends BackController
{

    public function executeIndex()
    {
        $login = $this->app->getconfig()->get('login');
        $pass = $this->app->getconfig()->get('pass');

        if (isset($_POST['login'], $_POST['password'])) {
            if ($_POST['login'] === $login && $_POST['password'] === $pass) {
                $this->app->getUser()->setAuthentication();
                $this->app->HttpResponse()->Redirect($this->app->httpRequest()->Request_Uri());
            }
            else {
                $this->app->getUser()->setFlash('Your Pseudo or Password is invalid');
            }
        }
    }

    public function executeDisconnect()
    {
        session_destroy();
        $this->app->HttpResponse()->Redirect('/');
    }
}