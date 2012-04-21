<?php
App::uses('AppController', 'Controller');
/**
 * Todos Controller
 *
 * @property Todo $Todo
 */
class TodosController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Todo->recursive = 0;
		$this->paginate = array('limit' => 15, 'page' => 1, 'conditions' => array('user_id' => $this->Auth->user('id')), 'order'=>array('done'=>'asc'));
		$this->set('todos', $this->paginate());
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->redirect(array('action' => 'index'));
		$this->Todo->id = $id;
		if (!$this->Todo->exists()) {
			throw new NotFoundException(__('Invalid todo'));
		}
		$this->set('todo', $this->Todo->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Todo->create();
			$this->request->data['done'] = 0;
			$this->request->data['user_id'] = $this->Auth->user('id');
			if ($this->Todo->save($this->request->data)) {
				$this->Session->setFlash(__('The todo has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The todo could not be saved. Please, try again.'));
			}
		}
		$users = $this->Todo->User->find('list');
		$this->set(compact('users'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Todo->id = $id;
		$instance = $this->Todo->find('first', array('conditions' => array('Todo.id' => $id)));
		if ($instance['User']['id'] !== $this->Auth->user('id')) throw new NotFoundException(__('Access Not Allowed'));
		if (!$this->Todo->exists()) {
			$this->redirect(array('action' => 'index'));
			throw new NotFoundException(__('Invalid todo'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Todo->save($this->request->data)) {
				$this->Session->setFlash(__('The todo has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The todo could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Todo->read(null, $id);
		}
		$users = $this->Todo->User->find('list');
		$this->set(compact('users'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$instance = $this->Todo->find('first', array('conditions' => array('Todo.id' => $id)));
		if ($instance['User']['id'] !== $this->Auth->user('id')) throw new NotFoundException(__('Access Not Allowed'));
		$this->Todo->id = $id;
		if (!$this->Todo->exists()) {
			throw new NotFoundException(__('Invalid todo'));
		}
		if ($this->Todo->delete()) {
			$this->Session->setFlash(__('Todo deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Todo was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
