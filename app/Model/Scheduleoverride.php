<?php
	class Scheduleoverride extends AppModel{	
					function findSchebyTimeAndEmp($id, $date){
								$sched = $this->find('first',array(
																					'conditions' => array('Scheduleoverride.emp_id' => $id,'start_date' => $date )));
								if ($sched == null) {
												return null;					
								}
								else {		
												return $sched['Scheduleoverride']['id'];
								}
					}
	}
?>
