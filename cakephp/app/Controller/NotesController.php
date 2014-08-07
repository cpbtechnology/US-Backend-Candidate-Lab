<?php
App::uses('AppController', 'Controller');
/**
 * Notes Controller
 *
 * @property Note $Note
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class NotesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session','RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		
		
	$this->Note->recursive = 0;
$this->set('notes', $this->Paginator->paginate(array('Note.user_id like'=>$this->Auth->user('id'))));
		 $this->set('_serialize', array('notes'));

	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Note->exists($id)) {
			throw new NotFoundException(__('Invalid note'));
		}
		$options = array('conditions' => array('Note.' . $this->Note->primaryKey => $id));
		
		$this->set('note', $this->Note->find('first', $options));
		 $this->set('_serialize', array('note'));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
		 //Add the user's id to each post
        $this->request->data['Note']['user_id'] = $this->Auth->user('id');
			$this->Note->create();
			if ($this->Note->save($this->request->data)) {
				$this->Session->setFlash(__('The note has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The note could not be saved. Please, try again.'));
			}
		}
	/*
	$users = $this->Note->User->find('list');
		$this->set(compact('users'));
*/
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Note->exists($id)) {
			throw new NotFoundException(__('Invalid note'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Note->save($this->request->data)) {
				$this->Session->setFlash(__('The note has been saved.'));
				 $message = 'Saved';
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The note could not be saved. Please, try again.'));
				  $message = 'Error';
			}
		$this->set(array(
            'message' => $message,
            '_serialize' => array('message')
        ));
    

		} else {
			$options = array('conditions' => array('Note.' . $this->Note->primaryKey => $id));
			$this->request->data = $this->Note->find('first', $options);
			// $this->set('_serialize', array('note'));
		}
		/*
$users = $this->Note->User->find('list');
		$this->set(compact('users'));
		
		*/
			}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Note->id = $id;
		if (!$this->Note->exists()) {
			throw new NotFoundException(__('Invalid note'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Note->delete()) {
			$this->Session->setFlash(__('The note has been deleted.'));
		} else {
			$this->Session->setFlash(__('The note could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	
	/*
	*Secure edits
	*/
	public function isAuthorized($user) {
    // All registered users can add posts
    if ($this->action == 'add') {
        return true;
    }

   if ($this->action == 'index') {
        return true;
    }

    // The owner of a note can edit and delete it
    if (in_array($this->action, array('edit', 'delete'))) {
        $postId = (int) $this->request->params['pass'][0];
        if ($this->Note->isOwnedBy($postId, $user['id'])) {
            return true;
        }
    }

    return parent::isAuthorized($user);
}

}
