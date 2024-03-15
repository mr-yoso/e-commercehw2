<?php
namespace app\models;

use PDO;

class Publication extends \app\core\Model
{

    public $publication_id;//PK
    public $profile_id;
    public $publication_title;
    public $publication_text;
    public $timestampp;
    public $publication_status;

    //CRUD

    //create
    public function insert()
    {
        $SQL = 'INSERT INTO publication(profile_id,publication_title;,publication_text,timestamp,publication_status) VALUE (:profile_id,:publication_title;,:publication_text,:timestampp,:publication_status)';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            [
                'profile_id' => $this->profile_id,
                'publication_title' => $this->publication_title,
                'publication_text' => $this->publication_text,
                'timestamp' => $this->timestampp,
                'publication_status' => $this->publication_status
            ]
        );
    }

    //read
    public function getForUser($publication_id)
    {
        $SQL = 'SELECT * FROM publication WHERE publication_id = :publication_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            ['publication_id' => $publication_id]
        );
        //there is a mistake in the next line
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetch();//return (what should be) the only record
    }

    public function getAll()
    {
        $SQL = 'SELECT * FROM publication';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute();
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();//return all records
    }

    public function getByProfile($name)
    {//search
        $SQL = 'SELECT * FROM publication WHERE profile_id = :profile_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            ['profile_id' => $profile_id]
        );
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Profile');//set the type of data returned by fetches
        return $STMT->fetchAll();//return all records
    }


    //update
    //you can't change the user_id that's a business logic choice that gets implemented in the model
    public function update()
    {
        $SQL = 'UPDATE profile SET profile_id=:profile_id,publication_title=:publication_title,publication_text=:publication_text,timestamp=:timestamp,publication_status=:publication_status WHERE publication_id = :publication_id';//add profile_id if we choose to add it
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            [
                'profile_id' => $this->profile_id,//recheck to see if we'll keep this as part of the update
                'publication_title' => $this->publication_title,
                'publication_text' => $this->publication_text,
                'timestamp' => $this->timestampp,
                'publication_status' => $this->publication_status
            ]
        );
    }

    //delete
    public function delete()
    {
        $SQL = 'DELETE FROM publication WHERE publication_id = :publication_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            ['publication_id' => $this->publication_id]
        );
    }


}