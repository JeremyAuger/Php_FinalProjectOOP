<?php

namespace Model;

use Entity\News;
use OCFramework\Manager;

abstract class NewsManager extends Manager
{
    abstract public function getNews($id);
    abstract public function addNews(News $news);
    abstract public function modifyNews(News $news);
    abstract public function deleteNews(News $news);
}
