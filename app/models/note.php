<?php
namespace App\Models;

require_once 'core/model.php';

class Note extends \Core\Model {
    public static function get($id) {
        $query = self::$db->prepare('SELECT * FROM `notes` WHERE `id` = :id');
        $query->execute([':id' => $id]);
        return $query->fetchObject('App\\Models\\Note');
    }

    public function save() {
        if (!$this->id) {
            $query = self::$db->prepare('INSERT INTO `notes` (`user_id`, `title`, `description`) VALUES (:user_id, :title, :description)');
            $query->execute([
                ':user_id' => $this->user_id,
                ':title' => $this->title,
                ':description' => $this->description,
            ]);
            $this->id = self::$db->lastInsertId();
        }
        else {
            $query = self::$db->prepare('UPDATE `notes` SET `title` = :title, `description` = :description WHERE `id` = :id');
            $query->execute([
                ':id' => $this->id,
                ':title' => $this->title,
                ':description' => $this->description,
            ]);
        }
    }

    public function delete() {
        if (!$this->id)
            throw new \Exception('This note was not saved yet, so it cannot be deleted');

        $query = self::$db->prepare('DELETE FROM `notes` WHERE `id` = :id');
        $query->execute([':id' => $this->id]);
    }
}
