<?php
class Week extends AppModel{
				public $validate = array(
												'monday' => array(
																'rule'    => 'isUnique',
																'message' => 'This username has already been taken.'
																)
												);
				function getAllAvailableWeeks(){
								$weekNo = $this->find('all', array('fields' => array ('week_no')));
								return ($weekNo);
				}
				function getAllStart(){
								$weeks = $this->find('list', array('fields' => array ('start_date'),'conditions' => array('year' => date('Y')), 'order' => array ('week_no') ));
								return ($weeks);
				}
				function getAllEnd(){
								$weeks = $this->find('list', array('fields' => array ('end_date'),'conditions' => array('year' => date('Y')), 'order' => array ('week_no') ));
								return ($weeks);
				}
				function getWeekNo(){
                $weeks = $this->find('first', array('fields' => array ('id'),'conditions' => array('week_no' => date('W'), 'year' => date('Y')), 'order' => array ('week_no') ));
                return ($weeks['Week']['id']);
        }
				function getWeekStartDate($weekId){
                $weeks = $this->find('first', array('fields' => array ('start_date'),'conditions' => array('id' => $weekId, 'year' => date('Y')) ));
                return ($weeks['Week']['start_date']);
        }
				function getWeekEndDate($weekId){
								$weeks = $this->find('first', array('fields' => array ('end_date'),'conditions' => array('id' => $weekId, 'year' => date('Y')) ));
								return ($weeks['Week']['end_date']);
				}
				 function getWeekOrder($weekId){
                $weeks = $this->find('first', array('fields' => array ('week_no'),'conditions' => array('id' => $weekId, 'year' => date('Y')) ));
                return ($weeks['Week']['week_no']);
        }

				function getTodayWeekRange($weekNo){
								$weeks = $this->find('first', array('fields' => array ('start_date', 'end_date'),'conditions' => array('id' => $weekNo, 'year' => date('Y')), 'order' => array ('week_no') ));
								return ($weeks['Week']['start_date']. ' to '. $weeks['Week']['end_date']);
				}
				function getWeeksInBetween($wkStart, $wkEnd){
								$weeks = $this->find('list', array('fields' => array ('id'),'conditions' => array('week_no BETWEEN ? and ?' => array($wkStart, $wkEnd)), 'order' => array ('week_no') ));
		debug($weeks);		return ($weeks);
				}
				function enableGeneration()
				{
								$week = date("W");
								if (($week ==1) || ($week ==5) || ($week ==9) || ($week ==13) || ($week ==17) || ($week ==21) || ($week ==25) || ($week ==29) || ($week ==33) || ($week ==37) || ($week ==41) || ($week ==45) || ($week ==49))
								{
												$weeks = $this->find('first', array('fields' => array ('generated'),'conditions' => array('year' => date('Y'),'week_no' => $week )));
												return($weeks);
								}
								else{ return false; }
								/*  #tester  $ds='2013-04-01';
										$d=date('W',strtotime($ds));
										debug($d);
										return $monthOfWeek; */
				}
				function fetchGenerated()
				{
								$weeks = $this->find('list', array('fields' => array ('week_no'),'conditions' => array('year' => date('Y'), 'generated' => true),'order' => 'week_no DESC'));
								return($weeks);
				}
				function fetchUngenerated()
				{
								$weeks = $this->find('first', array('fields' => array ('id'),'conditions' => array('year' => date('Y'), 'generated' => false),'order' => 'week_no ASC'));
								return($weeks);
				}
				 function getRecentGenerated()
        {
                $weeks = $this->find('first', array('fields' => array ('id'),'conditions' => array('year' => date('Y'), 'generated' => true),'order' => 'week_no DESC'));
                return($weeks['Week']['id']);
        }

				function getWeeksToGenerate($weekCount)
				{
								$weeks = $this->find('list', array('fields' => array ('id'),'conditions' => array('year' => date('Y'), 'generated' => false),'order' => 'week_no ASC','limit' => $weekCount + 1));
								return($weeks);
				}
				function getFollowUpWeek(){
								$weeks = $this->find('first', array('fields' => array ('start_date', 'end_date'),'conditions' => array('generated' => false, 'year' => date('Y')), 'order' => array ('week_no ASC')));
								return ($weeks['Week']['start_date']. ' to '. $weeks['Week']['end_date']);
				}
				function findScheduleId($date,$id){
          $schedId = $this->find('first',array('fields' => array('ES.sched_id'), 'joins' => array(
																	array(
																					'type' => 'inner',
																					'table' => 'emp_scheds',
																					'alias' => 'ES',
																					'conditions' => array(
																									'ES.week_id = Week.id'
																									)
																			 )),
													'conditions' => array('and' => array(
																					array('Week.start_date <= ' => $date,
																									'Week.end_date >= ' => $date
																							 ),
																					'ES.emp_id' => $id
																					),
																	)));
					return ($schedId['ES']['sched_id']);
  }
}

?>
