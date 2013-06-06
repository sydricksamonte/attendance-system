<?php
class Employee extends AppModel{
				function encryptValue($toEncrypt) {
								$secret = Security::cipher($toEncrypt, 'my_key');
								return $secret;
				}
				function findExistingSchedule($date,$id)
        {
               $cond = $this->find('first',array(
                                'joins' => array( array(
              'type' => 'left',
              'table' => 'schedules',
              'alias' => 'Schedules',
              'conditions' => array(
                'Employee.id = Schedules.emp_id'
              )
            )),

                                'conditions' => array(
                                        'and' => array(
                                                array('Schedules.start_date <= ' => $date,
                                                        'Schedules.end_date >= ' => $date
                                                   ),
                                                'Schedules.id' => $id
                                                ))));
                echo $conditions;
                return ($cond);
				}
      function findGroupId($id)
      {
              $groupId = $this->find('first', array('conditions' => array('id' => $id)));
              return ($groupId['Employee']['group_id']);
			}
      function findSchedId($id)
      {
              $groupId = $this->find('first', array('conditions' => array('id' => $id)));
              return ($groupId['Employee']['sched_id']);
      }
      function getYearCutOff()
      {
#get year for cut off
              $dateEt ='2009';
              $dateSt = date('Y');
							$i =0;
              while (($dateSt) >= ($dateEt)) {
                      $exp = $exp. "$dateSt". '_';
                      $dateSt = $dateSt-1;
              }
              $exp =substr_replace($exp, '', -1);
              $yearS  = explode('_',$exp);
              return $yearS;
      }
      function getSDayCutOffs()
      {
              $days = array('26','11');
              return $days;
      }
      function getEDayCutOffs()
      {
              $days = array('10','25');
              return $days;
      }
      function countSchedOfPrevWeek($groupId){
              $netEngCount = $this->find('count',array(
                                      'fields' => array(
                                              'COUNT(DISTINCT EmpSched.emp_id) as count',
                                              ),
                                      'joins' => array(
                                              array(
                                                      'type' => 'inner',
                                                      'table' => 'emp_scheds',
                                                      'alias' => 'EmpSched',
                                                      'conditions' => array(
                                                              'EmpSched.emp_id = Employee.id'
                                                              )
                                                   )),
                                      'conditions' => array(
                                              array( 'Employee.subgroup_id' => $groupId)
                                              )
                                      ));

              return $netEngCount;
      }
      function getAllEmployeeBySubGroup($id)
      {
              $emp = $this->find('list',array('fields' => array('Employee.id'),
                                      'conditions' => array(array( 'Employee.subgroup_id' => $id))
                                      ));
              return $emp;
      }
 function getAllEmployeeInfoBySubGroup($id)
      {
              $emp = $this->find('all',array('conditions' => array( array('Employee.subgroup_id' => $id)),
                                      'order' => array('employed DESC', 'Employee.last_name', 'Employee.first_name')
                                      ));
              return $emp;
      }
      function getEmployeeSchedulePrf($id,$sched_id){
              $employee = $this->find('first',array(
                                      'fields' => array(
                                              'Employee.id',
                                              'Employee.first_name',
                                              'Employee.last_name',
                                              'Employee.userinfo_id',
                                              'EmpSched.sched_id',
                                              'EmpSched.emp_id',
                                              'EmpSched.week_id'
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
                                                      'table' => 'schedules',
                                                      'alias' => 'Schedule',
                                                      'conditions' => array(
                                                              'EmpSched.sched_id = Schedule.order_schedules'
                                                              )
                                                   )
                                              ),
                                              'conditions' => array(
                                                              'Employee.id' => $id,
                                                              'Schedule.order_schedules' => $sched_id
                                                              )
                                                      ));
              return $employee;
      }
		  public function findEmployeeName($id)
			{
							$employee = $this->find('first',array(
																			'fields' => array('first_name', 'last_name'),
																			'conditions' => array('id' => $id)
																			));
							return $employee['Employee']['last_name'] . ', '.$employee['Employee']['first_name'];
			}
			public function getEmployeeNoLog($id)
      {
              $employee = $this->find('count',array(
                                      'conditions' => array('subgroup_id' => '15', 'id' => $id )
                                      ));
              return $employee;
      }

			public $validate = array(
                      'first_name' => array(
                              'alphaNumeric' => array(
                                        'rule'     => '/^[^%#\/*@!1234567890.]+$/',
                                        'required' => true,
                                        'message'  => 'Invalid first name'
                                      ),
                                'between' => array(
                                        'rule'    => array('between', 2, 15),
                                        'message' => 'Between 2 to 15 characters'
                                        )
                                ),
                        'userinfo_id' => array(
                                'alphaNumeric' => array(
                                        'rule'     => '/^[^%#\/*@!,qwertyuiopasdfghjklzxcvbnm<>.]+$/',
                                        'message'  => 'Invalid id'
                                      )
                                ),
                       # 'monthly' => array(
                        #        'alphaNumeric' => array(
                         #               'rule'     => '/^[^%#\/*@!,qwertyuiopasdfghjklzxcvbnm<>.]+$/',
                          #              'required' => true,
                        #                'message'  => 'Invalid value'
                         #             )
                          #      ),

                        'last_name' => array(
                                'alphaNumeric' => array(
                                        'rule'     => '/^[^%#\/*@!1234567890.]+$/',
                                        'required' => true,
                                        'message'  => 'Invalid last name'
                                        ),
                                'between' => array(
                                        'rule'    => array('between', 2, 15),
                                        'message' => 'Between 2 to 15 characters'
                                        )

                                ));

}
?>


