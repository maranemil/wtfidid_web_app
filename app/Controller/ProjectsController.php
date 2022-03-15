<?php /** @noinspection PhpMultipleClassDeclarationsInspection */
/** @noinspection SqlNoDataSourceInspection */
/** @noinspection SqlDialectInspection */
/** @noinspection PhpUnused */

// Docs and resources
/*
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/part-two.html
http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
http://book.cakephp.org/2.0/en/core-libraries/components/authentication.html
http://book.cakephp.org/2.0/en/models/retrieving-your-data.html
http://book.cakephp.org/2.0/en/models/retrieving-your-data.html
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
http://www.iconarchive.com/search?q=statistic
http://book.cakephp.org/2.0/en/core-libraries/helpers/session.html
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/blog.html
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
http://book.cakephp.org/2.0/en/controllers/request-response.html
http://book.cakephp.org/2.0/en/tutorials-and-examples/blog-auth-example/auth.html
http://book.cakephp.org/2.0/en/models/retrieving-your-data.html#magic-find-types
 */

#App::uses('CakeSession', 'Model/Datasource');

/**
 * Class ProjectsController
 * @property CakeRequest|mixed|string|null $Project
 * @property CakeRequest|mixed|string|null $Time
 */
class ProjectsController extends AppController
{

    /**
     * @var string[]
     */
    public $helpers = array('Html', 'Form', 'Session');
    /**
     * @var string[]
     */
    public $uses = array('Project', 'Time', 'User');
    /**
     * @var string[]
     */
    public $components = array('Session');

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
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

