<?php

namespace OCFramework\FormBuilder;

use InvalidArgumentException;

class StringField extends Field
{
    
    private $maxLength,
            $minLength,
            $pattern,
            $title,
            $class;

    public function buildWidget()
    {
        $output = '<div>';
        if (!empty($this->getLabel())) {
           $output .= '<label for="'.$this->getName().'">'.$this->getLabel().':</label></br>';
        }
        $output .= '<input type="text" id="'.$this->getName().'" name="'.$this->getName().'"';
        if (!empty($this->class)) {
            $output .= ' class="'.$this->class.'"';
        }
        if (!empty($this->minLength)) {
            $output .= ' minlength="'.$this->minLength.'"';
        }
        if (!empty($this->maxLength)) {
            $output .= ' maxlength="'.$this->maxLength.'"';
        }
        if (!empty($this->pattern)) {
            $output .= ' pattern="'.$this->pattern.'"';
        }
        if (!empty($this->title)) {
            $output .= ' title="'.$this->title.'"';
        }
        $output .= ' value="'.$this->getValue().'" required></div>';

        return $output;
    }

    /**
     * Set the value of maxLength
     *
     * @return  self
     */ 
    public function setMaxLength(int $maxLength)
    {
        if ($maxLength < 5 || $maxLength > 200) {
            throw new InvalidArgumentException('Maximum length must be between 5 & 200');
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
        if ($minLength < 1 || $minLength > 5) {
            throw new InvalidArgumentException('Minimum length must be between 1 & 5');
        }
        $this->minLength = $minLength;

        return $this;
    }

    /**
     * Set the value of pattern
     *
     * @return  self
     */ 
    public function setPattern(string $pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        if ($this->stringValid($title)) {
            $this->title = $title;
            return $this;
        }
    }
}