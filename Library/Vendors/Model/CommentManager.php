<?php

namespace Model;

use Entity\Comment;
use OCFramework\Manager;

abstract class CommentManager extends Manager
{
    abstract public function getComment($id);
    abstract public function addComment(Comment $news);
    abstract public function modifyComment(Comment $news);
    abstract public function deleteComment(Comment $news);
}