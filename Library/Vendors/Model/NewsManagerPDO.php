<?php

namespace Model;

use \PDO;
use Entity\News;
use \RuntimeException;

class NewsManagerPDO extends NewsManager
{
    const ADD = 1;
    const UPDATE = 2;
    const DELETE = 3;


    public function getNews($id)
    {
        $select =  $this->getDao()->prepare('SELECT * FROM oop_news WHERE ID = :id');
        $select->execute([':id' => $id]);
        $data = $select->fetch(PDO::FETCH_ASSOC);
        $select->closeCursor();

        return new News($data);
    }

    public function addNews(News $news)
    {
        if ($news->isComplete()) {
            // Insert into DB new NEWS
            $q = 'INSERT INTO oop_news (Author, Title, Body, Publication_date)
                VALUES(:Author, :Title, :Body, :Publication_date)';
            $add = $this->getDao()->prepare($q);

            $add->bindValue(':Author', $news->getAuthor(), PDO::PARAM_STR);
            $add->bindValue(':Title', $news->getTitle(), PDO::PARAM_STR);
            $add->bindValue(':Body', $news->getBody(), PDO::PARAM_STR);
            $add->bindValue(':Publication_date', $news->getPublication_date());
            $add->execute();
            
            // Hydrate back after insertion or display Errors
            if ($add) {
                $add->closeCursor();

                $lastinsert = $this->getDao()->lastInsertId();
                $select =  $this->getDao()->prepare('SELECT * FROM oop_news WHERE ID = :id');
                $select->execute([':id'=>$lastinsert]);
                $data = $select->fetch();

                $news->Hydrate($data);
                $select->closecursor();
                return self::ADD;
            }
            else {
                throw new RuntimeException('News failed to register.');
            }
        }
        
    }

    public function modifyNews(News $news)
    {
        if ($news->isComplete()) {
            $query = 'UPDATE oop_news
                SET Author = :Author, Title = :Title, Body = :Body, Modification_date = :Modification_date
                WHERE ID = :id';
            $update = $this->getDao()->prepare($query);

            $update->bindValue(':id', $news->getID(), PDO::PARAM_INT);
            $update->bindValue(':Author', $news->getAuthor(), PDO::PARAM_STR);
            $update->bindValue(':Title', $news->getTitle(), PDO::PARAM_STR);
            $update->bindValue(':Body', $news->getBody(), PDO::PARAM_STR);
            $update->bindValue(':Modification_date', $news->getModification_date()); 
            $update->execute();
            
            if ($update) {
                $update->closeCursor();
                return self::UPDATE;
            }
            else {
                throw new RuntimeException('News failed to modify.');
            }
        }
    }

    public function deleteNews(News $news)
    {
        // DELETE News + comments
        if ($news->isComplete()) {
            $q = 'DELETE news,comm
                    FROM oop_news AS news
                    INNER JOIN oop_news_comments AS comm
                    ON news.ID = comm.news
                    WHERE news.ID = :id';
            $delete = $this->getDao()->prepare($q)->execute([':id'=>$news->getID()]);
            if ($delete) {
                return self::DELETE;
            }
            else { 
                throw new RuntimeException('News failed to delete.');
            }
        }
    }

    public function lastNews(int $howmany)
    {
        $news = [];
        $q = 'SELECT * FROM oop_news ORDER BY ID DESC LIMIT 0,' .$howmany;
        $select = $this->getDao()->prepare($q);
        $select->execute();

        while ($data = $select->fetch(PDO::FETCH_ASSOC)) {
            $news[$data['ID']] = $this->getNews($data['ID']);
        }
        $select->closeCursor();

        return $news;
    }

    public function allNews()
    {
        $news = [];
        $q = 'SELECT * FROM oop_news ORDER BY ID DESC';
        $select = $this->getDao()->prepare($q);
        $select->execute();

        while ($data = $select->fetch(PDO::FETCH_ASSOC)) {
            $news[$data['ID']] = $this->getNews($data['ID']);
        }
        $select->closeCursor();

        return $news;
    }

    public function count()
    {
        return $this->getDao()->query('SELECT COUNT(id) FROM oop_news')->fetchColumn();
    }

    public function newsExist($title)
    {
        $select =  $this->getDao()->prepare('SELECT * FROM oop_news WHERE Title = :title');
        $select->execute([':title' => $title]);
        $data = $select->fetch(PDO::FETCH_ASSOC);
        $select->closeCursor();

        if ($data) {
            return new News($data);
        }
        return false;
    }
}