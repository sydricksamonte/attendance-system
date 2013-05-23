<?php
class Schedule extends AppModel{

	function findStartTime($id){
		$start_date = $this->find('first', array('conditions' => array('shift_id' => $id)));
		return ($start_date['Schedule']['start_date']);
	}

	function findEndTime($id){
		$end_date = $this->find('first', array('conditions' => array('shift_id' => $id)));
		return ($end_date['Schedule']['end_date']);
	}

 	function findActionTaken($id){
  	$actTaken = $this->find('first', array('conditions' => array('emp_id' => $id)));
		return ($actTaken['Schedule']['action_taken']);
  }
	function findExistingSchedule($date,$id){
		$cond = $this->find('count', array('conditions' => array('and' => array(
			array('start_date <= ' => $date,
				'end_date >= ' => $date
			),
			'emp_id' => $id
			))));
		
		if ($cond == '1') {
			return true;
		}else{
			return false;
		}
	}
	
	function findExSched($date,$id,$schedId){
		$cond = $this->find('count', array('conditions' => array('and' => array(
    	array('start_date <= ' => $date,
      	'end_date >= ' => $date
      ),
      'emp_id' => $id,
			'id <>' => $schedId
    ))));
    
    if ($cond == '1') {
      return true;
    }else{
      return false;
    }
  }
	function getRestDayNames($days)
  {
    if($days == '01-05'){
    $restDays = array('Saturday','Sunday');
    }
    else if($days == '02-06'){
    $restDays = array('Sunday','Monday');
    }
    else if($days == '03-07'){
    $restDays = array('Monday','Tuesday');
    }
    else if($days == '04-01'){
    $restDays = array('Tuesday','Wednesday');
    }
    else if($days == '05-02'){
    $restDays = array('Wednesday','Thursday');
    }
    else if($days == '06-03'){
    $restDays = array('Thursday','Friday');
    }
    else{
    $restDays = array('Friday','Saturday');
    }
    return $restDays;
  }
	function getNoOfWeek($date_string){
	$numWeek = date("W", strtotime($date_string)) - 1;
	return $numWeek;
	}
	function checkWeekExist($date_string){
   $cond = $this->find('count', array(
		'joins' => array(
          'type' => 'inner',
          'table' => 'emp_sched',
          'alias' => 'EmpSched',
          'conditions' => array(
          'EmpSched.sched_id = Schedule.order_schedules'
          )	
		),
		'conditions' => array(
      'EmpSched.week_id' => $this->getNoOfWeek($date_string)
      )));

    if ($cond == '1') {
      return true;
    }else{
      return false;
    }
	
	debug($cond);
  }

	function getShifts(){
					$shifts = $this->find('list', array(
																	'fields' => array('descrip'),
																	'order' => array(
																					'order_schedules'),
																	'group' => 'descrip'));
					return $shifts;
	}
	function getShiftOrder($id){
          $shifts = $this->find('first', array(
                                  'fields' => array('order_schedules'),
																	'conditions' => array('id' => $id)));
					return $shifts['Schedule']['order_schedules'];
  }

	function getEmpFieldsSchedByWeek($weekNum, $subgroup){
	  $empFields = $this->find('all',array(
      'fields' => array(
        'Employee.id',
        'Employee.first_name',
        'Employee.last_name',
        'Employee.subgroup_id',
        'Schedule.time_in',
        'Schedule.time_out',
        'Schedule.days',
      ),
      'joins' => array(
        array(
          'type' => 'inner',
          'table' => 'emp_scheds',
          'alias' => 'EmpSched',
          'conditions' => array(
          'EmpSched.sched_id = Schedule.order_schedules'
          )
        ),
         array(
          'type' => 'inner',
          'table' => 'employees',
          'alias' => 'Employee',
          'conditions' => array(
            'EmpSched.emp_id = Employee.id'
          )
        )
      ),
			'conditions' => array(
         array('EmpSched.week_id' => $weekNum, 'Employee.employed' => '1', 'Employee.subgroup_id' => $subgroup)
      ),
      'order' => array(
         'Schedule.time_in',
         'Schedule.days',
				 'Employee.last_name',
				 'Employee.first_name'
      )
    ));

    return $empFields; 
   }
	function generateEmpFieldsSched($weekNum, $limCount, $ruleAnd, $ruleOr, $exEmp){
	 $empFields = $this->find('all',array(
      'fields' => array(
        'DISTINCT Employee.id',
        'Employee.first_name',
        'Employee.last_name',
        'Employee.subgroup_id',
        'Schedule.time_in',
        'Schedule.time_out',
        'Schedule.days',
        'EmpSched.week_id',
				'EmpSched.emp_id',
				'EmpSched.sched_id'
      ),
      'joins' => array(
        array(
          'type' => 'inner',
          'table' => 'emp_scheds',
          'alias' => 'EmpSched',
          'conditions' => array(
          'EmpSched.sched_id = Schedule.order_schedules'
          )
        ),
         array(
          'type' => 'inner',
          'table' => 'employees',
          'alias' => 'Employee',
          'conditions' => array(
            'EmpSched.emp_id = Employee.id'
          )
        )
      ),
      'conditions' => 
											array('NOT' => array('EmpSched.emp_id' => $exEmp),
															'AND' => array(
																			'Employee.subgroup_id' => "18",
																			'EmpSched.week_id' => $weekNum,
																			'Schedule.regular' => "1",
																		  'Schedule.group !='=>  $ruleAnd	),
														 'OR' => $ruleOr
													 ),
      'order' =>'rand()',
			'limit' => $limCount
    ));
    return $empFields;
	}
	 function getTempData(){
    $tempFields = $this->find('all',array(
      'fields' => array(
        'Employee.id',
        'Employee.first_name',
        'Employee.last_name',
        'Employee.subgroup_id',
        'Schedule.time_in',
        'Schedule.time_out',
        'Schedule.days',
      ),
      'joins' => array(
        array(
          'type' => 'inner',
          'table' => 'temp_emp_scheds',
          'alias' => 'TempEmpSched',
          'conditions' => array(
          'TempEmpSched.sched_id =Schedule.order_schedules'
          )
        ),
         array(
          'type' => 'inner',
          'table' => 'employees',
          'alias' => 'Employee',
          'conditions' => array(
            'TempEmpSched.emp_id = Employee.id'
          )
        )
      ),
      'order' => array(
         'Schedule.time_in',
         'Schedule.days'
      )
    ));
		return $tempFields;
	 }
	 function findTimeInCheck($id)
	 {
					 $timeIn = $this->find('first', array('fields' => array ('time_in'),'conditions' => array('order_schedules' => $id)));
					 return($timeIn['Schedule']['time_in']);
	 }
	 function findTimeOutCheck($id)
   {
           $timeIn = $this->find('first', array('fields' => array ('time_out'),'conditions' => array('order_schedules' => $id)));
           return($timeIn['Schedule']['time_out']);
   }
}
?>
