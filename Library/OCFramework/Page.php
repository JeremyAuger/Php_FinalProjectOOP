<?php

namespace OCFramework;

use InvalidArgumentException;
use RuntimeException;

class Page extends ApplicationComponent
{
    protected $contentFile;
    protected $vars = [];

    public function addVar(string $var, $value)
    {
        if (empty($var))
        {
            throw new InvalidArgumentException('Variable name must be not null');
        }
        $this->vars[$var] = $value;
    }

    public function getGeneratedPage()
    {
        if (!file_exists($this->contentFile))
        {
            throw new RuntimeException('This view doesn\'t exist');
        }
        $user = $this->app->getUser();
        extract($this->vars);
        ob_start();
            require $this->contentFile;
        $content = ob_get_clean();
        
        ob_start();
            require __DIR__ . '/../../App/' . $this->app->getName() . '/Templates/Layout.php';
        return ob_get_clean();
    }

    public function setContentFile(string $file)
    {
        if (empty($file))
        {
            throw new InvalidArgumentException('View is invalid');
        }
        $this->contentFile = $file;
    }
}