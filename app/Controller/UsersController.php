<?php

// app/Controller/UsersController.php

class UsersController extends AppController {

   /**
	* @var string[]
	*/
   public $helpers    = array('Html', 'Form', 'Session');
   /**
	* @var string[]
	*/
   var    $uses       = array('Project', 'Time', 'User');
   /**
	* @var string[]
	*/
   public $components = array('Session');

   /*public function beforeFilter() {
	   parent::beforeFilter();
	   $this->Auth->allow('add');
   }*/

   /**
	*
	*/
   public function index() {
	  //$this->User->recursive = 0;
	  //$this->set('users', $this->paginate());
	  $this->redirect("/users/login");
   }

   /**
	*
	*/
   public function beforeFilter() {
	  parent::beforeFilter();
	  // Allow users to register and logout.
	  $this->Auth->allow('add', 'logout');
   }

   /**
	*
	*/
   public function login() {
	  if ($this->request->is('post')) {
		 if ($this->Auth->login()) {
			return $this->redirect($this->Auth->redirect());
			//return $this->redirect('/projects/index');
		 }
		 $this->Session->setFlash(__('Invalid username or password, try again'));
	  }
   }

   /**
	*
	*/
   public function logout() {
	  return $this->redirect($this->Auth->logout());
   }

   /**
	* @param null $id
	*/
   public function view($id = null) {
	  $this->User->id = $id;
	  if (!$this->User->exists()) {
		 throw new NotFoundException(__('Invalid user'));
	  }
	  $this->set('user', $this->User->read(null, $id));
   }

   /**
	*
	*/
   public function add() {
	  if ($this->request->is('post')) {
		 $this->User->create();
		 if ($this->User->save($this->request->data)) {
			$this->Session->setFlash(__('The user has been saved'));
			return $this->redirect(array('action' => 'index'));
		 }
		 $this->Session->setFlash(
			 __('The user could not be saved. Please, try again.')
		 );
	  }
   }

   /**
	* @param null $id
	*/
   public function edit($id = null) {
	  $this->User->id = $id;
	  if (!$this->User->exists()) {
		 throw new NotFoundException(__('Invalid user'));
	  }
	  if ($this->request->is('post') || $this->request->is('put')) {
		 if ($this->User->save($this->request->data)) {
			$this->Session->setFlash(__('The user has been saved'));
			return $this->redirect(array('action' => 'index'));
		 }
		 $this->Session->setFlash(
			 __('The user could not be saved. Please, try again.')
		 );
	  }
	  else {
		 $this->request->data = $this->User->read(null, $id);
		 unset($this->request->data['User']['password']);
	  }
   }

   /**
	* @param int|null $id
	*/
   public function delete($id = null) {
	  $this->request->onlyAllow('post');

	  $this->User->id = $id;
	  if (!$this->User->exists()) {
		 throw new NotFoundException(__('Invalid user'));
	  }
	  if ($this->User->delete()) {
		 $this->Session->setFlash(__('User deleted'));
		 return $this->redirect(array('action' => 'index'));
	  }
	  $this->Session->setFlash(__('User was not deleted'));
	  return $this->redirect(array('action' => 'index'));
   }

}


