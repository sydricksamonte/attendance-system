<?php
class EmployeesController extends AppController{
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
		'Historytype',
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
		'Retro',
		'Loan'
	);
	
	public $helpers = array('Html','Form');


		public function test(){
			$all = $this->Employee->find('all');
			$this->set(compact('all'));
		}
    public function filter(){
						$ressult=$this->data;
						$this->set(compact('ressult'));
						$res=$this->Employee->find('all',array(
																		'fields'=>array(
																						'Employee.id',
																						'Employee.first_name',
																						'Employee.last_name',
																						'Employee.employed',
																						'SubGroup.name'
																						),
																		'joins'=>array(array(
																										'type' => 'left',
																										'table' => 'sub_groups',
																										'alias' => 'SubGroup',
																										'conditions' => array(
																														'Employee.subgroup_id = SubGroup.id'
																														))
																						),
																		'conditions' => array(
																						array('OR' => array(
																														'OR' =>array(
																																		array('Employee.last_name LIKE' => '%'.$ressult['Employee']['emp_id'].'%'),
																																		array('Employee.first_name LIKE' => '%'.$ressult['Employee']['emp_id'].'%'),
																																		array('Employee.id LIKE' => '%'.$ressult['Employee']['emp_id'].'%'),
																																		array('SubGroup.name LIKE' => '%'.$ressult['Employee']['emp_id'].'%')
																																		)))),
																		'order' => array(
																						  'Employee.employed' => 'DESC',
																						'SubGroup.name' => 'ASC',		'Employee.last_name' => 'ASC'
																										)
																						));

						$this->set(compact('res'));
		}
		public function index(){
						$yeard = date("Y", time());
						$cutoffexist=$this->Cutoff->find('first',array('conditions'=>$yeard.'01-25'));
						$this->set(compact('cutoffexist'));

                $wks=$this->Week->find('all',
                                array(
                                        'order'=>'Week.end_date ASC'
                                     )
                                );
                $this->set(compact('wks'));

						$employees = $this->Employee->find('all',array(
																		'fields' => array(
																						'Employee.id',
																						'Employee.first_name',
																						'Employee.last_name',
																						'Employee.employed',
																						'SubGroup.name',
																						),
																		'joins' => array(
																						array(
																										'type' => 'left',
																										'table' => 'sub_groups',
																										'alias' => 'SubGroup',
																										'conditions' => array(
																														'Employee.subgroup_id = SubGroup.id'
																														)
																								 ),
																						),
																		'conditions' => array(
																						),
																		'order' => array(
																						'Employee.employed' => 'DESC',
																						'SubGroup.name' => 'ASC',																					
																						'Employee.last_name' => 'ASC'
																						)
																						));

						$this->set(compact('employees'));
		}

		function delete($id){
						if($this->Employee->delete($id)){
										$this->Session->setFlash('Employee has been deleted.');
										$this->redirect(array('action' => 'index'));
						}
		}

		public function change_sched($id=null){
						$this->Employee->id = $id;
						$weekStart =  $this->Week->getAllStart();
						$weekEnd =  $this->Week->getAllEnd();
						$this->set(compact('weekStart'));
						$this->set(compact('weekEnd'));
						$weekNum =  $this->Week->getWeekNo();
						$this->set(compact('weekNum'));
						$shifts = $this->Schedule->getShifts();
						$this->set(compact('shifts'));

            $employee = $this->Employee->find('first',array(
                                    'fields' => array(
                                            'Employee.id',
                                            'Employee.userinfo_id',
                                            'Employee.first_name',
                                            'Employee.last_name',
																						'Employee.employed',
                                            'SubGroup.name',
                                            'Schedule.time_in',
                                            'Schedule.time_out',
                                            'Schedule.id',
                                            'EmpSched.week_id',
                                            'EmpSched.sched_id',
                                            'Week.week_no',
                                            'Week.start_date',
                                            'Week.end_date'
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'sub_groups',
                                                    'alias' => 'SubGroup',
                                                    'conditions' => array(
                                                            'Employee.subgroup_id = SubGroup.id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'emp_scheds',
                                                    'alias' => 'EmpSched',
                                                    'conditions' => array(
                                                            'Employee.id = EmpSched.emp_id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'weeks',
                                                    'alias' => 'Week',
                                                    'conditions' => array(
                                                            'Week.week_no=EmpSched.week_id'
                                                            )
                                                 ),
                                            array(
                                                            'type' => 'left',
                                                            'table' => 'schedules',
                                                            'alias' => 'Schedule',
                                                            'conditions' => array(
                                                                    'EmpSched.sched_id=Schedule.order_schedules'
                                                                    )
                                                 )
                                                    ),
                                            'conditions' => array(
                                                            'Employee.id' => $id
                                                            ),
                                                    ));
            $this->set(compact('employee'));

						$stDa = $this->data['Employee']['start'];
						$enDa = $this->data['Employee']['end'];
						$sched = $this->data['Employee']['scheds'];
						$schedOrder = $this->Schedule->getShiftOrder($sched);
						if (empty($this->data)) {
										$this->data = $this->EmpSched->read();
						} else {
                         {
																$stDa2 = $this->Week->getWeekOrder($stDa);
																$enDa2 = $this->Week->getWeekOrder($enDa);
																$filWeeks =   $this->Week->getWeeksInBetween($stDa2, $enDa2);
															 foreach ($filWeeks as $fw):{
																			 $this->request->data['EmpSched']['id'] = null;
																			 $existingId = $this->EmpSched->checkExist($fw, $id);

																			 $this->request->data['EmpSched']['emp_id'] = $id;
																			 $this->request->data['EmpSched']['sched_id'] = $schedOrder;
																			 $this->request->data['EmpSched']['week_id'] = $fw;
																			 $this->set(compact('existingId'));																			 
																			 if ($existingId == null){
																							 $this->EmpSched->save($this->request->data);
																							 $this->Session->setFlash('Schedule has been successfully added');
																			 }
																			 else{
																							 $this->request->data['EmpSched']['id'] = $existingId['EmpSched']['id'];
																							 $this->EmpSched->save($this->request->data);
																							 $this->Session->setFlash('Schedule has been updated');
																			 }
															 }
															 endforeach;
																$this->redirect(array('action' => 'view_emp', $id));
                        }
                }

		}

		public function edit_selected_sched($id=null, $schedId){
						$this->Employee->id = $id;
						$this->Schedule->id = $schedId;
						$shifts = $this->Shift->find('list',array(
																		'fields' => array('Shift.time_shift'),
																		'conditions' => array('Shift.authorize')
																		));

						$this->set(compact('shifts'));
						$actions = $this->Historytype->find('list',array(
																		'fields' => array('Historytype.name')
																		));

						$this->set(compact('actions'));
						$user = $this->User->find('list',array(
																		'fields' => array('User.id')
																		));

						$this->set(compact('user'));
						$employee = $this->Employee->find('first',array(
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
																														'Employee.id = Schedules.id'
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
																								 )
																										),
																						'conditions' => array(
																														'Employee.id' => $id,
																														'Schedules.id' => $schedId
																														)
																										));

						$this->set(compact('employee'));
						$reqSDate;
						$reqEDate;

						$reqSDate =$this->data['Employee']['start_date']['year'].'-'.$this->data['Employee']['start_date']['month'].'-'.$this->data['Employee']['start_date']['day'];
						$reqEDate =$this->data['Employee']['end_date']['year'].'-'.$this->data['Employee']['end_date']['month'].'-'.$this->data['Employee']['end_date']['day'];

						$hisType = $this->Schedule->findActionTaken($id);
						$condStartDate = $this->Schedule->findExSched($reqSDate,$id,$schedId);
						$condEndDate = $this->Schedule->findExSched($reqEDate,$id,$schedId);

						if (($condStartDate == true)&&($this->data['action_taken'] == $hisType)){
										$this->Session->setFlash('Target start date exists on this employee`s schedule.');
						} else if (($condEndDate == true)&&($this->data['action_taken'] == $hisType)){
										$this->Session->setFlash('Target end date exists on this employee`s schedule.');
						}
						else if ($reqSDate > $reqEDate){
										$this->Session->setFlash('Invalid date range');
						} else {
										if (empty($this->data)) {
														$this->data = $this->Schedule->read();
														$this->data = $this->Shift->read();
														$this->data = $this->Scheduleoverride->read();
										} else {
														if ($this->data['action_taken'] == '1') {
																		$this->request->data['history_type_id'] = '1';
														} else  {
																		$this->request->data['history_type_id'] = '2';
														}
														//$schedId =  $this->Schedule->getLastInsertID();
														if ($this->Schedule->save($this->data)){
																		//$schedId =  $this->Schedule->getLastInsertID();
																		$this->request->data['start_date']  = $reqSDate;
																		$this->request->data['end_date']  = $reqEDate;
																		$this->Schedule->save($this->request->data);
																		$this->request->data['sched_id']  = $schedId;
																		$this->request->data['id'] = null;
																		$this->History->save($this->request->data);
																		$this->Session->setFlash('The schedule has been updated.');
																		$this->redirect(array('action' => 'view_emp',$id));
														}
										}
						}
		}

		public function view_emp($id=null){




						$sdate = date("Y-m-d", time());
						$total = $this->Cutoff->getCutOffAvailable($sdate);
						$this->set(compact('total'));
						$cutDropDown = $this->Cutoff->getCutOffRecent($sdate);
						if ($this->data['Emp']['cut_off'] == null)
						{
										$dayCutOff = date('d');
                    if (($dayCutOff >= '16') && ($dayCutOff <= '30'))
                    {
														$sdates =  date('Y').'-'.date('m').'-11';
                            $edates =  date('Y').'-'.date('m').'-25';

                    }
                    else {
														$sdates =  date('Y').'-'.date('m', strtotime("-1 month")).'-26';
                            $edates =  date('Y').'-'.date('m').'-10';

                    }
						
}
						else
						{
										$cutDropDown = $this->data['Emp']['cut_off']; 
										$sdates = $this->Cutoff->getCutOffPeriodStart($this->data['Emp']['cut_off']);
										$edates = $this->Cutoff->getCutOffPeriodEnd($this->data['Emp']['cut_off']);
						}
						$this->set(compact('cutDropDown'));
						$this->set(compact('sdates'));
						$this->set(compact('edates'));
						$weekStart =  $this->Week->getAllStart();
						$weekEnd =  $this->Week->getAllEnd();
						$weekNum =  $this->Week->getWeekNo();
						$this->set(compact('weekStart'));
						$this->set(compact('weekEnd'));
						$this->set(compact('weekNum'));

						$cutoffLoan=$this->Cutoff->find('first',array('conditions'=>array('Cutoff.id'=>$cutDropDown)));
						$this->set(compact('cutoffLoan'));
						$histor = $this->Employee->find('all',array(
																		'fields' => array(
																						'Employee.id',
																						'EmpSched.id',
																						'EmpSched.week_id',
																						'Week.id',
																						'Week.start_date',
																						'Week.end_date',
																						'Schedule.rd',
																						'Schedule.time_in',
																						'Schedule.time_out',
																						),
																		'joins' => array(
																						array(
																										'type' => 'left',
																										'table' => 'emp_scheds',
																										'alias' => 'EmpSched',
																										'conditions' => array(
																														'Employee.id = EmpSched.emp_id'
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'weeks',
																										'alias' => 'Week',
																										'conditions' => array(
																														'EmpSched.week_id = Week.id'
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'schedules',
																										'alias' => 'Schedule',
																										'conditions' => array(
																														'EmpSched.sched_id = Schedule.order_schedules'
																														)
																								 ),
																						),
																						'conditions' => array(
																														'Employee.id' => $id
																														)
																										));
						$this->set(compact('histor'));

						$empLoans = $this->Loan->find('all',array(
																		'joins'=>array(
																						array(
																										'type' => 'left',
																										'table' => 'cutoffs',
																										'alias' => 'Cutoff',
																										'conditions' => array(
																														'Cutoff.id'=> $cutDropDown
																														)
																								 ),
																						),
																		'conditions'=>array(
																						'Loan.emp_id'=>$id,
																						'((Loan.start_date >= Cutoff.start_date and Loan.start_date <= Cutoff.end_date) or ((Loan.end_date > Cutoff.end_date) or (Loan.end_date >= Cutoff.end_date))) and (Loan.start_date < Cutoff.end_date)'
																						 )));

						$this->set(compact('empLoans'));
						$no_log = $this->Employee->getEmployeeNoLog($id);
            $this->set(compact('no_log'));

						$employee = $this->Employee->find('first',array(
																		'fields' => array(
																						'Employee.id',
																						'Employee.userinfo_id',
																						'Employee.monthly',
																						'Employee.tax_status',																						
																						'Employee.first_name',
																						'Employee.last_name',
																						'Employee.employed',
																						'SubGroup.name',
																						'Schedule.time_in',
																						'Schedule.time_out',
																						'Schedule.id',
																						'EmpSched.week_id',
																						'EmpSched.sched_id',
																						'Week.week_no',
																						'Week.start_date',
																						'Week.end_date'
																						),
																		'joins' => array(
																						array(
																										'type' => 'left',
																										'table' => 'sub_groups',
																										'alias' => 'SubGroup',
																										'conditions' => array(
																														'Employee.subgroup_id =SubGroup.id'
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'emp_scheds',
																										'alias' => 'EmpSched',
																										'conditions' => array(
																														'Employee.id = EmpSched.emp_id'
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'weeks',
																										'alias' => 'Week',
																										'conditions' => array(
																														'Week.week_no=EmpSched.week_id'
																														)
																								 ),
																						array(
																														'type' => 'left',
																														'table' => 'schedules',
																														'alias' => 'Schedule',
																														'conditions' => array(
																																		'EmpSched.sched_id=Schedule.order_schedules'
																																		)
																								 )
																										),
																						'conditions' => array(
																														'Employee.id' => $id
																														),
																						'order' => array(
																														'EmpSched.week_id DESC'
																														)
																										));
		
						$this->set(compact('employee'));
						$schedId = $this->Week->findScheduleId($sdate,$id);
            $this->set(compact('schedId'));
						$startin = $this->Employee->find('first',array(
																		'fields' => array(
																						'Schedule.time_in',
																						'Schedule.time_out',
																						'Schedule.id',
																						'EmpSched.week_id',
																						'EmpSched.sched_id',
																						'Week.week_no',
																						'Week.start_date',
																						'Week.end_date'
																						),
																		'joins' => array(
																						array(
																										'type' => 'left',
																										'table' => 'groups',
																										'alias' => 'Group',
																										'conditions' => array(
																														'Employee.subgroup_id = Group.id'
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'emp_scheds',
																										'alias' => 'EmpSched',
																										'conditions' => array(
																														'Employee.id = EmpSched.emp_id'
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'weeks',
																										'alias' => 'Week',
																										'conditions' => array(
																														'Week.week_no=EmpSched.week_id'
																														)
																								 ),
																						array(
																														'type' => 'left',
																														'table' => 'schedules',
																														'alias' => 'Schedule',
																														'conditions' => array(
																																		'EmpSched.sched_id=Schedule.order_schedules'
																																		)
																								 )
																										),
																						'conditions' => array(
																														'Employee.id' => $id
																														),
																						'order' => array(
																														'EmpSched.week_id DESC'
																														)
																										));

						$this->set(compact('startin'));


				      
                        $userinfo=$employee['Employee']['userinfo_id'];
                        $dbName = $_SERVER["DOCUMENT_ROOT"] . "/aps/attBackup.mdb";
                        if (!file_exists($dbName)) {
                        die("Could not find database file.");
                        }
                        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$dbName; Uid=; Pwd=;");
                        $sql  = "SELECT CHECKTIME FROM CHECKINOUT WHERE USERID = $userinfo AND CHECKTYPE = 'O' ORDER BY CHECKTIME ASC";
                        $result = $db->query($sql);
                        $couts = $result->fetchAll(PDO::FETCH_COLUMN);
                        $this->set(compact('couts'));
						
                        $sql  = "SELECT CHECKTIME FROM CHECKINOUT WHERE USERID = $userinfo AND CHECKTYPE = 'O' ORDER BY CHECKTIME DESC";
                        $result = $db->query($sql);
                        $cout_reverses = $result->fetchAll(PDO::FETCH_COLUMN);
                        $this->set(compact('cout_reverses'));

                        $sql  = "SELECT CHECKTIME FROM CHECKINOUT WHERE USERID = $userinfo AND CHECKTYPE = 'I' ORDER BY CHECKTIME DESC";
                        $result = $db->query($sql);
                        $cins = $result->fetchAll(PDO::FETCH_COLUMN);
                        $this->set(compact('cins'));

						$holidays = $this->Holiday->find('all',array(
																		'fields' => array(
																						'Holiday.date', 'Holiday.regular'),
																		'conditions' => array('Holiday.authorize' => '1')

																		));

						$this->set(compact('holidays'));

						$excemptions = $this->Scheduleoverride->find('all',array(
																		'fields' => array(
																						'Scheduleoverride.start_date',
																						'Scheduleoverride.end_date',
																						'Scheduleoverride.time_in',
																						'Scheduleoverride.time_out',
																						'Scheduleoverride_type.name',
																						),
																		'joins' => array(
																						array(
																										'type' => 'left',
																										'table' => 'scheduleoverride_types',
																										'alias' => 'Scheduleoverride_type',
																										'conditions' => array(
																														'Scheduleoverride.scheduleoverride_type_id = Scheduleoverride_type.id',
																														)
																								 ),
																						),
																		'conditions' => array(
																						'Scheduleoverride.emp_id' => $employee['Employee']['id'],
																						),
																		));

						$this->set(compact('excemptions'));
						$shiftOrder = $this->EmpSched->find('all',array(
																		'fields'=>array(
																						'EmpSched.sched_id',
																						),
																		'conditions' => array(
																						'EmpSched.emp_id' => $employee['Employee']['id'],
																						),
																		));
						$this->set(compact('shiftOrder'));

						$res=$this->data;
						$this->set(compact('res'));


						$emplosched = $this->EmpSched->find('all',array(
																		'fields' => array(
																						'Schedule.time_in',
																						'Schedule.time_out',
																						'Week.start_date',
																						'Week.end_date',
																						),
																		'joins' => array(
																						array(
																										'type' => 'left',
																										'table' => 'schedules',
																										'alias' => 'Schedule',
																										'conditions' => array(
																														'EmpSched.sched_id=Schedule.order_schedules',
																														)
																								 ),
																						array(
																										'type' => 'left',
																										'table' => 'weeks',
																										'alias' => 'Week',
																										'conditions' => array(
																														'EmpSched.week_id=Week.week_no',
																														)
																								 ),
																						),
																		'conditions' => array(
																										'EmpSched.emp_id' => $employee['Employee']['id'],
																										),
																		));

						$this->set(compact('emplosched'));

						$this->set(compact('Employsched'));

#SHIFT TO SCHEDULE
						$exs=$this->Schedule->find('all',array(
																		'fields'=>array(
																						'Schedule.id',
																						'Schedule.time_in',
																						'Schedule.time_out'
																						)
																		));

						$this->set(compact('exs'));
						$govDeduc = $this->Govdeduction->getGovTax($employee['Employee']['tax_status'], Security::cipher($employee['Employee']['monthly'], 'my_key')); /*$employee['Employee']['monthly']*/
						$this->set(compact('govDeduc'));
		}

		public function edit($id=null){
            $this->Employee->id = $id;

            $subgroups = $this->SubGroup->find('list',array(
                                    'conditions' => array('authorize' => '1'),
                                    'order' => array('group_id' => 'ASC')
                                    ));
            $this->set(compact('subgroups'));

            $gp = $this->Employee->find('first',array(
                                    'fields' => array(
                                            'Employee.id',
                                            'Employee.first_name',
                                            'Employee.last_name',
																						'Employee.monthly',                                          
																						'Employee.subgroup_id',
                                            'Group.id',
                                            'Group.name',
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'sub_groups',
                                                    'alias' => 'SubGroup',
                                                    'conditions' => array(
                                                            'Employee.subgroup_id = SubGroup.id'
                                                            )),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'groups',
                                                    'alias' => 'Group',
                                                    'conditions' => array(
                                                            'SubGroup.group_id = Group.id'
                                                            ))
                                            ),
                                    'conditions' => array(
                                                    'Employee.id' => $id
                                                    )
                                            ));

            $this->set(compact('gp'));
						$decMonthly = $this->Employee->encryptValue($gp['Employee']['monthly']);
						$this->set(compact('decMonthly'));
            $eData = $this->data;
						if (empty($eData)) {
                    $this->data = $this->Employee->read();
            } else {
								$eData['Employee']['monthly']  =$this->Employee->encryptValue($this->data['Employee']['monthly']);
                    if ($this->Employee->save($eData)) {
                            $this->Session->setFlash('Employee information has been updated.');
                            $this->redirect(array( 'controller' => 'Employees',
													 'action' => 'view_emp', $id));
                    }
            }


		}

		public function add_schedule($id=null){
						$employee = $this->Employee->find('first',array(
																		'fields' => array(
																						'Employee.id',
																						'Employee.first_name',
																						'Employee.last_name',
																						'Group.name',
																						'Schedules.start_date',
																						'Schedules.end_date'
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
																														'Employee.id = Schedules.id'
																														)
																								 )
																						),
																		'conditions' => array(
																										'Employee.id' => $id
																										)
																						));

						$this->set(compact('employee'));
		}

		public function add_employee(){
						$subgroups = $this->SubGroup->find('list',array(
																		'conditions' => array('authorize' => '1'),
																		'order' => array('group_id' => 'ASC')
																		));
						$this->set(compact('subgroups'));

						if (!empty($this->data)){
										if($this->Employee->save($this->data)){
														$secretMonthly = Security::cipher($this->data['Employee']['monthly'], 'my_key');
														$this->request->data['Employee']['monthly'] = $secretMonthly;										
														$this->request->data['Employee']['id'] =$this->Employee->getLastInsertID();
														$this->Employee->save($this->request->data);													
														$this->Session->setFlash('New Employee Saved!');
														$this->redirect(array('action' => 'index'));
										}
						}
		}

		public function modify_sched($id = null){}
		public function edit_day_sched($id=null, $dateId){
						$curr_date_ymd = date('Y-m-d', $dateId);
						$this->set('curr_date_ymd', $curr_date_ymd);
						$this->Employee->id = $id;
						$schedId = $this->Week->findScheduleId($curr_date_ymd,$id);
						$this->set(compact('schedId'));
						$schedExist = $this->Scheduleoverride->find('count',array(
																		'conditions' => array('Scheduleoverride.emp_id' => $id,'start_date' => $curr_date_ymd )));
						$this->set(compact('schedExist'));
						$employee = $this->Employee->getEmployeeSchedulePrf($id, $schedId);
				  	$this->set(compact('employee'));
						$actions = $this->Scheduleoverride_type->findTypes();
						$this->set(compact('actions'));
						$shifts = $this->Schedule->getShifts();
						$this->set(compact('shifts'));	
						$defaultTimeIn = $this->Schedule->findTimeInCheck($schedId);
						$this->set(compact('defaultTimeIn'));				
						$defaultTimeOut = $this->Schedule->findTimeOutCheck($schedId);
						$this->set(compact('defaultTimeOut'));
						$schedTime = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd); 
						$this->set(compact('schedTime'));		

						if (empty($this->data)) {
										$this->data = $this->Schedule->read();
										$this->data = $this->Shift->read();
										$this->data = $this->Restday->read();
										$this->data = $this->Scheduleoverride->read();
						} else {
										$this->request->data['start_date'] = $curr_date_ymd;
										$this->request->data['end_date'] = $curr_date_ymd;
									  $this->request->data['emp_id'] = $id;
										$this->request->data['create_by'] = $_SESSION['Auth']['User']['User']['id'];
										$schedTime = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);
										$this->set(compact('schedTime'));

										$this->request->data['create_time'] = date("Y-m-d H:i:s");
										if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '2') {
														if ($this->Scheduleoverride->save($this->data)){
																		$over = $this->Scheduleoverride->getLastInsertID();
																		$this->request->data['sched_id']  = null;
																		$this->request->data['history_type_id'] = '4';
																		$this->request->data['id'] = null;
																		$this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);																	
																		$this->History->save($this->request->data);
																		$this->Session->setFlash('Schedule successfully marked as restday.');
														}
										}
										else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '4') {
														if ($this->Scheduleoverride->save($this->data)){
																		$over = $this->Scheduleoverride->getLastInsertID();
																		$this->request->data['sched_id']  = null;
																		$this->request->data['history_type_id'] = '4';
																		$this->request->data['id'] = null;
																		$this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);																	
																		$this->History->save($this->request->data);
																		$this->Session->setFlash('Schedule successfully marked as sick leave.');
														}
										}
										else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '3') {
														if ($this->Scheduleoverride->save($this->data)){
																		$over = $this->Scheduleoverride->getLastInsertID();
																		$this->request->data['sched_id']  = null;
																		$this->request->data['history_type_id'] = '4';
																		$this->request->data['id'] = null;
																		$this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);																	
																		$this->History->save($this->request->data);
																		$this->Session->setFlash('Schedule successfully marked as vacation leave.');
														}
										}
										else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '5') {
														if ($this->Scheduleoverride->save($this->data)){
																		$over = $this->Scheduleoverride->getLastInsertID();
																		$this->request->data['sched_id']  = null;
																		$this->request->data['history_type_id'] = '4';
																		$this->request->data['id'] = null;
																		$this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);
																		$this->History->save($this->request->data);
																		$this->Session->setFlash('Schedule successfully marked as half day.');
														}
										}
										else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '1') {
														if ($this->Scheduleoverride->save($this->data)){
																		$over = $this->Scheduleoverride->getLastInsertID();
																		$this->request->data['sched_id']  = null;
																		$this->request->data['history_type_id'] = '4';
																		$this->request->data['id'] = null;
																		$this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);															
																		$this->History->save($this->request->data);
																		$this->Session->setFlash('Schedule successfully changed.');
														}
										}
										 else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '6') {
                            if ($this->Scheduleoverride->save($this->data)){
                                    $over = $this->Scheduleoverride->getLastInsertID();
                                    $this->request->data['sched_id']  = null;
                                    $this->request->data['history_type_id'] = '15';
                                    $this->request->data['id'] = null;
                                    $this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);
                                    $this->History->save($this->request->data);
                                    $this->Session->setFlash('Schedule marked as leave with no pay.');
                            }
                    }
										else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '7') {
                            if ($this->Scheduleoverride->save($this->data)){
                                    $over = $this->Scheduleoverride->getLastInsertID();
                                    $this->request->data['sched_id']  = null;
                                    $this->request->data['history_type_id'] = '4';
                                    $this->request->data['id'] = null;
                                    $this->request->data['scheduleoverride_id'] = $this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd);
                                    $this->History->save($this->request->data);
                                    $this->Session->setFlash('Schedule successfully marked as offset.');
                            }
                    }
										else if ($this->data['Scheduleoverride']['scheduleoverride_type_id'] == '8') {
														$this->Scheduleoverride->delete($this->Scheduleoverride->findSchebyTimeAndEmp($id,$curr_date_ymd));
														$this->Session->setFlash('Excemption successfully removed.');
                            
                    }

									$this->redirect(array('action' => 'view_emp', $id));									
						}
		}

 public function error($id=null, $dateId) {
          $curr_date_ymd = date('Y-m-d', $dateId);
          $this->set('curr_date_ymd', $curr_date_ymd);
          $this->Employee->id = $id;
          $schedId = $this->Week->findScheduleId($curr_date_ymd,$id);
          $employee = $this->Employee->getEmployeeSchedulePrf($id, $schedId);
          $this->set(compact('employee'));
          $checkTime = $this->Checkinout->findEmployeeLogIn($id, $curr_date_ymd);
          $checkTimeOut = $this->Checkinout->findEmployeeLogOut($id, $curr_date_ymd);
          if ($checkTime != null)
          {
                  $checkIn = $checkTime[0]['Checkinout']['CHECKTIME'];
          }
          else
          {
                  $checkIn = null;
          }
          if ($checkTimeOut != null)
          {
                  $checkOut = $checkTimeOut[0]['Checkinout']['CHECKTIME'];
          }
          else
          {
                  $checkOut = null;
          }
           $this->set(compact('checkIn'));
           $this->set(compact('checkOut'));
   if (!empty($this->data)){
                   if($this->Checkinout->save($this->data))
                   {
                           $this->Session->setFlash('Log Entry Saved!');
                           $this->request->data['Checkinout']['USERID'] = $employee['Employee']['userinfo_id'];
                           $this->request->data['Checkinout']['CHECKTIME'] = $this->data['Checkinout']['CHECKTIME2'];
                           $this->request->data['Checkinout']['CHECKTYPE'] = 'O';
                           $this->Checkinout->save($this->request->data);
                           $this->Session->setFlash('Log Entry Saved!');
                           $this->redirect(array('action' => 'view_emp', $id));
                   }
           }

}

	public function ot() {   }
	public function nightdiff() {   }
	public function holiday() {   }
  public function view_all($dateId){
					$this->layout='view_all';
					$employees = $this->Employee->find('all', array(
																							 'conditions' => array(
																											 'employed' => '1'
                                                              ),
																								'order' => array(
																												'subgroup_id' => 'ASC',
																												'last_name' => 'ASC',
																												'first_name' => 'ASC')
																	));
					$this->set(compact('employees'));
					$empCount = $this->Employee->find('count', array(
                                               'conditions' => array(
                                                       'employed' => '1')));	
					$total = $this->Total->fetchEmployeesOfCutOff($dateId);
					$this->set(compact('total'));
					$this->set(compact('dateId'));
					$this->set(compact('empCount'));
					$startCut = $this->Cutoff->getCutOffPeriodStart($dateId);
					$endCut = $this->Cutoff->getCutOffPeriodEnd($dateId);
					   $this->set(compact('startCut'));
         $this->set(compact('endCut'));

  }
 public function view_all2($id=null,$dateId){
				 $startCut = $this->Cutoff->getCutOffPeriodStart($dateId); 
				 $endCut = $this->Cutoff->getCutOffPeriodEnd($dateId);				 
				 $this->set(compact('startCut'));
				 $this->set(compact('endCut'));
				 $this->layout='view_all';
				 $yearCutOff = $this->Employee->getYearCutOff();
				 $this->set(compact('yearCutOff'));
				 $sDayCut = $this->Employee->getSDayCutOffs();
				 $this->set(compact('sDayCut'));
				 $eDayCut = $this->Employee->getEDayCutOffs();
				 $this->set(compact('eDayCut'));
				 $this->set(compact('dateId'));
				 if ($this->data['Emp']['end_date'] == null)
				 {$dayCutOff = date('d');
								 if (($dayCutOff >= '1') && ($dayCutOff <= '15'))
								 {
												 $sdates =  date('Y').'-'.date('m', strtotime("-1 month")).'-26';
												 $edates =  date('Y').'-'.date('m').'-10';
								 }
								 else {
												 $sdates =  date('Y').'-'.date('m').'-11';
												 $edates =  date('Y').'-'.date('m').'-25';
								 }
				 }
				 else
				 {
								 $sdates =$yearCutOff[$this->data['Emp']['start_date']].'-'.$this->data['Emp']['start_date_month']['month'].'-'.$sDayCut[$this->data['Emp']['start_date_day']];
								 $edates =$yearCutOff[ $this->data['Emp']['end_date']] .'-'.$this->data['Emp']['end_date_month']['month'].'-'.$eDayCut[$this->data['Emp']['end_date_day']];
				 }
				 $this->set(compact('sdates'));
				 $this->set(compact('edates'));
				 $weekStart =  $this->Week->getAllStart();
				 $weekEnd =  $this->Week->getAllEnd();
				 $weekNum =  $this->Week->getWeekNo();
				 $this->set(compact('weekStart'));
				 $this->set(compact('weekEnd'));
				 $this->set(compact('weekNum'));
            $empLoans = $this->Loan->find('all',array(
                                    'joins'=>array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'cutoffs',
                                                    'alias' => 'Cutoff',
                                                    'conditions' => array(
                                                            'Cutoff.id'=> $dateId
                                                            )
                                                 ),
                                            ),
                                    'conditions'=>array(
                                            'Loan.emp_id'=>$id,
                                            '((Loan.start_date >= Cutoff.start_date and Loan.start_date <= Cutoff.end_date) or ((Loan.end_date > Cutoff.end_date) or (Loan.end_date >= Cutoff.end_date))) and (Loan.start_date < Cutoff.end_date)'
                                             )));

            $this->set(compact('empLoans'));

            $cutoffLoan=$this->Cutoff->find('first',array('conditions'=>array('Cutoff.id'=>$dateId)));
            $this->set(compact('cutoffLoan'));

				 $histor = $this->Employee->find('all',array(
                                    'fields' => array(
                                            'Employee.id',
                                            'EmpSched.id',
                                            'EmpSched.week_id',
                                            'Week.id',
                                            'Week.start_date',
                                            'Week.end_date',
                                            'Schedule.rd',
                                            'Schedule.time_in',
                                            'Schedule.time_out',
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'emp_scheds',
                                                    'alias' => 'EmpSched',
                                                    'conditions' => array(
                                                            'Employee.id = EmpSched.emp_id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                                                                                                                              'table' => 'weeks',
                                                    'alias' => 'Week',
                                                    'conditions' => array(
                                                            'EmpSched.week_id = Week.id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'schedules',
                                                    'alias' => 'Schedule',
                                                    'conditions' => array(
                                                            'EmpSched.sched_id = Schedule.order_schedules'
                                                            )
                                                 ),
                                            ),
                                            'conditions' => array(
                                                            'Employee.id' => $id
                                                            )
                                                    ));
            $this->set(compact('histor'));
            $employee = $this->Employee->find('first',array(
                                    'fields' => array(
                                            'Employee.id',
                                            'Employee.userinfo_id',
                                            'Employee.first_name',
                                            'Employee.last_name',
																						'Employee.tax_status',                                       
																						'Employee.monthly',
                                            'Employee.employed',
																						'Employee.account_id',                              
																						'Group.name',
                                            'Schedule.time_in',
                                            'Schedule.time_out',
                                            'Schedule.id',
                                            'EmpSched.week_id',
                                            'EmpSched.sched_id',
                                            'Week.week_no',
                                            'Week.start_date',
                                            'Week.end_date'
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'groups',
                                                    'alias' => 'Group',
                                                    'conditions' => array(
                                                            'Employee.subgroup_id = Group.id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'emp_scheds',
                                                    'alias' => 'EmpSched',
                                                    'conditions' => array(
                                                            'Employee.id = EmpSched.emp_id'
                                                            )
                                                 ),
                                            array(
                                                  'type' => 'left',
                                                    'table' => 'weeks',
                                                    'alias' => 'Week',
                                                    'conditions' => array(
                                                            'Week.week_no=EmpSched.week_id'
                                                            )
                                                 ),
                                            array(
                                                            'type' => 'left',
                                                            'table' => 'schedules',
                                                            'alias' => 'Schedule',
                                                            'conditions' => array(
                                                                    'EmpSched.sched_id=Schedule.order_schedules'
                                                                    )
                                                 )
                                                    ),
                                            'conditions' => array(
                                                            'Employee.id' => $id
                                                            ),
                                            'order' => array(
                                                            'EmpSched.week_id DESC'
                                                            )
                                                    ));

            $this->set(compact('employee'));
						 $no_log = $this->Employee->getEmployeeNoLog($id);
            $this->set(compact('no_log'));

            $startin = $this->Employee->find('first',array(
                                    'fields' => array(
                                            'Schedule.time_in',
                                            'Schedule.time_out',
                                            'Schedule.id',
                                            'EmpSched.week_id',
                                            'EmpSched.sched_id',
                                            'Week.week_no',
                                            'Week.start_date',
                                            'Week.end_date'
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'groups',
                                                    'alias' => 'Group',
                                                    'conditions' => array(
                                                            'Employee.subgroup_id = Group.id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'emp_scheds',
                                                    'alias' => 'EmpSched',
                                                    'conditions' => array(
                                                            'Employee.id = EmpSched.emp_id'
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'weeks',
                                                    'alias' => 'Week',
                                                                                                                             'alias' => 'Week',
                                                    'conditions' => array(
                                                            'Week.week_no=EmpSched.week_id'
                                                            )
                                                 ),
                                            array(
                                                            'type' => 'left',
                                                            'table' => 'schedules',
                                                            'alias' => 'Schedule',
                                                            'conditions' => array(
                                                                    'EmpSched.sched_id=Schedule.order_schedules'
                                                                    )
                                                 )
                                                    ),
                                            'conditions' => array(
                                                            'Employee.id' => $id
                                                            ),
                                            'order' => array(
                                                            'EmpSched.week_id DESC'
                                                            )
                                                    ));

            $this->set(compact('startin'));


            $cins = $this->Checkinout->find('all',array(
                                    'fields' => array(
                                            'Checkinout.CHECKTIME',
                                            ),
                                    'conditions' => array(
                                            'Checkinout.USERID' => $employee['Employee']['userinfo_id'],
                                            'Checkinout.CHECKTYPE' => 'I',
                                            ),
                                    'order' => array(
                                            'Checkinout.CHECKTIME DESC',
                                            ),
                                    ));

            $this->set(compact('cins'));
            $couts = $this->Checkinout->find('all',array(
                                    'fields' => array(
                                            'Checkinout.CHECKTIME',
                                            ),
                                    'conditions' => array(
                                            'Checkinout.USERID' => $employee['Employee']['userinfo_id'],
                                            'Checkinout.CHECKTYPE' => 'O',
                                            ),
                                    'order' => array(
                                            'Checkinout.CHECKTIME ASC',
                                            ),
                                    ));

            $this->set(compact('couts'));
            $cout_reverses = $this->Checkinout->find('all',array(
                                    'fields' => array(
                                            'Checkinout.CHECKTIME',
                                            ),
                                   'conditions' => array(
                                            'Checkinout.USERID' => $employee['Employee']['userinfo_id'],
                                            'Checkinout.CHECKTYPE' => 'O',
                                            ),
                                    'order' => array(
                                            'Checkinout.CHECKTIME DESC',
                                            ),
                                    ));

            $this->set(compact('cout_reverses'));

            $holidays = $this->Holiday->find('all',array(
                                    'fields' => array(
                                            'Holiday.date', 'Holiday.regular'),
                                    'conditions' => array('Holiday.authorize' => '1')

                                    ));

            $this->set(compact('holidays'));

            $excemptions = $this->Scheduleoverride->find('all',array(
                                    'fields' => array(
                                            'Scheduleoverride.start_date',
                                            'Scheduleoverride.end_date',
                                            'Scheduleoverride.time_in',
                                            'Scheduleoverride.time_out',
                                            'Scheduleoverride_type.name',
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'scheduleoverride_types',
                                                    'alias' => 'Scheduleoverride_type',
                                                    'conditions' => array(
                                                            'Scheduleoverride.scheduleoverride_type_id = Scheduleoverride_type.id',
                                                            )
                                                 ),
                                            ),
                                    'conditions' => array(
                                            'Scheduleoverride.emp_id' => $employee['Employee']['id'],
                                            ),
                                    ));

            $this->set(compact('excemptions'));
            $shiftOrder = $this->EmpSched->find('all',array(
                                    'fields'=>array(
                                            'EmpSched.sched_id',
                                            ),
                                    'conditions' => array(
                                            'EmpSched.emp_id' => $employee['Employee']['id'],
                                            ),
                                    ));
            $this->set(compact('shiftOrder'));

            $res=$this->data;
            $this->set(compact('res'));
            $emplosched = $this->EmpSched->find('all',array(
                                    'fields' => array(
                                            'Schedule.time_in',
                                            'Schedule.time_out',
                                            'Week.start_date',
                                            'Week.end_date',
                                            ),
                                    'joins' => array(
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'schedules',
                                                    'alias' => 'Schedule',
                                                    'conditions' => array(
                                                            'EmpSched.sched_id=Schedule.order_schedules',
                                                            )
                                                 ),
                                            array(
                                                    'type' => 'left',
                                                    'table' => 'weeks',
                                                    'alias' => 'Week',
                                                    'conditions' => array(
                                                            'EmpSched.week_id=Week.week_no',
                                                            )
                                                 ),
                                            ),
                                    'conditions' => array(
                                                    'EmpSched.emp_id' => $employee['Employee']['id'],
                                                    ),
                                    ));

            $this->set(compact('emplosched'));

            $this->set(compact('Employsched'));

#SHIFT TO SCHEDULE
            $exs=$this->Schedule->find('all',array(
                                    'fields'=>array(
                                            'Schedule.id',
                                            'Schedule.time_in',
                                            'Schedule.time_out'
                                            )
                                    ));

            $this->set(compact('exs'));
						$govDeduc = $this->Govdeduction->getGovTax($employee['Employee']['tax_status'],Security::cipher( $employee['Employee']['monthly'], 'my_key'));
						$this->set(compact('govDeduc'));
					
					#	if($this->data != null){
					#	}

    }
#######PDF
public function view_pdf($id = null) {
    $this->Employee->id = $id;
    if (!$this->Employee->exists()) {
        throw new NotFoundException(__('Invalid post'));
    }
    // increase memory limit in PHP 
    ini_set('memory_limit', '512M');
    $this->set('post', $this->Employee->read(null, $id));
}
                                                                                                                       

}?>
