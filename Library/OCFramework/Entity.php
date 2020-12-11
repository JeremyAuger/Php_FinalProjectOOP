<?php

namespace OCFramework;

include __DIR__ .DIRECTORY_SEPARATOR. 'Trait' .DIRECTORY_SEPARATOR. 'Hydrator.php';
use \Exception;

abstract class Entity implements \ArrayAccess
{
    use Hydrator;

    protected $errors = [];
    protected $id;

    public function getId() { return $this->id; }
    public function getErrors() { return $this->errors; }

    public function setId($id = 0) { $this->id = (int) $id; }

    public function __construct(array $data=[])
    {
        if (!empty($data))
        {
            $this->hydrate($data);
        }
    }

    public function isNew()
    {
        return empty($this->id);
    }

    public function offsetGet($var)
    {
        if ($this->offsetExists($var))
        {
            return $this->$var;
        }
    }

    public function offsetSet($var, $value)
    {
        $method = 'set' . ucfirst($var);
        if ($this->offsetExists($var))
        {
            $this->$method($value);
        }
    }

    public function offsetExists($var)
    {
        return isset($this->$var) && is_callable([$this, 'get'.ucfirst($var)]);
    }

    public function offsetUnset($var)
    {
        throw new Exception('No value should be deleted');
    }
}