<?php
class UsersController extends AppController{
		
	public $components=array('Session');
	var $name = 'Users';
	public function index(){
	$search = $this->data;
		$this->set(compact('search'));
		$filter = $this->User->find('all',array(
			'fields' => array(
				'User.id',
				'User.first_name',
				'User.last_name',
				'User.username',
				'User.authorize'
			),
			'conditions' => array(
				array(
					'OR' => array(
						'OR' => array(
							array('User.first_name LIKE' => '%' .$search['User']['search_id'].'%'),
							array('User.last_name LIKE' => '%' .$search['User']['search_id'] .'%'),
							array('User.id LIKE' => '%' .$search['User']['search_id'] .'%'),
							)
						)
					)
				)
		));

$this->set(compact('filter'));
	}
	public function login() {
$this->layout='login';
        if ($this->request->is('post')) {
                $user = $this->User->find('first',array(
                        'conditions' => array(
                                'User.username' => $this->request->data['User']['username'],
                                'User.password' => AuthComponent::password($this->request->data['User']['password']),
                        )
                ));
            if($user){
                if ($this->Auth->login($user)) {
                    $this->redirect($this->Auth->redirect(array('controller' => 'employees', 'action' => 'index')));
                }
            } else {
                    $this->Session->setFlash(__('Invalid username or password, try again'));

       }

    }
	}

	public function logout() {
        $this->redirect($this->Auth->logout());
  }

	public function add(){
					if(!empty($this->data))
					{
									$uname = $this->data['User']['username'];
												if ($this->User->check($uname)==false){
															if	($this->User->save($this->data))
															{	$this->Session->setFlash('user created');
																$this->redirect(array('action' => 'index'));}
												}															
												else
												{   $this->Session->setFlash('The username exists!');
												}
					}
	}
	public function delete($id){
					if($this->User->delete($id)){
									$this->Session->setFlash('User successfully deleted');
					}
					$this->redirect(
													array(
																	'controller' => 'users',
																	'action' => 'index'
															 )
												 );
	}
	public function edit($id){
					$this->User->id = $id;
					if (empty($this->data)) {
									$this->data = $this->User->read();
					}
					else 
					{
									$uname = $this->data['User']['username'];
													if ($this->User->save($this->data)) {
																	$this->Session->setFlash('The user has been updated.');
																	$this->redirect(array('action' => 'index'));
													}

					}

	}
	function view($id=null){
					if(!$id){
									$this->Session->setFlash('Invalid user');
									$this->redirect(array('action' => 'index'));
					}
					$this->set('user',$this->User->findById($id));
	}

}
?>
