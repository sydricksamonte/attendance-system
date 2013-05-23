<?php
class GroupsController extends AppController {
				public $uses = array('Employee','Group','Shift','Schedule','SubGroup');
				public $helpers = array('Html', 'Form');
				var $name = 'Groups';	
				public function index() {
								$search = $this->data['Group']['search_id'];
								$filter = $this->Group->find('all',array(
																				'fields' => array(
																								'Group.id',
																								'Group.authorize',
																								'Group.name'
																								),
																				'conditions' => array(
																								array(
																												'OR' => array(
																																'OR' => array(
																																				array('Group.id LIKE' => '%' .$search .'%'),
																																				array('Group.name LIKE' => '%' .$search .'%')
																																				)
																																)
																										 )
																								)
																				));

								$this->set(compact('filter'));
				}
				function view($id = null) {
								$this->Group->id = $id;
								$this->set('groups', $this->Group->read());
				}
				function edit($id) {
								$this->Group->id = $id;							
								$subGroup = $this->SubGroup->fetchGroupName($id);
								$this->set(compact('subGroup'));
								$this->set(compact('id'));								
								if (empty($this->data)) {
												$this->data = $this->Group->read();
								} else {
												if ($this->Group->save($this->data)) {
																$this->Session->setFlash('The group has been updated.');
																$this->redirect(array('action' => 'index'));
												}
								}
				}

				function delete($id) {
								if ($this->Group->delete($id)) {
												$this->Session->setFlash('The group with id: ' . $id . ' has been deleted.');
												$this->redirect(array('action' => 'index'));
								}
				}
				function add() {
								if (!empty($this->data)) {
												if ($this->Group->save($this->data)) {
																$this->Session->setFlash('The group has been saved.');
																$this->redirect(array('action' => 'index'));
												}
								}
				}		

}
?>
