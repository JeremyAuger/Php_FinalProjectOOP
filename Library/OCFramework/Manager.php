<?php

namespace OCFramework;

abstract class Manager
{
    protected $dao;

    public function __construct($dao)
    {
        $this->dao = $dao;
    }

    /**
     * Get the value of dao
     */ 
    public function getDao()
    {
        return $this->dao;
    }
}