<?php
class LoansController extends AppController {
  public $components=array('Session','RequestHandler');

  var $sTime;
  var $eTime;

  public $uses = array(
    'Employee',
    'History',
    'Shift',
    'Groups',
    'Schedule',
    'Scheduleoverride',
    'Scheduleoverride_type',
    'Historytype',
    'User',
    'Checkinout',
    'Holiday',
    'Restday',
    'EmpSched',
    'SubGroup',
    'Week',
    'Govdeduction',
    'Govstat',
    'Total',
    'Cutoff',
    'Retro',
		'Loan'
  );

	public function emp_loan() {
            $ressult=$this->data;
            $this->set(compact('ressult'));
            $res=$this->Employee->find('all',array(
                                    'fields'=>array(
                                            'Employee.id',
                                            'Employee.first_name',
                                            'Employee.last_name',
                                            'Employee.employed',
                                            'SubGroup.name'
                                            ),
                                    'joins'=>array(array(
                                                    'type' => 'left',
                                                    'table' => 'sub_groups',
                                                    'alias' => 'SubGroup',
                                                    'conditions' => array(
                                                            'Employee.subgroup_id = SubGroup.id'
                                                            ))
                                            ),
                                    'conditions' => array(
                                            array('OR' => array(
                                                            'OR' =>array(
                                                                    array('Employee.last_name LIKE' => '%'.$ressult['Loan']['emp_id'].'%'),
                                                                    array('Employee.first_name LIKE' => '%'.$ressult['Loan']['emp_id'].'%'),
                                                                    array('Employee.id LIKE' => '%'.$ressult['Loan']['emp_id'].'%'),
                                                                    array('SubGroup.name LIKE' => '%'.$ressult['Loan']['emp_id'].'%')
                                                                    )))),
                                    'order' => array(
                                              'Employee.employed' => 'DESC',
                                            'SubGroup.name' => 'ASC',   'Employee.last_name' => 'ASC'
                                                    )
                                            ));

            $this->set(compact('res'));

	}
	public function add_loan($emp_id) {
					$this->set(compact('emp_id'));
          $employee=$this->Employee->find('first',array('conditions'=>array('Employee.id'=>$emp_id)));
					$this->set(compact('employee'));
					if (!empty($this->data)){
									if ($this->Loan->save($this->request->data)) {
													$this->Session->setFlash('Employee\'s Loan pay has been saved.');
													$this->redirect(array('controller'=>'Employees','action' => 'view_emp/'.$emp_id));
									} else {
													$this->Session->setFlash('Unable to Save.');
									}

					}
	}
	public function edit_loan($emp_id,$id) {
					$this->set(compact('emp_id'));
					$this->set(compact('id'));
					$employee=$this->Employee->find('first',array('conditions'=>array('Employee.id'=>$emp_id)));
					$this->set(compact('employee'));
					$this->Loan->id = $id;
					if (empty($this->data)) {
									$this->data = $this->Loan->read();
					} else {
									if ($this->Loan->save($this->data)) {
													$this->Session->setFlash('Loan has been updated.');
													$this->redirect(array('controller'=>'Employees','action' => 'view_emp/'.$emp_id));
        }
    }
	}
	public function edit_emp_loan($emp_id) {
					$empname=$this->Employee->find('first',array('fields'=>array('Employee.id','Employee.first_name','Employee.last_name'),'conditions'=>array('Employee.id'=>$emp_id)));
					$this->set(compact('empname'));

					$emploans=$this->Loan->find('all',array('conditions' => array('Loan.emp_id'=>$emp_id)));
					$this->set(compact('emploans'));

	}
  public function edit_emp_loan_loan($emp_id,$id) {
          $this->set(compact('emp_id'));
          $this->set(compact('id'));
          $employee=$this->Employee->find('first',array('conditions'=>array('Employee.id'=>$emp_id)));
          $this->set(compact('employee'));
          $this->Loan->id = $id;
          if (empty($this->data)) {
                  $this->data = $this->Loan->read();
          } else {
                  if ($this->Loan->save($this->data)) {
                          $this->Session->setFlash('Loan has been updated.');
                          $this->redirect(array('controller'=>'Loans','action' => 'edit_emp_loan/'.$emp_id));
        }
    }

	}
  public function add_loan_loan($emp_id) {
          $this->set(compact('emp_id'));
          $employee=$this->Employee->find('first',array('conditions'=>array('Employee.id'=>$emp_id)));
          $this->set(compact('employee'));
          if (!empty($this->data)){
                  if ($this->Loan->save($this->request->data)) {
                          $this->Session->setFlash('Employee\'s Loan pay has been saved.');
                          $this->redirect(array('controller'=>'Loans','action' => 'edit_emp_loan/'.$emp_id));
                  } else {
                          $this->Session->setFlash('Unable to Save.');
                  }

          }

	}
}
