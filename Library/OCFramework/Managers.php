<?php

namespace OCFramework;

use \InvalidArgumentException;

class Managers
{
    protected $api = null;
    protected $dao = null;
    protected $managers = [];

    public function __construct(string $api, object $dao)
    {
        $this->api = $api;
        $this->dao = $dao;
    }

    public function GetManagerOf(string $module)
    {
        if (empty($module))
        {
            throw new InvalidArgumentException('Invalid module specified.');
        }
        elseif (!isset($this->managers[$module]))
        {
            $manager = DIRECTORY_SEPARATOR.'Model\\'.$module."Manager".$this->api;
            $this->managers[$module] = new $manager($this->dao);
        }
        return $this->managers[$module];
    }
}