<?php

namespace app\models;

use PDO;

class PublicationComment extends \app\core\Model {
    public $publication_comment_id; // PK
    public $profile_id; // FK to profile
    public $publication_id; // FK to publication
    public $comment_text;
    public $timestamp;

    // Insert a new comment
    public function insert()
    {
        $SQL = 'INSERT INTO publication_comment (profile_id, publication_id, comment_text, timestamp) VALUES (:profile_id, :publication_id, :comment_text, NOW())';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'profile_id' => $this->profile_id,
            'publication_id' => $this->publication_id,
            'comment_text' => $this->comment_text
        ]);
        $this->publication_comment_id = self::$_conn->lastInsertId();
    }

    // Get all comments for a publication
    public function getByPublication($publication_id)
    {
        $SQL = 'SELECT * FROM publication_comment WHERE publication_id = :publication_id ORDER BY timestamp DESC';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['publication_id' => $publication_id]);
        $STMT->setFetchMode(PDO::FETCH_CLASS, 'app\models\PublicationComment');
        return $STMT->fetchAll();
    }

    // Update a comment (assuming the user can only update the text of their comment)
    public function update()
    {
        $SQL = 'UPDATE publication_comment SET comment_text = :comment_text WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute([
            'comment_text' => $this->comment_text,
            'publication_comment_id' => $this->publication_comment_id
        ]);
    }

    // Delete a comment
    public function delete()
    {
        $SQL = 'DELETE FROM publication_comment WHERE publication_comment_id = :publication_comment_id';
        $STMT = self::$_conn->prepare($SQL);
        $STMT->execute(['publication_comment_id' => $this->publication_comment_id]);
    }
}