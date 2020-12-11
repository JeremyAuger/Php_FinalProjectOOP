<?php

namespace OCFramework\FormBuilder;

use InvalidArgumentException;
use OCFramework\Entity;

class Form
{
    private $fields = [];
    private $legend;

    /**
     * Constructor
     *
     * @param string $legend
     */
    public function __construct(string $legend = null)
    {
        if (!empty($legend)) {
            $this->setLegend($legend);
        }
    }

    /**
     * Get the value of legend
     */ 
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * Set the value of legend
     */ 
    public function setLegend(string $legend)
    {
        $this->legend = $legend;
    }

    /**
     * Get the value of fields
     */ 
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Add a field to the FieldList
     *
     * @param Field $field
     * @return void
     */
    public function addField($field)
    {
        if ($field->isValid()) {
            $this->fields[] = $field;
            return $this;
        }
        else {
            throw new InvalidArgumentException('This field cannot be added.');
        }
    }

    /**
     * Create the Form
     *
     * @return string $output
     */
    public function createView()
    {
        if ($this->isFormValid()) {
            $output = '<form action="" method="post"><fieldset>';
            if (!empty($this->getLegend())) {
                $output .= '<legend>'.$this->getLegend().'</legend>';
            }
            foreach ($this->fields as $field) {
                $output .= $field->buildWidget();
            }
            $output .= '</fieldset></form>';

            return $output;
        }
        else {
            throw new InvalidArgumentException ('The Form is Invalid.');
        }
    }

    /**
     * Control Fields and minimum configuration
     *
     * @return boolean
     */
    public function isFormValid()
    {
        foreach ($this->fields as $field) {
            if (!$field->isValid()) {
                return false;
            }
        }
        if ($this->hasSubmit() && $this->hasInput()) {
            return true;
        }
    }

    /**
     * Check array fields for instanceof Button
     *
     * @return boolean
     */
    public function hasSubmit()
    {
        foreach ($this->fields as $field) {
            $submit = false;
            if ($field instanceof ButtonField) {
                $submit = true;
                break;
            }
        }
        return $submit;
    }

    /**
     * Check array fields for minimum input
     *
     * @return boolean
     */
    public function hasInput()
    {
        foreach ($this->fields as $field) {            
            switch ($field) {
                case ($field instanceof StringField):
                    $input = true;
                    break 2;
                case ($field instanceof TextField):
                    $input = true;
                    break 2;
                case ($field instanceof HiddenField):
                    $input = true;
                    break 2;
                default :
                    $input = false;
            }
        }
        return $input;
    }
}