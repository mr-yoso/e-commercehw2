<?php

namespace app\controllers;

#[\app\filters\Login]
class Publication extends \app\core\Controller
{
    #[\app\filters\HasProfile]
    public function index()
    {
        $publicationModel = new \app\models\Publication();
        $search_term = isset ($_GET['search']) ? $_GET['search'] : '';
        $publications = [];

        if (!$search_term) {
            // Fetch all publications for both logged in and guest users
            $publications = $publicationModel->getAllPublic();
        } else {
            // Search publications for logged in users
            if ($_SESSION['profile_id']) {
                $publications = $publicationModel->searchPublicationsLoggedIn($search_term, $_SESSION['profile_id']);
            } else {
                // Search publications for guest users
                $publications = $publicationModel->searchPublicationsGuest($search_term);
            }
        }

        $this->view('Publication/index', ['publications' => $publications]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {//data is submitted through method POST
            //make a new profile object
            $publication = new \app\models\Publication();
            //populate it
            $publication->profile_id = $_SESSION['profile_id'];
            $publication->publication_title = $_POST['publication_title'];
            $publication->publication_text = $_POST['publication_text'];
            //check to see if we add timestamp here
            $publication->publication_status = $_POST['publication_status'];
            //insert it
            $publication->insert();
            //redirect
            header('location:/Publication/index');
        } else {
            $this->view('Publication/create');
        }
    }

    //readjust this
    public function delete()
    {
        //present the user with a form to confirm the deletion that is requested and delete if the form is submitted
        /*		//make sure that the user is logged in
            if(!isset($_SESSION['user_id'])){
                header('location:/User/login');
                return;
            }
        */
        $publication = new \app\models\Publication();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publication->profile_id = $_SESSION['profile_id'];
            $publication->delete();
            header('location:/Publication/index');
        } else {
            $this->view('Publication/delete', $publication);
        }
    }

    public function modify()
    {
        $publicationModel = new \app\models\Publication();
        $publication = $publicationModel->getByPublication($_SESSION['publication_id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publication->publication_title = $_POST['publication_title'];
            $publication->publication_text = $_POST['publication_text'];
            $publication->publication_status = $_POST['publication_status'];
            //insert it
            $publication->update();

            header('location:/Publication/index');
        } else {
            $this->view('Publication/modify', $publication);
        }
    }
}
