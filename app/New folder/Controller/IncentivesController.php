<?php
class IncentivesController extends AppController{
#public $components = array('RequestHandler');
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
									'Incentive',
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
									'Retro'
													);
	public function ot($emp_id, $dateId, $type, $hour) {
				$curr_date_ymd = date('Y-m-d', $dateId);
				$this->set('curr_date_ymd', $curr_date_ymd);
				$this->set(compact('emp_id'));
				$this->set(compact('type'));		
				$this->set(compact('hour'));
				$this->set(compact('curr_date_ymd'));
				if (!empty($this->data)){
								$ids = $this->Incentive->find('list', array('fields' => array('id') ,'conditions' => array('emp_id' => $emp_id,'type' => $type, 'date' => $curr_date_ymd )));
								$this->Incentive->delete($ids);
								if($this->Incentive->save($this->data))
								{
												$this->Session->setFlash('Log Entry Saved!');
												$this->redirect(array('controller' => 'Employees', 'action' => 'view_emp', $emp_id));
								}
				}
	}
	function getOverTime($emp_id,$dateId,$type)
	{
					$curr_date_ymd = date('Y-m-d', $dateId);
					$time = $this->Incentive->find('first', array('fields' => array('hour') ,'conditions' => array('emp_id' => $emp_id,'type' => $type, 'date' => $curr_date_ymd )));
					if ($time != null)
					{
									return (0 + $time['Incentive']['hour']);
					}
					else
					{
									return 0;
					}
	}

}
?>
