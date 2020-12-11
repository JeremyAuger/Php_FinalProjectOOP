<?php

namespace App\Frontend\Modules\News;

use OCFramework\BackController;
use DateTime;
use Entity\Comment;
use OCFramework\FormBuilder\FormBuilder;

class NewsController extends BackController
{

    public function executeIndex()
    {
        $numberOfNews = intval($this->app->getconfig()->get('number_of_news'));
        $numberOfCharacters = intval($this->app->getconfig()->get('number_of_characters'));

        $newsManager = $this->manager->GetManagerOf('News');
        $list = $newsManager->lastNews($numberOfNews);
        foreach ($list as $news) {
            $news->setBody(mb_strimwidth($news->getBody(), 0, $numberOfCharacters, '...'));
        }
        $this->page->addVar('title', 'LAST ' .$numberOfNews. ' NEWS :');
        $this->page->addVar('list', $list);
    }


    public function executeNews()
    {
        $newsManager = $this->manager->GetManagerOf('News');
        $news = $newsManager->getNews($_GET['id']);
        $this->page->addVar('news', $news);

        $commentManager = $this->manager->GetManagerOf('Comment');
        $comments = $commentManager->newsComment($news);
        $this->page->addVar('comments', $comments);
    }


    public function executeComment()
    {
        // Data required
        $newsManager = $this->manager->GetManagerOf('News');
        $news = $newsManager->getNews($_GET['news']);
        $comment = new Comment();
        $newsTitle = $news->getTitle();
        $this->page->addVar('title', $newsTitle);

        // Form Builder configuration
        $form = new FormBuilder('Comment');
        $form->addField([FormBuilder::STRING => 'author']);
        $form->addField([FormBuilder::TEXT => 'body']);
        $form->addField([FormBuilder::BUTTON => 'ok']);
        
        // Form sent by User
        if (isset($_POST['author'], $_POST['body'])) {
            // Incorrect form = Index page pre-filled from previous attempt
            if (empty($author = $_POST['author']) || empty($body = $_POST['body'])
            || !$this->stringValid($author) || !$this->stringValid($body))
            {
                $this->app->getUser()->setFlash('Your Pseudo or Comment is invalid');
                $form->setValues(['author' => $author, 'body' => $body]);
            }
            else { // Comment insert in DB and display index with flash msg
                $publication_date = new DateTime();
                $newsId = $news->getId();
                $comment = new Comment(compact('newsId', 'author', 'body', 'publication_date'));
                $commentManager = $this->manager->GetManagerOf('Comment');
                $add = $commentManager->addComment($comment);
                switch ($add) {
                    case ($add == \Model\CommentManagerPDO::ADD):
                        $this->app->getUser()->setFlash('Your comment has been posted');
                        break;
                    case ($add == \Model\CommentManagerPDO::EXIST):
                        $this->app->getUser()->setFlash('This comment already exist.');
                        break;
                    case ($add == \Model\CommentManagerPDO::COMPLETE):
                        $this->app->getUser()->setFlash('Every fields must be completed.');
                        break;
                }                
            }
        }

        // Form Construction
        $form = $form->formBuilder();
        $this->page->addVar('form', $form);
    }
}