        // array of conditions
        $params = array(
            'conditions' => array('Project.user_id' => $this->Auth->user('id')),
            'recursive' => 1, // int
            'order' => array('Project.name ASC'),
        );
        $this->set('projects', $this->Project->find('all', $params));
    }

    /**
     * plist
     *
     * @return void
     */
    public function plist()
    {
        // array of conditions
        $params = array(
            'conditions' => array('Project.user_id' => $this->Auth->user('id')),
            'recursive' => 1, // int
            'order' => array('Project.name ASC'),
        );
        $this->set('projects', $this->Project->find('all', $params));
    }

    /**
     * view
     *
     * @param  mixed $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Project->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('project', $post);
    }

    /**
     * add
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Project->create();
            $this->request->data["Project"]["user_id"] = $this->Auth->user('id');
            if ($this->Project->save($this->request->data)) {
                $this->Session->setFlash(__('Your Project has been saved.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your post.'));
        }
    }

    /**
     * edit
     *
     * @param  mixed $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!isset($id)) {
            throw new NotFoundException(__('Invalid Project'));
        }

        $project = $this->Project->findById($id);
        if (!isset($project)) {
            throw new NotFoundException(__('Invalid Project'));
        }

		$this->set('project', $project);

		if ($this->request->is(array('post', 'put'))) {
            $this->Project->id = $id;
            if ($this->Project->save($this->request->data)) {
                $this->Session->setFlash(__('Your Project has been updated.'));
                $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to update your Project.'));
        }

        if (!$this->request->data) {
            $this->request->data = $project;
        }
    }

	/**
	 * delete
	 *
	 * @param mixed $id
	 * @return void
	 * @throws Exception
	 */
    public function delete($id = null)
    {
        //if (!$this->request->is('get')) {
        //    throw new MethodNotAllowedException();
        //}

        if (empty($id)) {
            throw new RuntimeException("No id provided");
        }

        if ($this->Project->delete($id)) {
            $this->Session->setFlash(
                //__('The post with id: %s has been deleted.', h($id))
                __('The post with id: $id has been deleted.')
            );

            $this->redirect(array('action' => 'index'));
        }
    }

    /**
     * showstats
     *
     * @return void
     */
    public function showstats()
    {
        // array of conditions
        $params = array(
            'conditions' => array('Project.user_id' => $this->Auth->user('id')),
            'recursive' => 1, //int
            'order' => array('Project.name ASC'),
        );
        $projects = $this->Project->find('all', $params);

        $todayDateStart = date("Y-m-d 00:00:01");
        $todayDateEnd = date("Y-m-d 23:59:00");

        $todayUnixStart = strtotime($todayDateStart);
        $todayUnixEnd = strtotime($todayDateEnd);

        foreach ($projects as $project) {
            $res = $this->Time->query(
                'SELECT sum(`unixDiff`) as seconds
					FROM `times`
                	WHERE `project_id` = ' . $project["Project"]["id"] . '
						AND `user_id`=' . $this->Auth->user('id') . '
						AND `startUnix` > ' . $todayUnixStart . '
						AND `stopUnix` < ' . $todayUnixEnd . ' '
            );
            //$report[] = $project["Project"]["name"]." :: " .date('H:i:s', $res[0][0]["seconds"]). " :: " .$res[0][0]["seconds"] ;
            $report[] = $project["Project"]["name"] . " :: " . gmdate('H:i:s', $res[0][0]["seconds"]);
        }

        $this->set('report', $report);
    }


    /**
     * showstatsall
     *
     * @return void
     */
    public function showstatsall()
    {
        $params = array(
            'conditions' => array('Project.user_id' => $this->Auth->user('id')), //array of conditions
            'recursive' => 1, //int
            'order' => array('Project.name ASC'),
        );
        $projects = $this->Project->find('all', $params);

        $todayDateStart = date("Y-m-d 00:00:01");
        $todayDateEnd = date("Y-m-d 23:59:00");

        $todayUnixStart = strtotime($todayDateStart);
        $todayUnixEnd = strtotime($todayDateEnd);

        foreach ($projects as $project) {
            $res = $this->Time->query(
                'SELECT sum(`unixDiff`) as seconds FROM `times`
                		WHERE `project_id` = ' . $project["Project"]["id"] . '
						AND `user_id`=' . $this->Auth->user('id') . '
			-- AND `startUnix` > ' . $todayUnixStart . '
			-- AND `stopUnix` < ' . $todayUnixEnd . ' '
            );
            //$report[] = $project["Project"]["name"]." :: " .date('H:i:s', $res[0][0]["seconds"]). " :: " .$res[0][0]["seconds"] ;
            $report[] = $project["Project"]["name"] . " :: " . gmdate('H:i:s', $res[0][0]["seconds"]);
        }

        $this->set('report', $report);
    }

    /**
     * @param int $id
     */
    public function savetime($id)
    {
        $this->layout = "ajax";
        $arUnixStart = explode("|", $this->request->data('unixStart'));
        $arUnixEnd = explode("|", $this->request->data('unixEnd'));
        $sUnixDiff = $this->request->data('unixDiff');

        $this->data = array(
            "project_id" => $id,
            "start" => date("Y-m-d") . " " . $arUnixStart[1],
            "startUnix" => $arUnixStart[0],
            "stop" => date("Y-m-d") . " " . $arUnixEnd[1],
            "stopUnix" => $arUnixEnd[0],
            "date" => date("Y-m-d H:i:s"),
            "user_id" => $this->Auth->user('id'),
            "unixDiff" => $sUnixDiff,
        );

        // print_r($this->data);
        $this->Time->save($this->data);
    }

    /**
     * @param array $user
     *
     * @return bool
     */
    public function isAuthorized($user)
    {
        // All registered users can add posts
        if ($this->action === 'add') {
            return true;
        }

        // The owner of a post can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $postId = (int) $this->request->params['pass'][0];
            if ($this->isOwnedBy($postId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }

    // app/Model/Post.php

    /**
     * @param int $post
     * @param int $user
     *
     * @return bool
     */
    public function isOwnedBy($post, $user)
    {
        return $this->Project->field('id', array('id' => $post, 'user_id' => $user)) !== false;
    }


    /**
     * viewByUser
     *
     * @return void
     */
    public function viewByUser()
    {
        $id = $this->Auth->user('id');
        $posts = $this->Project->findAllById($id);
        $this->set('posts', $posts);
    }

}
