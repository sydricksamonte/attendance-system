<?php
class SubGroupsController extends AppController {
        public $uses = array('EmpSched','Week','SubGroup','Employee','Group','Schedule');
        public $helpers = array('Html', 'Form');


			 function edit($id = null) {
                $this->SubGroup->id = $id;
                if (empty($this->data)) {
                        $this->data = $this->SubGroup->read();
                } else {
                        if ($this->SubGroup->save($this->data)) {
                                $this->Session->setFlash('The subgroup has been updated.');
																$dat = $this->SubGroup->read();
																$redirID = $dat['SubGroup']['group_id'];                            
																$this->redirect(array('controller' => 'Groups', 'action' => 'edit', $redirID));
                        }
								}
			 }
			 function view($id) {
							 $subGroupEmp = $this->Employee->getAllEmployeeInfoBySubGroup($id);
							 $this->set(compact('subGroupEmp'));				
			 }
			 function add($group_id) {
							 $this->set(compact('group_id'));							 
							 if (!empty($this->data)) {
											 if ($this->SubGroup->save($this->data)) {
															 $this->Session->setFlash('Subgroup has been saved.');
															 $dat = $this->SubGroup->read();
															 $redirID = $dat['SubGroup']['group_id'];        
															 $this->redirect(array('controller' => 'Groups', 'action' => 'edit', $redirID));
											 }
							 }
			 }
				function change_sched($id = null) {
								$weekStart =	$this->Week->getAllStart();
								$weekEnd =  $this->Week->getAllEnd();
								$weekNum =  $this->Week->getWeekNo();
								$this->set(compact('weekStart'));
								$this->set(compact('weekEnd'));
								$this->set(compact('weekNum'));
								$this->SubGroup->id = $id;
								$employees = $this->Employee->find('all',array(
																				'fields' => array(
																								'Employee.id',
																								'Employee.subgroup_id',
																							  'EmpSched.sched_id'
																								),
																				'joins' => array(
																								array(
																												'type' => 'inner',
																												'table' => 'groups',
																												'alias' => 'SubGroup',
																												'conditions' => array(
																																'Employee.subgroup_id = SubGroup.id'
																																)
																										 ),
																								array(
																												'type' => 'inner',
																												'table' => 'emp_scheds',
																												'alias' => 'EmpSched',
																												'conditions' => array(
																																'Employee.id = EmpSched.emp_id'
																																)
																										 ),
																								),
																				'conditions' => array(
																								'Employee.subgroup_id' => $id
																								)
																				));

                $shifts = $this->Schedule->getShifts();
                $this->set(compact('shifts'));
								$subgroup = $this->SubGroup->read();
								$this->set(compact('subgroup'));
								$stDa = $this->data['SubGroup']['start'];
								$enDa = $this->data['SubGroup']['end'];
								$sched = $this->data['SubGroup']['scheds'];
								$schedOrder = $this->Schedule->getShiftOrder($sched);
								if (empty($this->data)) {
												$this->data = $this->SubGroup->read();
								} else {
												$stDa2 = $this->Week->getWeekOrder($stDa);
												$enDa2 = $this->Week->getWeekOrder($enDa);
											if ($stDa2 > $enDa2){
														$this->Session->setFlash('Invalid date range');
											}
											else
 {
															$filEmployee =	$this->Employee->getAllEmployeeBySubGroup($this->data['Employee']['subgroup_id']);
															$this->set(compact('filEmployee'));
																					$filWeeks =		$this->Week->getWeeksInBetween($stDa2, $enDa2);		
																					$this->set(compact('filWeeks'));
																					$i = 0;	$j =0;									
																					foreach ($filEmployee as $fe):{
																									$this->request->data['EmpSched']['emp_id'] = 	$fe;
																									foreach ($filWeeks as $fw):{
																													$this->request->data['EmpSched']['id'] = null;
																													$existingId = $this->EmpSched->checkExist($fw, $fe);
																													$fwPlus = $fw-1;
																												$this->request->data['EmpSched']['sched_id'] = $schedOrder;
																													$this->request->data['EmpSched']['week_id'] = $fw;
																													$this->set(compact('existingId'));
																													if ($existingId == null){
																																	$this->EmpSched->save($this->request->data);
																																	$this->Session->setFlash('Shift has been successfully added');
																													}
																													else{
																																	$this->request->data['EmpSched']['id'] = $existingId['EmpSched']['id'];
																																	$this->EmpSched->save($this->request->data);
																																	$this->Session->setFlash('Group`s shift has been updated');
																													}
																													$j++;
																									}
																									endforeach;
																									$i++;
																					}
																					endforeach;
																					$dat = $this->SubGroup->read();
																					$redirID = $dat['SubGroup']['group_id'];
																				$this->redirect(array('controller' => 'Groups', 'action' => 'edit', $redirID));
											}
								}
				}
}
?>
