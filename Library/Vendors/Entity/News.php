<?php

namespace Entity;

use \datetime;
use OCFramework\Entity;
use OCFramework\IsValid;

class News extends Entity
{
    use IsValid;

    protected $id,
              $author,
              $title,
              $body,
              $publication_date,
              $modification_date;

    const AUTH = 1;
    const TITLE = 2;
    const BODY = 3;

    public function setId($id=0)
    {
        $this->id = intval($id);
    }
    public function setAuthor(string $author)
    {
        if ($this->stringValid($author)) {
            $this->author = $author;
        }
        else {
            return self::AUTH;
        }
    }
    public function setTitle(string $title)
    {
        if ($this->stringValid($title)) {
            $this->title = $title;
        }
        else {
            return self::TITLE;
        }
    }
    public function setBody(string $body)
    {        
        if ($this->stringValid($body)) {
            $this->body= $body;
        }
        else {
            return self::BODY;
        }
    }
    public function setPublication_date($pub_date)
    {
        if (is_string($pub_date))
        {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $pub_date);
            $this->publication_date = $date;
        }
        elseif (is_object($pub_date))
        {
            $this->publication_date = $pub_date;
        }
        
    }
    public function setModification_date($mod_date)
    {
        if ($mod_date === null)
        {
            $this->modification_date = null;
        }
        elseif (is_string($mod_date))
        {
             $date = DateTime::createFromFormat('Y-m-d H:i:s', $mod_date);
            $this->modification_date = $date;
        }
        elseif (is_object($mod_date))
        {
            $this->modification_date = $mod_date;
        }
    }

    public function getId() {return $this->id;}
    public function getAuthor() {return $this->author;}
    public function getTitle() {return $this->title;}
    public function getBody() {return $this->body;}
    public function getPublication_date() {return $this->publication_date->format('Y-m-d H:i:s');}
    public function getPublication_dateFormated() {return $this->publication_date->format('d M Y');}
    public function getModification_date()
    {
        if (is_object($this->modification_date))
        {
            return $this->modification_date->format('Y-m-d H:i:s');
        }
        else {
            return null;
        }
    }
    public function getModification_dateFormated()
    {
        if (is_object($this->modification_date))
        {
            return $this->modification_date->format('d M Y');
        }
        else {
            return null;
        }
    }

    public function isComplete()
    {
        return (!empty($this->author) || !empty($this->title) || !empty($this->body));
    }
}