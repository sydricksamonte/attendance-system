<?php
class Rule extends AppModel{
			
				function getRule($id,$type){#VACANT
								$rule = $this->find('first', array('conditions' => array('id' => $id)));
							if ($type == '1'){
											$arrayTemp = explode(",", ($rule['Rule']['rule_or']));
											return $arrayTemp;}
							else{ return ($rule['Rule']['rule_and']);
                      }
							} 
		
			function getNextSched($sched_id, $exSched){


                $rule = $this->find('first', array('fields' => array('Rule.rules'),
																				'conditions' => array('NOT' => array('Rule.rules' => $exSched),
																												'AND' => array('Rule.order_schedules' => $sched_id)),
																				'order' =>'rand()'));
								if ($rule['Rule']['rules'] == null)
								{ $ruleTwo = $this->find('first', array('fields' => array('Rule.rules'),
																				'conditions' => array('Rule.order_schedules' => $sched_id),
																				'order' =>'rand()'));
								return $ruleTwo['Rule']['rules'];	
								}   
								else {return $rule['Rule']['rules'];}
			}
}
?>
