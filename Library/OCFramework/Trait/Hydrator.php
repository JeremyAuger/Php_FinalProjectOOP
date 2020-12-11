<?php

namespace OCFramework;

trait Hydrator
{
    public function hydrate($data)
    {
        foreach ($data as $attribut => $value)
        {
            $method = 'set' . ucfirst($attribut);
            if (method_exists($this, $method))
            {
                $this->$method($value);
            }
        }
    }
}