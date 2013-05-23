<?php
class EmpSched extends AppModel{
				function fecthEmployeeData($id){
				$empSched = $this->Employee->find('first',array(
																'fields' => array(
																				'Employee.id',
																				'Employee.first_name',
																				'Employee.last_name',
																				'Group.name',
																				'Schedules.id',
																				'Shifts.start_time',
																				'Shifts.end_time',
																				'Schedules.start_date',
																				'Schedules.end_date',
																				'Schedules.changed_time',
																				'Shifts.time_shift',
																				'Schedules.shift_id',
																				'Schedules.action_taken'
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
																				array(
																								'type' => 'left',
																								'table' => 'schedules',
																								'alias' => 'Schedules',
																								'conditions' => array(
																												'Employee.id = Schedules.emp_id'
																												)
																						 ),
																				array(
																								'type' => 'left',
																								'table' => 'shifts',
																								'alias' => 'Shifts',
																								'conditions' => array(
																												'Schedules.shift_id = Shifts.id'
																												)
																						 ),
																				array(
																								'type' => 'left',
																								'table' => 'historytypes',
																								'alias' => 'HistoryType',
																								'conditions' => array(
																												'HistoryType.id= Schedules.action_taken'
																												)
																						 )),
																	 'conditions' => array(
																											 'Employee.id' => $id
																														 )
																										 ));

				$this->set(compact('empSched'));
				}
				 function getAllNetEmpOfWeek($weekId, $subGroupId){ 
                $netEmp = $this->find('all', array(
																				'joins' => array(
																								array(
																												'type' => 'inner',
																												'table' => 'employees',
																												'alias' => 'E',
																												'conditions' => array(
																																'E.id = EmpSched.emp_id'
																																)
																										 )),
																								'conditions' => array ('E.employed' => '1', 'week_id' => $weekId, 'E.subgroup_id' => $subGroupId),
																								'order' => 'sched_id DESC'));
                return ($netEmp);
        }

				 function checkExist($week, $emp){
                $eSched = $this->find('first', array('fields' => 'EmpSched.id', 'conditions' => array('week_id' => $week, 'emp_id' => $emp) ));
      	        return ($eSched);
        }
}
?>
