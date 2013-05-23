<?php
class CutoffsController extends AppController{
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
    'SubGroup',
		'Cutoff'
  );

	public function index(){
					$s=1;
					$sdate = date("Y-m-d", time());
					$yr=date('Y',strtotime($sdate));
					$lastmonth='';

					do{ 
									if (($s % 2)==1){
													$cutstart=$yr.'-'.date("m", strtotime($sdate)).'-11';
													$cutend=$yr.'-'.date("m", strtotime($sdate)).'-25';
									}else{
													$cutstart=$yr.'-'.date("m", strtotime($sdate)).'-26';
													$lastmonth=date('m-d',strtotime($cutend));
													if ($lastmonth=='12-25'){
																	$yr=date("Y",strtotime("+1 years"));
													}   
													$sdate=date("M",strtotime('+1 month',strtotime($sdate)));
													$cutend=$yr.'-'.date("m", strtotime($sdate)).'-10';
									}   
									$s++;
									$this->Cutoff->create();
									$this->Cutoff->set('start_date',$cutstart);
									$this->Cutoff->set('end_date',$cutend);
									$this->Cutoff->set('year',$yr);
									$this->Cutoff->save();
					} while($lastmonth != '12-25');

	$coff=$this->Cutoff->find('all');
	$this->set(compact('coff'));	

	}  

	public function view(){
					$sdate = Date('Y-m-d', strtotime("+15 days"));
					$total = $this->Cutoff->getCutOffAvailable($sdate);
					$this->set(compact('total'));
					if ($this->data != null)
					{
									$this->redirect(array('controller' => 'Employees', 'action' => 'view_all',null,	$this->data['CutOff']['cut_use']));
					}

	}

}
?>
