<?php
class LogsheetsController extends AppController {

  public $uses = array(
        'Employee',
        'History',
        'Shift',
        'Groups',
        'Schedule',
        'Scheduleoverride',
        'Historytype',
        'User'
      );

			public function index(){
        $employees = $this->Employee->find('all',array(
          'fields' => array(
            'Employee.id',
            'Employee.first_name',
            'Employee.last_name',
            'Group.name'
          ),
          'joins' => array(
            array(
              'type' => 'left',
              'table' => 'groups',
              'alias' => 'Group',
              'conditions' => array(
                      'Employee.group_id = Group.id'
              )
            ),
                    ),
            'conditions' => array(
                            )
                    ));
        $this->set(compact('employees'));

			}

		public function add($id=null){
        $employees = $this->Employee->find('first',array(
          'fields' => array(
            'Employee.id',
            'Employee.first_name',
            'Employee.last_name',
            'Group.name'
          ),
          'joins' => array(
            array(
              'type' => 'left',
              'table' => 'groups',
              'alias' => 'Group',
              'conditions' => array(
                      'Employee.group_id = Group.id'
              )
            ),
                    ),
            'conditions' => array(
											'Employee.id' => $id
                            )
                    ));
        $this->set(compact('employees'));

		}
}
