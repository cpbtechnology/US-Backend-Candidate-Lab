<?php
namespace App\Controllers;

require_once 'core/controller.php';
require_once 'core/response.php';

require_once 'app/models/note.php';
require_once 'app/models/user.php';

use Core\Http403;
use Core\Http404;
use Core\JSONResponse;
use App\Models\Note;
use App\Models\User;

class Notes extends \Core\Controller {
    public function get($id) {
        $user = User::login($this->request->get['user'], $this->request->get['token']);
        if (!$user)
            throw new Http403;
        $note = Note::get($id);
        if (!$note)
            throw new Http404;
        if ($note->user_id != $user->id)
            throw new Http403;
        return new JSONResponse([
            'id' => $note->id,
            'title' => $note->title,
            'description' => $note->description,
        ]);
    }
}
