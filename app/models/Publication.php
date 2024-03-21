<?php
namespace app\models;

use PDO;

class Publication extends \app\core\Model
{

    public $publication_id; //PK
    public $profile_id; //FK
    public $publication_title;
    public $publication_text;
    public $timestamp;
    public $publication_status;

    //CRUD

    //create
    public function insert()
    {
        $SQL = 'INSERT INTO publication(profile_id,publication_title,publication_text,publication_status) VALUES (:profile_id,:publication_title,:publication_text,:publication_status)';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            [
                'profile_id' => $this->profile_id,
                'publication_title' => $this->publication_title,
                'publication_text' => $this->publication_text,
                'publication_status' => $this->publication_status
            ]
        );
    }

    public function getAll()
    {
        $SQL = 'SELECT * FROM publication';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute();
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();//return all records
    }

    public function getAllPublic()
    {
        $SQL = 'SELECT * FROM publication WHERE publication_status = \'public\' ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute();
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();//return all records
    }

    public function getAllPrivate()
    {
        $SQL = 'SELECT * FROM publication WHERE publication_status = \'private\' ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute();
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();//return all records
    }

    //read
    public function getByPublication($publication_id)
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

    public function getByProfile($profile_id)
    {//search
        $SQL = 'SELECT * FROM publication WHERE profile_id = :profile_id ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            ['profile_id' => $profile_id]
        );
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();//return all records
    }

    public function getTime($publication_id)
    {
        $SQL = 'SELECT timestamp FROM publication where publication_id = :publication_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            ['publication_id' => $this->publication_id]
        );
    }

 
    public function update()
    {
        $SQL = 'UPDATE publication SET publication_title=:publication_title,publication_text=:publication_text,publication_status=:publication_status WHERE publication_id = :publication_id';//add profile_id if we choose to add it
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            [
                'publication_id' => $this->publication_id,
                'publication_title' => $this->publication_title,
                'publication_text' => $this->publication_text,
                // 'timestamp' => $this->timestampp,
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

    public function searchPublicationsGuest($search_term)
    {
        $SQL = 'SELECT * FROM publication WHERE publication_status = \'public\' AND (publication_title LIKE :search_term)';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            [
                'search_term' => '%' . $search_term . '%'
            ]
        );
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();
    }

    public function searchPublicationsLoggedIn($search_term, $profile_id)
    {
        $SQL = 'SELECT * FROM publication WHERE profile_id = :profile_id AND (publication_title LIKE :searchInput OR publication_text LIKE :search_term) ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(
            [
                'profile_id' => $profile_id,
                'search_term' => '%' . $search_term . '%'
            ]
        );
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\Publication');//set the type of data returned by fetches
        return $STMT->fetchAll();
    }
}