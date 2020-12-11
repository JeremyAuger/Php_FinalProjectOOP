<?php

namespace OCFramework\FormBuilder;

use InvalidArgumentException;

class TextField extends Field
{
    private $cols;
    private $rows;
    private $minLength;
    private $maxLength;

    public function buildWidget()
    {
        $output = '<div>';
        if (!empty($this->getLabel())) {
           $output .= '<label for="'.$this->getName().'">'.$this->getLabel().':</label></br>';
        }
        $output .= '<textarea id="'.$this->getName().'" name="'.$this->getName().'"';
        if (!empty($this->class)) {
            $output .= ' class="'.$this->class.'"';
        }
        if (!empty($this->minLength)) {
            $output .= ' minlength="'.$this->minLength.'"';
        }
        if (!empty($this->maxLength)) {
            $output .= ' maxlength="'.$this->maxLength.'"';
        }
        if (!empty($this->cols)) {
            $output .= ' cols="'.$this->cols.'"';
        }
        if (!empty($this->rows)) {
            $output .= ' rows="'.$this->rows.'"';
        }
        $output .= ' required>'.$this->getValue().'</textarea></div>';

        return $output;
    }

    /**
     * Set the value of cols
     *
     * @return  self
     */ 
    public function setCols(int $cols)
    {
        if ($cols <1 || $cols >100 ) {
            throw new InvalidArgumentException('Number of columns must be between 1 & 100');
        }
        else {
            $this->cols = $cols;
            return $this;
        }
    }

    /**
     * Set the value of rows
     *
     * @return  self
     */ 
    public function setRows(int $rows)
    {
        if ($rows <1 || $rows >50 ) {
            throw new InvalidArgumentException('Number of rows must be between 1 & 50');
        }
        else {
            $this->rows = $rows;
            return $this;
        }
    }

    /**
     * Set the value of maxLength
     *
     * @return  self
     */ 
    public function setMaxLength(int $maxLength)
    {
        if ($maxLength < 5 || $maxLength > 2000) {
            throw new InvalidArgumentException('Maximum length must be between 5 & 2000');
        }
        $this->maxLength = $maxLength;

        return $this;
    }

    /**
     * Set the value of minLength
     *
     * @return  self
     */ 
    public function setMinLength(int $minLength)
    {
        if ($minLength < 2 || $minLength > 20) {
            throw new InvalidArgumentException('Minimum length must be between 2 & 20');
        }
        $this->minLength = $minLength;

        return $this;
    }
}