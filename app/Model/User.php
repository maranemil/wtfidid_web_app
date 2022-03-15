<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * User
 */
class User extends AppModel
{

	/**
	 * validate
	 *
	 * @var array
	 */
	public $validate
		= array(
			// Validation::notEmpty() is deprecated. Use Validation::notBlank() instead.
			'username' => array(
				'required' => array(
					'rule'    => array('notBlank'),
					'message' => 'A username is required',
				),
			),
			'password' => array(
				'required' => array(
					'rule'    => array('notBlank'),
					'message' => 'A password is required',
				),
			),
			'role'     => array(
				'valid' => array(
					'rule'       => array('inList', array('admin', 'author')),
					'message'    => 'Please enter a valid role',
					'allowEmpty' => false,
				),
			),
		);

	/**
	 * beforeSave
	 *
	 * @param mixed $options
	 * @return void
	 */
	public function beforeSave($options = array())
	{
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
	}

}
