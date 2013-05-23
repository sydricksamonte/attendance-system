<?php
class SchedulesController extends AppController{
	public $components=array('Session');
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
    'EmpSched',
		'Rule',
	  'TempEmpSched',
		'Week',
		'SubGroup'
  );
	public $helpers = array('Html','Form');

	public function index() {
					$subgroups = $this->SubGroup->find('list',array(
                                    'conditions' => array('authorize' => '1'),
                                    'order' => array('group_id' => 'ASC')
                                    ));
					$this->set(compact('subgroups'));

					$weeks = $this->Week->fetchGenerated();
					$this->set(compact('weeks'));
					if ($this->data != null){

									$weekVal = $this->data['Schedule']['week_id'];
									$weekData = $this->data['Schedule']['week_id'];
									$subgroup = $this->data['Schedule']['subgroup_id'];			
		}
					else
					{				$subgroup = 4;
									$weekVal =  $this->Week->getRecentGenerated();
									$weekData =  $this->Week->getRecentGenerated();
					}
					$this->set(compact('weekVal'));
					$this->set(compact('weekData'));
					$this->set(compact('subgroup'));
					$weekRange = $this->Week->getTodayWeekRange($weekVal);
					$this->set(compact('weekRange'));
					$empSched =  $this->Schedule->getEmpFieldsSchedByWeek($weekData, $subgroup);
					$this->set(compact('empSched'));
					$weekNo = $this->Week->getAllAvailableWeeks();
					$this->set(compact('weekNo'));
					$generate =	$this->Week->enableGeneration();
	}

  function getWorkDayNames($days)
  {
    if($days == '01-05'){
    $wrkDays = array('Monday','Tuesday','Wednesday','Thursday','Friday');
    }
    else if($days == '02-06'){
    $wrkDays = array('Tuesday','Wednesday','Thursday','Friday','Saturday');
    }
    else if($days == '03-07'){
    $wrkDays = array('Wednesday','Thursday','Friday','Saturday','Sunday');
    }
    else if($days == '04-01'){
    $wrkDays = array('Thursday','Friday','Saturday','Sunday','Monday');
    }
    else if($days == '05-02'){
    $wrkDays = array('Friday','Saturday','Sunday','Monday','Tuesday');
    }
    else if($days == '06-03'){
    $wrkDays = array('Saturday','Sunday','Monday','Tuesday','Wednesday');
    }
    else{
    $wrkDays = array('Sunday','Monday','Tuesday','Wednesday','Thursday');
    }
    return $wrkDays;
  }

	
	public function weeks(){

	}
  public function generate($netType){
					$unable = null;
					$this->set(compact('netType'));
					$toGenWeek =  $this->Week->getFollowUpWeek();
					$this->set(compact('toGenWeek')); #'2013-04-01 to 2013-04-07'
					$this->TempEmpSched->deleteAll('1=1');
					$weekData = $this->Week->getRecentGenerated(); #week id: 1
					$netEmp = $this->EmpSched->getAllNetEmpOfWeek($weekData, $netType);
					foreach ($netEmp as $gen):
					{
									$this->request->data['TempEmpSched']['id'] = null;
									$this->request->data['TempEmpSched']['week_id'] = 0;
									$exSched = $this->TempEmpSched->fetchTempSched();									
									$this->request->data['TempEmpSched']['sched_id'] = $this->Rule->getNextSched($gen['EmpSched']['sched_id'], $exSched);
									$this->request->data['TempEmpSched']['emp_id'] = $gen['EmpSched']['emp_id'];
									if  ($this->request->data['TempEmpSched']['sched_id'] == null)
									{
											$unable =  $gen['EmpSched']['emp_id'] .','.$unable;	
									}
									else
									{	
													$this->TempEmpSched->save($this->request->data);	
									}
					}
					endforeach;	
					$tempSched = $this->Schedule->getTempData();
					$unable = substr($unable,0,-1);
				
					$unable = explode(',',$unable);				
					if ($unable[0] == '')
					{ $unable = null;} 
					$names= null;	
					foreach ($unable as $u):
					{
						$names = $this->Employee->findEmployeeName($u) . '!' . $names;
						
					}
					endforeach;
					$names = substr($names,0,-1);
					$names = explode('!',$names);
					$this->set(compact('unable'));	
					$this->set(compact('names'));
          $this->set(compact('tempSched'));
	}
	public function save(){
					if ($this->request->data == null)
					{}
					else {
									$tempFields = $this->TempEmpSched->fetchTempField();
									$this->set(compact('tempFields'));
									$unGen = $this->Week->fetchUngenerated();
									$this->set(compact('unGen'));
									$newEmpFields = $this->Week->getWeeksToGenerate($this->data['EmpSched']['week_use']);
									foreach ($newEmpFields as $week):
									{			
													foreach ($tempFields as $gen):
													{			
																	$this->request->data['EmpSched']['id'] = null;
																	$this->request->data['EmpSched']['week_id'] = $week;
																	$this->request->data['EmpSched']['sched_id'] =  $gen['TempEmpSched']['sched_id'];
																	$this->request->data['EmpSched']['emp_id'] = $gen['TempEmpSched']['emp_id'];
																	$this->EmpSched->save($this->request->data);
													}
													endforeach;
													$this->request->data['Week']['generated'] = 1;
													$this->request->data['Week']['id']		= $week;						
													$this->Week->save($this->data);								
													$this->Session->setFlash('Schedule(s) saved.');
									}
									endforeach;
									$this->TempEmpSched->deleteAll('1=1');
									$this->redirect(array('action' => 'index'));
					}
	}
}
?>
