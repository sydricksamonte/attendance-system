<?php
	class ScheduleoverridesController extends AppController{
     public $helpers = array('Html', 'Form');
    var $name = 'Scheduleoverrides';
		public $uses=array('Schedule','Scheduleoverride','Employee');
		public function change_sched(){
			$empname = $this->Employee->find('list',array(
										'fields'=>array('Employee.first_name')));
			$this->set(compact('empname'));
		} 		
	}
?>
