<?php

namespace OCFramework;

trait IsValid
{
    public function stringValid(string $string)
    {
        htmlentities($string, ENT_SUBSTITUTE,'cp1252');
        trim($string);
        stripcslashes($string);
        strtolower($string);
        
        return $string;
    }
}