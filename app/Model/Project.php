<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

App::uses('AppModel', 'Model');

/**
 * Project
 */
class Project extends AppModel
{
	/**
	 * validate
	 *
	 * @var array
	 */
	public $validate
		= array(
			'name' => array(
				'rule' => 'notBlank',
			),
			/*'body' => array(
		'rule' => 'notEmpty'
		)*/
		);
}
