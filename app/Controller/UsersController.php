<?php /** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection PhpUnused */

/**
 * UsersController
 */
class UsersController extends AppController
{

	/**
	 * @var array
	 */
	public $helpers = array('Html', 'Form', 'Session');
	/**
	 * @var array
	 */
	public $uses = array('Project', 'Time', 'User');
	/**
	 * @var array
	 */
	public $components = array('Session');

	/**
	 * index
	 *
	 * @return void
	 */
	public function index()
	{
		//$this->User->recursive = 0;
		//$this->set('users', $this->paginate());
		$this->redirect("/users/login");
	}

	/**
	 * beforeFilter
	 *
	 * @return void
	 */
	public function beforeFilter()
	{
		parent::beforeFilter();
		// Allow users to register and logout.
		$this->Auth->allow('add', 'logout');
	}

	/**
	 * login
	 *
	 * @return void
	 */
	public function login()
	{
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->redirect($this->Auth->redirect());
				//return $this->redirect('/projects/index');
			}
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}

	/**
	 * logout
	 *
	 * @return void
	 */
	public function logout()
	{
		$this->redirect($this->Auth->logout());
	}

	/**
	 * view
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function view($id = null)
	{
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

	/**
	 * add
	 *
	 * @return void
	 */
	public function add()
	{
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
	 * edit
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function edit($id = null)
	{
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
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
	}

	/**
	 * delete
	 *
	 * @param mixed $id
	 * @return void
	 */
	public function delete($id = null)
	{
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
