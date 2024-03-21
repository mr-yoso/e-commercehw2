<?php

namespace app\controllers;

class Publication extends \app\core\Controller{

    public function index($publication_id)
    {
        $commentModel = new \app\models\PublicationComment();
        $comments = $commentModel->getByPublication($publication_id);
        $this->view('Publication/index', ['comments' => $comments, 'publication_id' => $publication_id]);
    }

    #[\app\filters\HasProfile]
    public function create($publication_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['profile_id'])) {
            $comments = new \app\models\PublicationComment();
            $comments->profile_id = $_SESSION['profile_id'];
            $comments->publication_id = $publication_id;
            $comments->comment = $_POST['comment'];
            $comments->insert();

            header("Location: /Publication/index/$publication_id");
        } else {
            $this->view('Publication/create', ['publication_id' => $publication_id]);
        }



    }

    public function delete($comment_id)
    {
        $commentModel = new \app\models\PublicationComment();
        $comment = $commentModel->getById($comment_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $comment && $comment->profile_id == $_SESSION['profile_id']) {
            $commentModel->delete($comment_id);
            header("Location: /Publication/index/{$comment->publication_id}");
        } else {
            $this->view('Publication/delete', ['comment' => $comment]);
        }
    }

    #[\app\filters\HasProfile]
    public function modify($comment_id)
    {
        $commentModel = new \app\models\PublicationComment();
        $comment = $commentModel->getById($comment_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $comment && $comment->profile_id == $_SESSION['profile_id']) {
            $comment->comment_text = $_POST['comment_text'];
            $comment->update();

            header("Location: /Publication/index/{$comment->publication_id}");
        } else {
            $this->view('Publication/modify', ['comment' => $comment]);
        }
    }
}
