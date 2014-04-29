<?php

// Docs and resources
// http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/part-two.html
// http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
// http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
// http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
// http://book.cakephp.org/2.0/en/models/retrieving-your-data.html
// http://book.cakephp.org/2.0/en/models/retrieving-your-data.html
// http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
// http://www.iconarchive.com/search?q=statistic
// http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html

#App::uses('CakeSession', 'Model/Datasource');

class ProjectsController extends AppController {

    public $helpers = array('Html', 'Form', 'Session');
    var $uses = array('Project','Time','User');
	public $components = array('Session');

    public function index() {
			
		/*echo $user_id = CakeSession::read('Auth.User.id');
		die();
			
		if (!$user_id){
			$this->redirect("/users/login");
		}*/
	
		/*$params = array(
			'conditions' => array('Model.field' => $thisValue), //array of conditions
			'recursive' => 1, //int
			//array of field names
			'fields' => array('Model.field1', 'DISTINCT Model.field2'),
			//string or array defining order
			'order' => array('Model.created', 'Model.field3 DESC'),
			'group' => array('Model.field'), //fields to GROUP BY
			'limit' => n, //int
			'page' => n, //int
			'offset' => n, //int
			'callbacks' => true //other possible values are false, 'before', 'after'
		);*/
		$params = array(
			'conditions' => array('Project.user_id' => $this->Auth->user('id')), //array of conditions
			'recursive' => 1, //int
			'order' => array('Project.name ASC')
		);
        $this->set('projects', $this->Project->find('all',$params));
    }
	
	public function plist() {
		$params = array(
			'conditions' => array('Project.user_id' => $this->Auth->user('id')), //array of conditions
			'recursive' => 1, //int
			'order' => array('Project.name ASC')
		);
        $this->set('projects', $this->Project->find('all',$params));
    }	
	
	 public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Project->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('project', $post);
    }
	
	public function add() {
        if ($this->request->is('post')) {
            $this->Project->create();
            if ($this->Project->save($this->request->data)) {
                $this->Session->setFlash(__('Your Project has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }
	
	public function edit($id = null) {
		if (!$id) {
			throw new NotFoundException(__('Invalid Project'));
		}

		$project = $this->Project->findById($id);
		if (!$project) {
			throw new NotFoundException(__('Invalid Project'));
		}
		else{
			$this->set('project', $project);
		}

		if ($this->request->is(array('post', 'put'))) {
			$this->Project->id = $id;
			if ($this->Project->save($this->request->data)) {
				$this->Session->setFlash(__('Your Project has been updated.'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('Unable to update your Project.'));
		}
		
		if (!$this->request->data) {
			$this->request->data = $project;
		}
	}
	
	public function delete($id) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		if ($this->Project->delete($id)) {
			$this->Session->setFlash(
				__('The post with id: %s has been deleted.', h($id))
			);
			return $this->redirect(array('action' => 'index'));
		}
	}
		
		
	/**
	* Management Functions
	*
	*
	*
	*/
		
	public function showstats(){
		$params = array(
			'conditions' => array('Project.user_id' => $this->Auth->user('id')), //array of conditions
			'recursive' => 1, //int
			'order' => array('Project.name ASC')
		);
		$projects = $this->Project->find('all',$params);
		
		$todayDateStart = date("Y-m-d 00:00:01");
		$todayDateEnd 	= date("Y-m-d 23:59:00");
		
		$todayUnixStart = strtotime($todayDateStart);
		$todayUnixEnd 	= strtotime($todayDateEnd);
		
		foreach($projects as $project){
			$res = $this->Time->query(
			'SELECT sum(`unixDiff`) as seconds FROM `times` 
			WHERE `project_id` = '.$project["Project"]["id"].' 
			AND `user_id`='.$this->Auth->user('id').' 
			AND `startUnix` > '.$todayUnixStart.' 
			AND `stopUnix` < '.$todayUnixEnd.' '
			);
			//$report[] = $project["Project"]["name"]." :: " .date('H:i:s', $res[0][0]["seconds"]). " :: " .$res[0][0]["seconds"] ;	
			$report[] = $project["Project"]["name"]." :: " .gmdate('H:i:s', $res[0][0]["seconds"]);				
		}
		
		$this->set('report',$report);		
	}
	
	public function showstatsall(){
		$params = array(
			'conditions' => array('Project.user_id' => $this->Auth->user('id')), //array of conditions
			'recursive' => 1, //int
			'order' => array('Project.name ASC')
		);
		$projects = $this->Project->find('all',$params);
		
		$todayDateStart = date("Y-m-d 00:00:01");
		$todayDateEnd 	= date("Y-m-d 23:59:00");
		
		$todayUnixStart = strtotime($todayDateStart);
		$todayUnixEnd 	= strtotime($todayDateEnd);
		
		foreach($projects as $project){
			$res = $this->Time->query(
			'SELECT sum(`unixDiff`) as seconds FROM `times` 
			WHERE `project_id` = '.$project["Project"]["id"].' 
			AND `user_id`='.$this->Auth->user('id').' 
			#AND `startUnix` > '.$todayUnixStart.' 
			#AND `stopUnix` < '.$todayUnixEnd.' '
			);
			//$report[] = $project["Project"]["name"]." :: " .date('H:i:s', $res[0][0]["seconds"]). " :: " .$res[0][0]["seconds"] ;	
			$report[] = $project["Project"]["name"]." :: " .gmdate('H:i:s', $res[0][0]["seconds"]);				
		}
		
		$this->set('report',$report);		
	}
	
	

    public function savetime($id) {

       $this->layout = "ajax";
       $arUnixStart = explode("|",$this->request->data('unixStart'));
       $arUnixEnd = explode("|",$this->request->data('unixEnd'));
       $sUnixDiff = $this->request->data('unixDiff');
 
       $this->data = array(
           "project_id" =>  $id,
           "start"      =>  date("Y-m-d")." ".$arUnixStart[1],
           "startUnix"  =>  $arUnixStart[0],
           "stop"       =>  date("Y-m-d")." ".$arUnixEnd[1],
           "stopUnix"  =>  $arUnixEnd[0],
           "date"       => date("Y-m-d H:i:s"),
           "user_id"    => $this->Auth->user('id'),
           "unixDiff"   => $sUnixDiff
       );

       // print_r($this->data);
       $this->Time->save($this->data);

    }

    public function isAuthorized($user) {
        // All registered users can add posts
        if ($this->action === 'add') {
            return true;
        }

        // The owner of a post can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $postId = (int) $this->request->params['pass'][0];
            if ($this->Post->isOwnedBy($postId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }



}



