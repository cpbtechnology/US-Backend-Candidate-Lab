<?php
namespace App\Models;

require_once 'core/model.php';

class Note extends \Core\Model {
    public static function get($id) {
        $query = self::$db->prepare('SELECT * FROM `notes` WHERE `id` = :id');
        $query->execute([':id' => $id]);
        return $query->fetchObject();
    }
}
