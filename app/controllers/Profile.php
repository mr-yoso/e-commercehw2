<?php
namespace app\controllers;

//applying the Login condition to the whole class
#[\app\filters\Login]
class Profile extends \app\core\Controller
{
	#[\app\filters\HasProfile]
	public function index()
	{
		$profileModel = new \app\models\Profile();
		$profile = $profileModel->getForUser($_SESSION['user_id']);

		$publicationModel = new \app\models\Publication();
		$privatePublications = $publicationModel->getByProfile($_SESSION['profile_id']);

		$this->view('Profile/index', ['profile' => $profile, 'privatePublications' => $privatePublications]);
	}


	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {//data is submitted through method POST
			//make a new profile object

			$user_id = $_SESSION['user_id'];

			if ($user_id) {
				$profile = new \app\models\Profile();
				//populate it
				$profile->user_id = $user_id;
				$profile->first_name = $_POST['first_name'];
				$profile->middle_name = $_POST['middle_name'];
				$profile->last_name = $_POST['last_name'];
				//insert it
				$profile->insert();

				$_SESSION['profile_id'] = $profile->profile_id;
				//redirect
				header('location:/Publication/index');
			}
		} else {
			$this->view('Profile/create');
		}
	}

	public function modify()
	{
		$profile = new \app\models\Profile();
		$profile = $profile->getForUser($_SESSION['user_id']);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {//data is submitted through method POST
			//make a new profile object
			//populate it
			$profile->first_name = $_POST['first_name'];
			$profile->middle_name = $_POST['middle_name'];
			$profile->last_name = $_POST['last_name'];
			//update it
			$profile->update();
			//redirect
			header('location:/Profile/index');
		} else {
			$this->view('Profile/modify', $profile);
		}
	}

	public function delete()
	{
		//present the user with a form to confirm the deletion that is requested and delete if the form is submitted
/*		//make sure that the user is logged in
		if(!isset($_SESSION['user_id'])){
			header('location:/User/login');
			return;
		}
*/
		$profile = new \app\models\Profile();
		$profile = $profile->getForUser($_SESSION['user_id']);
		// $publication = new \app\models\Publication();
		// $publication = $publication->getByProfile($_SESSION['user_id']);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// $publication->delete();
			$profile->delete();

			unset($_SESSION['profile_id']);

			header('location:/Profile/index');
		} else {
			$this->view('Profile/delete', $profile);
		}
	}
}