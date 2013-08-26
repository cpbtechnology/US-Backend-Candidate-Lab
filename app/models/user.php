<?php
namespace App\Models;

require_once 'core/model.php';

class User extends \Core\Model {
    protected $_original_password;

    public function __construct() {
        $this->_original_password = $this->password;
    }

    public static function login($login, $token) {
        $query = self::$db->prepare('SELECT * FROM `users` WHERE `login` = :login AND `token` = :token');
        $query->execute([':login' => $login, ':token' => $token]);
        return $query->fetchObject('App\\Models\\User');
    }

    public function save() {
        if (!$this->id) {
            $salt = self::generateSalt();
            $password_hash = crypt($this->password, '$2a$06$'. $salt . '$');
            $token = self::generateSalt();
            $query = self::$db->prepare('INSERT INTO `users` (`login`, `password`, `token`) VALUES (:login, :password, :token)');
            $query->execute([
                ':login' => $this->login,
                ':password' => $password_hash,
                ':token' => $token,
            ]);
            $this->id = self::$db->lastInsertId();
        }
        else {
            $password_hash = $this->password;
            if ($password_hash != $this->_original_password) {
                $salt = self::generateSalt();
                $password_hash = crypt($this->password, '$2a$06$'. $salt . '$');
            }
            $query = self::$db->prepare('UPDATE `users` SET `login` = :login, `password` = :password, `token` = :token WHERE `id` = :id');
            $query->execute([
                ':id' => $this->id,
                ':login' => $this->login,
                ':password' => $password_hash,
                ':token' => $token,
            ]);
        }
    }

    public static function generateSalt() {
        return str_replace('.', '', uniqid('', true));
    }
}
