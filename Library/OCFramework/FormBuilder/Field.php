<?php

namespace OCFramework\FormBuilder;

include_once __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Trait' .DIRECTORY_SEPARATOR. 'IsValid.php';
include_once __DIR__ .DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Trait' .DIRECTORY_SEPARATOR. 'Hydrator.php';

use OCFramework\Hydrator;
use OCFramework\IsValid;

abstract class Field
{
    private $errors,
            $label,
            $name,
            $value = '';

    use Hydrator;
    use IsValid;
    
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    abstract public function buildWidget();

    public function isValid()
    {
        if (!empty($this->getName())) {
            return true;
        }
    }


    /**
     * Get the value of label
     */ 
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of label
     *
     * @return  self
     */ 
    public function setLabel(string $label)
    {
        if ($this->stringValid($label)) {
            $this->label = $label;
            return $this;
        }
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName(string $name)
    {
        if ($this->stringValid($name)) {
            $this->name = $name;
            return $this;
        }
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue(string $value)
    {
        if ($this->stringValid($value)) {
            $this->value = $value;
            return $this;
        }
    }
}