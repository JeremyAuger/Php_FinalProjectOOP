<?php

namespace OCFramework\FormBuilder;

use InvalidArgumentException;

class FormBuilder
{
    const STRING = 1;
    const TEXT = 2;
    const BUTTON = 3;
    const HIDDEN = 4;

    protected $legend;
    protected $form;

    /**
     * Construct Form framework
     *
     * @param string $legend
     */
    public function __construct(string $legend = null) 
    {
        if (!empty($legend)) {
            $this->setLegend(htmlentities($legend));
        } else {
            $this->setLegend(null);
        }
        $this->setForm(new Form($this->getLegend()));
    }

    /**
     * Add a Field matching constant type in the Form
     *
     * @param array $field
     * @return void
     */
    public function addField(array $field)
    {
        foreach ($field as $type => $name) {
            if (empty($name)) {
                throw new InvalidArgumentException('This Field must be named');
            }
            switch ($type) {
                case ($type == self::STRING):
                        $this->getForm()->addField(new StringField([
                            'name' => $name,
                            'label' => ucfirst($name),
                            'minLength' => 3,
                            'maxLength' => 50,
                            'pattern' => '[a-zA-Z0-9/+!?_.-]+',
                            'title' => 'Min 3 characters including (+-?!_.)']));
                    break;
                    case ($type == self::TEXT):
                        $this->getForm()->addField(new TextField([
                            'name' => $name,
                            'label' => ucfirst($name),
                            'minLength' => 20,
                            'maxLength' => 1500,
                            'cols' => 40,
                            'rows' => 10]));
                        break;
                    case ($type == self::BUTTON):
                        $this->getForm()->addField(new ButtonField(['name' => $name]));
                        break;
                    case ($type == self::HIDDEN):
                        $this->getForm()->addField(new HiddenField(['name' => $name]));
                        break;
                
                default:
                    throw new InvalidArgumentException('This Field doesn\'t exist');
                    break;
            }
        }
    }

    /**
     * set Value for the matching Field name
     *
     * @param array $values
     * @return void
     */
    public function setValues(array $values)
    {
        foreach ($values as $name => $value) {
            if ($field = $this->getField($name)) {
                $field->setValue($value);
            }
        }
    }
    
    /**
     * set Label for the matching Field name
     *
     * @param array $labels
     * @return void
     */
    public function setLabels(array $labels)
    {
        foreach ($labels as $name => $value) {
            if ($field = $this->getField($name)) {
                $field->setLabel($value);
            }
        }
    }

    /**
     * Create Form
     *
     * @return void
     */
    public function formBuilder()
    {
        return $this->getForm()->createView();
    }

    /**
     * Access to the field by his name
     *
     * @param string $name
     * @return Field
     */
    public function getField(string $name)
    {
        foreach ($this->getForm()->getFields() as $field) {
            if ($field->getName() == $name) {
                return $field;
            }
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
     *
     * @return  self
     */ 
    public function setLegend($legend)
    {
        $this->legend = $legend;

        return $this;
    }

    /**
     * Get the value of form
     */ 
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Set the value of form
     *
     * @return  self
     */ 
    public function setForm($form)
    {
        $this->form = $form;

        return $this;
    }
}