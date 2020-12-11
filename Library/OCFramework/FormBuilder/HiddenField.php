<?php

namespace OCFramework\FormBuilder;

class HiddenField extends Field
{

    public function buildWidget()
    {
        $output = '<input type="hidden" name="'.$this->getName().'" value="'.$this->getValue().'" />';

        return $output;
    }
}