<?php

namespace OCFramework;

use \DOMDocument;

class Config extends ApplicationComponent
{
    protected $vars = [];

    public function get(string $var)
    {
        if (empty($this->vars)) {
            $ds = DIRECTORY_SEPARATOR;
            $xmlPath = $_SERVER['DOCUMENT_ROOT']."{$ds}..{$ds}App{$ds}{$this->app->getName()}{$ds}Config{$ds}app.xml";
            $xml = new DOMDocument();
            $xml->load($xmlPath);
            $elements = $xml->getElementsByTagName('define');
            foreach ($elements as $element) {
                $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
            }
        }
        if (isset($this->vars[$var])) {
            return $this->vars[$var];
        }
        else {
            return false;
        }
    }
}