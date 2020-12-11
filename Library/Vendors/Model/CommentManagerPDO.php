<?php

namespace Model;

use Entity\News;
use \PDO;
use Entity\Comment;
use \RuntimeException;

class CommentManagerPDO extends CommentManager
{
    const ADD = 1;
    const UPDATE = 2;
    const DELETE = 3;
    const EXIST = 4;
    const COMPLETE = 5;


    public function getComment($id)
    {
        $select =  $this->getDao()->prepare('SELECT * FROM oop_news_comments WHERE ID = :id');
        $select->execute([':id' => $id]);
        $data = $select->fetch(PDO::FETCH_ASSOC);
        $select->closeCursor();

        if ($data) {
            return new Comment($data);
        }
        else {
            return false;
        }
    }

    public function isNew(Comment $comment)
    {
        $select =  $this->getDao()->prepare('SELECT body FROM oop_news_comments WHERE author = :author');
        $select->bindValue(':author', $comment->getAuthor(), PDO::PARAM_STR);
        $select->bindValue(':body', $comment->getBody(), PDO::PARAM_STR);
        $data = $select->fetch(PDO::FETCH_ASSOC);
        $select->closeCursor();

        if ($data) {
            return false;
        }
        else {
            return true;
        }
    }

    public function addComment(Comment $comment)
    {
        if ($comment->isComplete()) {
            if ($this->isNew($comment)) {
                // Insert into DB new comment
                $q = 'INSERT INTO oop_news_comments (author, body, publication_date, news)
                    VALUES(:Author, :Body, :Publication_date, :news)';
                $add = $this->getDao()->prepare($q);

                $add->bindValue(':Author', $comment->getAuthor(), PDO::PARAM_STR);
                $add->bindValue(':Body', $comment->getBody(), PDO::PARAM_STR);
                $add->bindValue(':Publication_date', $comment->getPublication_date());
                $add->bindValue(':news', $comment->getNewsId());
                $add->execute();
                
                // Hydrate back after insertion or display Errors
                if ($add) {
                    $add->closeCursor();

                    $lastinsert = $this->getDao()->lastInsertId();
                    $select =  $this->getDao()->prepare('SELECT * FROM oop_news_comments WHERE ID = :id');
                    $select->execute([':id'=>$lastinsert]);
                    $data = $select->fetch();

                    $comment->Hydrate($data);
                    $select->closecursor();
                    return self::ADD;
                }
                else {
                    throw new RuntimeException('comment failed to register.');
                }
            } else {
                return self::EXIST;
            }
        } else {
            return self::COMPLETE;
        }
    }

    public function modifyComment(Comment $comment)
    {
        if ($comment->isComplete()) {
            $query = 'UPDATE oop_news_comments
                SET author = :Author, body = :Body, publication_date = :Publication_date, modification_date = :Modification_date
                WHERE ID = :id';
            $update = $this->getDao()->prepare($query);

            $update->bindValue(':id', $comment->getID(), PDO::PARAM_INT);
            $update->bindValue(':Author', $comment->getAuthor(), PDO::PARAM_STR);
            $update->bindValue(':Body', $comment->getBody(), PDO::PARAM_STR);
            $update->bindValue(':Publication_date', $comment->getPublication_date());
            $update->bindValue(':Modification_date', $comment->getModification_date()); 
            $update->execute();
            
            if ($update) {
                $update->closeCursor();
                return self::UPDATE;
            }
            else {
                throw new RuntimeException('comment failed to modify.');
            }
        }
    }

    public function deleteComment(Comment $comment)
    {
        if ($comment->isComplete()) {
            $delete = $this->getDao()->prepare('DELETE FROM oop_news_comments WHERE ID = :id')->execute([':id'=>$comment->getID()]);
        
            if ($delete) {
                return self::DELETE;
            }
            else {
                throw new RuntimeException('comment failed to delete.');
            }
        }
    }

    public function newsComment(News $news)
    {
        $comments = [];
        $q = 'SELECT * FROM oop_news_comments WHERE news = :id ORDER BY id DESC';
        $select = $this->getDao()->prepare($q);
        $select->execute([':id' => $news->getId()]);

        while ($data = $select->fetch(PDO::FETCH_ASSOC)) {
            $comments[$data['id']] = $this->getcomment($data['id']);
        }
        $select->closeCursor();

        return $comments;
    }
}