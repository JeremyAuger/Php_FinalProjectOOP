<?php

namespace App\Backend\Modules\News;

use DateTime;
use Entity\News;
use OCFramework\BackController;
use OCFramework\FormBuilder\FormBuilder;

class NewsController extends BackController
{

    public function executeIndex()
    {
        $newsManager = $this->manager->GetManagerOf('News');
        $this->page->addVar('title', 'Total News: ' .$newsManager->count());
        $this->page->addVar('list', $newsManager->allNews());
    }


    public function executeInsert()
    {
        $news = new News();

        // Form Builder configuration
        $form = new FormBuilder('Comment');
        $form->addField([FormBuilder::STRING => 'title']);
        $form->addField([FormBuilder::TEXT => 'body']);
        $form->addField([FormBuilder::STRING => 'author']);
        $form->addField([FormBuilder::BUTTON => 'update']);
        $form->addField([FormBuilder::BUTTON => 'add']);        

        // Form treatment
        if (isset($_POST['header'], $_POST['body'], $_POST['author'])
        && (isset($_POST['add']) || isset($_POST['update']))) {
            $form->setValues([
                    'title' => $title = trim(preg_replace('/\s+/', ' ', $_POST['header'])),
                    'body' => $body = $_POST['body'],
                    'author' => $author = $_POST['author']
                    ]);
            $publication_date = new DateTime();

            if ($this->isValid([$title, $body, $author])) {
                $newsExist = $this->exist($title);
                $news->hydrate(compact('title', 'body', 'author', 'publication_date'));
                $newsManager = $this->manager->GetManagerOf('News');

                // If 'add' action required and the news doesn't exist in DB
                if (isset($_POST['add']) && $newsExist === false) {
                    $add = $newsManager->addNews($news);
                    if ($add == $newsManager::ADD) {
                        $this->app->getUser()->setFlash('The News has been posted.');
                    }
                }
                // If 'add' action required but the news already exist in DB
                elseif (isset($_POST['add']) && $newsExist) {
                    $this->app->getUser()->setFlash('Warning: This News already exist.');
                }
                // If 'update' action required and the news already exist
                elseif (isset($_POST['update']) && $newsExist) {
                    $newsId = $newsExist->getId();
                    $news->setId($newsId);
                    $news->setModification_date(new DateTime());
                    $update = $newsManager->modifyNews($news);
                    if ($update == $newsManager::UPDATE) {
                        $this->app->getUser()->setFlash('The News has been updated.');
                    }
                }
                else {
                    $this->app->getUser()->setFlash('Warning: This News doesn\'t exist.');
                }
            }
            else {
                $this->app->getUser()->setFlash('Your Title or Comment or Name is invalid.');
            }
        }

        // Form Construction
        $form = $form->formBuilder();
        $this->page->addVar('form', $form);
    }


    public function executeDelete()
    {
        $newsManager = $this->manager->GetManagerOf('News');

        if (isset($_POST['news'])) {
            $this->page->addVar('alert', 'Are you sure you want to delete this news?');
            $news = $newsManager->getNews(intval($_POST['news']));
            $this->page->addVar('news', $news);
            
            // Form Builder configuration
            $form = new FormBuilder('Comment');
            $form->addField([FormBuilder::HIDDEN => 'delete']);
            $form->addField([FormBuilder::BUTTON => 'delete News']);
            $form->setValues(['delete' => $news->getId()]);

            // Form Construction
            $form = $form->formBuilder();
            $this->page->addVar('form', $form);
        }
        if (isset($_POST['delete'])) {
            $news = $newsManager->getNews(intval($_POST['delete']));
            $newsManager->deleteNews($news);
            $this->app->getUser()->setFlash('The News has been deleted.');
        }

        $this->page->addVar('list', $newsManager->allNews());
    }


    public function executeComments()
    {
        $commentManager = $this->manager->GetManagerOf('Comment');
        $id = $this->app->httpRequest()->GET_data('id');
        $comment = $commentManager->getComment(intval($id));
        $this->page->addVar('comment', $comment);

        // Form Builder configuration
        $form = new FormBuilder('Comment');
        $form->addField([FormBuilder::TEXT => 'body']);
        $form->addField([FormBuilder::STRING => 'author']);
        $form->addField([FormBuilder::HIDDEN => 'id']);
        $form->addField([FormBuilder::BUTTON => 'update']);
        $form->addField([FormBuilder::BUTTON => 'delete']);
        $form->setValues([
            'body' => $comment->getBody(),
            'author' => $comment->getAuthor(),
            'id' => $id
            ]);
        $form->setLabels(['body' => 'Text']);

        // Update
        if (isset($_POST['update']) && !empty($_POST['author']) && !empty($_POST['body']) && !empty($_POST['id'])) {
            $comment = $commentManager->getComment(intval($_POST['id']));
            $comment->hydrate($_POST);
            $comment->setModification_date(new DateTime());
            $update = $commentManager->modifyComment($comment);
            if ($update == $commentManager::UPDATE) {
                $this->app->getUser()->setFlash('The comment has been updated.');
            }
        }
        // Delete
        if (isset($_POST['delete']) && !empty($_POST['id'])) {
            $comment = $commentManager->getComment(intval($_POST['id']));
            $delete = $commentManager->deleteComment($comment);
            if ($delete == $commentManager::DELETE) {
                $this->app->getUser()->setFlash('The comment is deleted.');
            }
        }

        // Form Construction
        $form = $form->formBuilder();
        $this->page->addVar('form', $form);
    }


    public function isValid(array $post)
    {
        foreach ($post as $data) {
            if (empty($data) || !$this->stringValid($data)) {
                return false;
            }
        }
        return true;
    }


    public function exist($title)
    {
        $newsManager = $this->manager->GetManagerOf('News');
        if ($news = $newsManager->newsExist($title)) {
            return $news;
        }
        return false;
    }
}