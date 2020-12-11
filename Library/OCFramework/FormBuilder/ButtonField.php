<?php

namespace OCFramework\FormBuilder;

class ButtonField extends Field
{
    private $class;

    public function buildWidget()
    {
        $output = '<button type="submit" name="'.$this->getName().'"';
        if (!empty($this->class)) {
            $output .= ' class="'.$this->class.'"';
        }
        $output .= '>'.strtoupper($this->getName()).'</button>';

        return $output;
    }

    /**
     * Set the value of class
     *
     * @return  self
     */ 
    public function setClass(string $class)
    {
        if ($this->stringValid($class)) {
            $this->class = $class;
            return $this;
        }
    }
}