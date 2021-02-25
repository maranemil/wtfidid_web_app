<?php

App::uses('AppModel', 'Model');

class Project extends AppModel {
   public $validate = array(
	   'name' => array(
		   'rule' => 'notEmpty'
	   )
	   /*'body' => array(
		   'rule' => 'notEmpty'
	   )*/
   );
}
