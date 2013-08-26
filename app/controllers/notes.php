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
        $user = $this->getUser();
        $note = $this->getNote($id);
        $this->checkPermission($user, $note);
        return new JSONResponse([
            'id' => $note->id,
            'title' => $note->title,
            'description' => $note->description,
        ]);
    }

    public function update($id) {
        $this->requirePOST();
        $user = $this->getUser();
        $note = $this->getNote($id);
        $this->checkPermission($user, $note);
        $note->title = $this->request->post['title'];
        $note->description = $this->request->post['description'];
        $note->save();
        return new JSONResponse([
            'status' => 'success',
        ]);
    }

    public function delete($id) {
        $this->requirePOST();
        $user = $this->getUser();
        $note = $this->getNote($id);
        $this->checkPermission($user, $note);
        $note->delete();
        return new JSONResponse([
            'status' => 'success'
        ]);
    }

    public function create() {
        $this->requirePOST();
        $user = $this->getUser();
        $note = new Note();
        $note->user_id = $user->id;
        $note->title = $this->request->post['title'];
        $note->description = $this->request->post['description'];
        $note->save();
        return new JSONResponse([
            'id' => $note->id,
        ]);
    }

    protected function getUser() {
        $user = User::login($this->request->get['user'], $this->request->get['token']);
        if (!$user)
            throw new Http403;
        return $user;
    }

    protected function getNote($id) {
        $note = Note::get($id);
        if (!$note)
            throw new Http404;
        return $note;
    }

    protected function checkPermission($user, $note) {
        if ($note->user_id != $user->id)
            throw new Http403;
    }
}
