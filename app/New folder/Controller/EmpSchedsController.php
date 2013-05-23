<?php
class EmpSchedsController extends AppController{
      public $uses = array(
        'Schedule',
        'Shift',
        'Employee',
        'Groups',
        'EmpSched',
				'Rule'
      );
			public function index(){
							$actives = $this->Emp_Sched->fetchEmployeeData('1');
							debug($actives);

							$a=$this->Emp_Sched->query('SELECT COUNT(sched_id) FROM emp_scheds where sched_id=1');

			}
			function nxtweek(){

/*$empid=array();

	$e=1;
	while ($e<=8){
		if($e==1){
			$rule='EmpSched.sched_id >=97  and EmpSched.sched_id=105 or EmpSched.sched_id=29 or EmpSched.sched_id=30 or EmpSched.sched_id=40 or EmpSched.sched_id =41 or EmpSched.sched_id=31 or EmpSched.sched_id=8';
		}else if($e==2){
			$rule='(EmpSched.sched_id >=97  and EmpSched.sched_id=105 or EmpSched.sched_id=29 or EmpSched.sched_id=30 or EmpSched.sched_id=40 or EmpSched.sched_id =41 or EmpSched.sched_id=31 or EmpSched.sched_id=8) and EmpSched.emp_id!='.$empid[1];
		}else if($e==3){
			$rule='(EmpSched.sched_id=38 or EmpSched.sched_id=39 or EmpSched.sched_id>=41 and EmpSched.sched_id<=44 or EmpSched.sched_id>=24 and EmpSched.sched_id<=29) and EmpSched.emp_id!='.$empid[1].' and EmpSched.emp_id!='.$empid[2];
		}else if($e==4){
			$rule='(EmpSched.sched_id>=25 and EmpSched.sched_id<=28 or EmpSched.sched_id=42 or EmpSched.sched_id=43 or EmpSched.sched_id=38) and EmpSched.emp_id!='.$empid[1].' and EmpSched.emp_id!='.$empid[2].' and EmpSched.emp_id!='.$empid[3];
		}else if($e==5){
			$rule='(EmpSched.sched_id>=9 and EmpSched.sched_id<=21 or EmpSched.sched_id=27 or EmpSched.sched_id=28) and EmpSched.emp_id!='.$empid[1].' and EmpSched.emp_id!='.$empid[2].' and EmpSched.emp_id!='.$empid[3].' and EmpSched.emp_id!='.$empid[4];
		}else if($e==6){
			$rule='(EmpSched.sched_id>=9 and EmpSched.sched_id<=21 or EmpSched.sched_id=27 or EmpSched.sched_id=28) and EmpSched.emp_id!='.$empid[1].' and EmpSched.emp_id!='.$empid[2].' and EmpSched.emp_id!='.$empid[3].' and EmpSched.emp_id!='.$empid[4].' and EmpSched.emp_id!='.$empid[5];
		}else if($e==7){
			$rule='(EmpSched.sched_id>=9 and EmpSched.sched_id<=21 or EmpSched.sched_id=27 or EmpSched.sched_id=28) and EmpSched.emp_id!='.$empid[1].' and EmpSched.emp_id!='.$empid[2].' and EmpSched.emp_id!='.$empid[3].' and EmpSched.emp_id!='.$empid[4].' and EmpSched.emp_id!='.$empid[5].' and EmpSched.emp_id!='.$empid[6];
		}else if($e==8){
			$rule='(EmpSched.sched_id>=9 and EmpSched.sched_id<=21 or EmpSched.sched_id=27 or EmpSched.sched_id=28) and EmpSched.emp_id!='.$empid[1].' and EmpSched.emp_id!='.$empid[2].' and EmpSched.emp_id!='.$empid[3].' and EmpSched.emp_id!='.$empid[4].' and EmpSched.emp_id!='.$empid[5].' and EmpSched.emp_id!='.$empid[6].' and EmpSched.emp_id!='.$empid[7];
		}
		
		
*/

	$shiftA='06:00:00';		
	
	$wks=$this->EmpSched->find('all',array(
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
          'table' => 'schedules',
          'alias' => 'Schedule',
          'conditions' => array(
          'EmpSched.sched_id = Schedule.id'
          )
        ),
         array(
          'type' => 'inner',
          'table' => 'employees',
          'alias' => 'Employee',
          'conditions' => array(
            'EmpSched.emp_id = Employee.id','Employee.subgroup_id=18'
          )
        )
      ),
          'conditions' => array('Employee.id=20')
		));
		
		$this->set(compact('wks'));

/*	foreach ($wks as $tempwk):
#	$temp1=$tempwk['Employee']['id'];
#	$temp2=$tempwk['Employee']['last_name'];
#	$temp3=$tempwk['Employee']['first_name'];
	if ($tempwk['Schedule']['days'] == '01-05' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp1=$tempwk['Employee']['id'];
		echo 'e1'; debug($emp1);
	}
	else if ($tempwk['Schedule']['days'] == '03-07' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp2=$tempwk['Employee']['id'];
		echo 'e2';debug($emp2);
	}
	else if ($tempwk['Schedule']['days'] == '04-01' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp3=$tempwk['Employee']['id'];
		echo 'e3';debug($emp3);
	}
	else if ($tempwk['Schedule']['days'] == '05-02' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp4=$tempwk['Employee']['id'];
		echo 'e4';debug($emp4);
	}
	else if ($tempwk['Schedule']['days'] == '06-03' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp5=$tempwk['Employee']['id'];
		echo 'e5';debug($emp5);
	}
	else if ($tempwk['Schedule']['days'] == '07-04' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp6=$tempwk['Employee']['id'];
	echo 'e6';debug($emp6);
	}
	else if ($tempwk['Schedule']['days'] == '02-06' or $tempwk['Schedule']['time_out']-$shiftA>=12){
		$emp7=$tempwk['Employee']['id'];
		echo 'e7';debug($emp7);
	}



	endforeach;
/*echo($e);
debug($temp1.$temp2.$temp3);

	$empid[$e]=$temp1;

$e++;
	}*/
}



}
?>
