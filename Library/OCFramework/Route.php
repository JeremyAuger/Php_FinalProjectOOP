<?php

namespace OCFramework;

class Route
{
    protected $action;
    protected $module;
    protected $url;
    protected $varsnames;
    protected $vars = [];

    public function __construct(string $url, string $module, string $action, array $varnames)
    {
        $this->setUrl($url);
        $this->setModule($module);
        $this->setAction($action);
        $this->setVarnames($varnames);
    }

    public function setAction(string $action) { $this->action = $action;}
    public function setModule(string $module) { $this->module = $module;}
    public function setUrl(string $url) { $this->url = $url;}
    public function setVarnames(array $varsnames) { $this->varsnames = $varsnames;}
    public function setVars(array $vars) { $this->vars = $vars;}

    public function getAction() { return is_string($this->action) ? $this->action : false;}
    public function getModule() { return is_string($this->module) ? $this->module : false;}
    public function getUrl() { return is_string($this->url) ? $this->url : false;}
    public function getVarsnames() { return is_array($this->varsnames) ? $this->varsnames : false;}
    public function getVars() { return is_array($this->vars) ? $this->vars : false;}

    public function HasVarsNames()
    {
        return !empty($this->varsnames);
    }

    public function Match($url)
    {
        if (preg_match('#^' .$this->url. '$#', $url, $matches))
        {
            return $matches;
        }
        else {
            return false;
        }
    }
}