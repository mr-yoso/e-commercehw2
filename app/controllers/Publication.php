<?php

namespace app\controllers;

#[\app\filters\Login]
class Publication extends \app\core\Controller
{
    #[\app\filters\HasProfile]

    public function index()
    {
        $profile_id = $_SESSION['profile_id'];

        $publication = new \app\models\Publication();

        $this->view('Publication/index', $publication);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {//data is submitted through method POST
            $profile_id = $_SESSION['user_id'];

            if ($profile_id) {
                //make a new profile object
                $publication = new \app\models\Publication();
                //populate it
                $publication->profile_id = $profile_id;
                $publication->publication_title = $_POST['publication_title'];
                $publication->publication_text = $_POST['publication_text'];
                //check to see if we add timestamp here
                $publication->publication_status = $_POST['publication_status'];
                //insert it
                $publication->insert();
                //redirect
                header('location:/Profile/create');
            }
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
        $publication = $publication->getForUser($_SESSION['publication_id']);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $publication->delete();
            header('location:/Publication/index');
        } else {
            $this->view('Publication/delete', $publication);
        }
    }

}
