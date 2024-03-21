<?php

namespace app\controllers;

class Publication extends \app\core\Controller
{
    public function index()
    {
        $publicationModel = new \app\models\Publication();
        $search_term = isset ($_GET['search']) ? $_GET['search'] : '';
        $publications = [];
        $commentModel = new \app\models\PublicationComment();
        $comments = [];
        if (!$search_term) {
            $publications = $publicationModel->getAllPublic();
        } else {
            if ($_SESSION['profile_id']) {
                $publications = $publicationModel->searchPublicationsLoggedIn($search_term, $_SESSION['profile_id']);
                $commentModel->getByPublication($publication_id);
                $comments = $commentModel;
            } else {
                $publications = $publicationModel->searchPublicationsGuest($search_term);
                $commentModel->getByPublication($publication_id);
                $comments = $commentModel;
            }
        }
        $this->view('Publication/index', ['publications' => $publications,'comments'=>$comments]);
    }
    #[\app\filters\HasProfile]
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publication = new \app\models\Publication();

            if (!isset ($_SESSION['profile_id'])) {
                header('Location: /User/login');
                exit;
            }

            $publication->profile_id = $_SESSION['profile_id'];
            $publication->publication_title = $_POST['publication_title'];
            $publication->publication_text = $_POST['publication_text'];
            $publication->publication_status = $_POST['publication_status'];
            $publication->insert();
            header('location:/Publication/index');
        } else {
            $this->view('Publication/create');
        }
    }

    #[\app\filters\HasProfile]
    public function delete($publication_id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publication = new \app\models\Publication();
            $publication->publication_id = $publication_id;
            $publication->delete();
            header('location:/Publication/index');
        } else {
            $this->view('Publication/delete', ['publication_id' => $publication_id]);
        }
    }

    #[\app\filters\HasProfile]
    public function modify($publication_id)
    {
        $publicationModel = new \app\models\Publication();
        $publication = $publicationModel->getByPublication($publication_id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publication->publication_title = $_POST['publication_title'];
            $publication->publication_text = $_POST['publication_text'];
            $publication->publication_status = $_POST['publication_status'];
            $publication->update();

            header('location:/Publication/index');
        } else {
            $this->view('Publication/modify', ['publication' => $publication]);
        }
    }
}
