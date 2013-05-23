<?php
class HolidaysController extends AppController{

	public function index(){
		$holi=$this->Holiday->find('all',array( 'order' => 'date ASC'));
		$this->set(compact('holi'));
	}

	public function add(){
		if (!empty($this->data)){
			if ($this->Holiday->save($this->data)){
				$this->Session->setFlash('Holiday saved.');
				$this->redirect(array('action'=>'index'));
			}
		}	
	}

	public function view($id=null){
		if(!$id){
			$this->Session->setFlash('Invalid Holiday');
			$this->redirect(array('action'=>'index'));
		}
		$this->set('holiday',$this->Holiday->findById($id));

	}
	
	public function edit($id=null){
		$this->Holiday->id=$id;
		if(empty($this->data)){
			$this->data = $this->Holiday->read();
		} else {
			if ($this->Holiday->save($this->data)){
				$this->Session->setFlash('Holiday has been updated.');
				$this->redirect(array('action'=>'index'));
			}
		}
	}

	public function search(){
		$holid=$this->data;
		$this->set(compact('holid'));
		
		$holi=$this->Holiday->find('all',array(
			'conditions'=>array(
				array('OR'=>array(
					'OR'=>array(
								array('Holiday.id LIKE'=>'%'.$holid['Holiday']['search'].'%'),
								array('Holiday.date LIKE'=>'%'.$holid['Holiday']['search'].'%'),
								array('Holiday.name LIKE'=>'%'.$holid['Holiday']['search'].'%')
							)
						)
					)
				)
		));
		$this->set(compact('holi'));
	}

}
?>
