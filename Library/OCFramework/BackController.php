<?php

namespace OCFramework;

include_once __DIR__ .DIRECTORY_SEPARATOR. 'Trait' .DIRECTORY_SEPARATOR. 'IsValid.php';

use \RuntimeException;

abstract class BackController extends ApplicationComponent
{
    use IsValid;
    
    protected $action = '';
    protected $module = '';
    protected $page = null;
    protected $view = '';
    protected $manager = null;

    public function setAction(string $action)
    {
        if (!empty($action = $this->StringValid($action))) {
            $this->action = $action;
        }
        else {
            throw new RuntimeException('Action value is not correct.');
        }
    }
    public function setModule(string $module)
    {
        if (!empty($module = $this->StringValid($module))) {
            $this->module = $module;
        }
        else {
            throw new RuntimeException('Module value is not correct.');
        }
    }
    public function setView(string $view)
    {
        if (!empty($view = $this->StringValid($view))) {
            $this->view = $view;
            $path = __DIR__.'/../../App/'.$this->app->getName().'/Modules/'.$this->module.'/Views/'.$this->view.'.php';
            $this->getPage()->setContentFile($path);
        }
        else {
            throw new RuntimeException('View value is not correct.');
        }
    }

    public function getPage() {return $this->page;}

    /**
     * Constructor
     *
     * @param Application $app
     * @param string $module
     * @param string $action
     */
    public function __construct(Application $app, string $module, string $action)
    {
        parent::__construct($app);

        $this->manager = new Managers('PDO', DBConnectionFactory::getPDO());
        $this->page = new Page($app);
        
        $this->setAction($action);
        $this->setModule($module);
        $this->setView($action);
    }

    public function execute()
    {
        $method = 'execute'. ucfirst($this->action);
        $parameter = $this->app->HttpRequest();
        if (!is_callable([$this, $method])) {
            throw new RuntimeException('The action: ' . $this->action . ' does not exist in this module.');
        }
        else {
            $this->$method($parameter);
        }
    }
}