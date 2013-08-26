<?php
namespace App\Controllers;

require_once 'core/controller.php';
require_once 'core/response.php';

require_once 'app/models/user.php';

use Core\Http403;
use Core\Http404;
use Core\JSONResponse;
use App\Models\User;

class Users extends \Core\Controller {
    public function create() {
        $this->requirePOST();
        $user = new User;
        $user->login = $this->request->post['login'];
        $user->password = $this->request->post['password'];
        $user->save();
        return new JSONResponse([
            'token' => $user->token,
        ]);
    }
}
