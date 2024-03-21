<?php
namespace app\controllers;


#[\app\filters\Login]
class Profile extends \app\core\Controller
{
	#[\app\filters\HasProfile]
	public function index()
	{
		$profileModel = new \app\models\Profile();
		$profile = $profileModel->getForUser($_SESSION['user_id']);

	
		$this->view('Profile/index', ['profile' => $profile]);
	}


	public function create()
	{
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$user_id = $_SESSION['user_id'];

			if ($user_id) {
				$profile = new \app\models\Profile();
				
				$profile->user_id = $user_id;
				$profile->first_name = $_POST['first_name'];
				$profile->middle_name = $_POST['middle_name'];
				$profile->last_name = $_POST['last_name'];
				
				$profile->insert();

				$_SESSION['profile_id'] = $profile->profile_id;
			
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

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$profile->first_name = $_POST['first_name'];
			$profile->middle_name = $_POST['middle_name'];
			$profile->last_name = $_POST['last_name'];
			
			$profile->update();
			
			header('location:/Profile/index');
		} else {
			$this->view('Profile/modify', $profile);
		}
	}

	public function delete()
	{

		$profile = new \app\models\Profile();
		$profile = $profile->getForUser($_SESSION['user_id']);
		

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			
			$profile->delete();

			unset($_SESSION['profile_id']);

			header('location:/Profile/index');
		} else {
			$this->view('Profile/delete', $profile);
		}
	}
}