<?php
namespace App\Models;

require_once 'core/model.php';

class User extends \Core\Model {
    public static function login($login, $token) {
        $query = self::$db->prepare('SELECT * FROM `users` WHERE `login` = :login AND `token` = :token');
        $query->execute([':login' => $login, ':token' => $token]);
        return $query->fetchObject();
    }
}
