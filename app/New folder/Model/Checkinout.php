<?php
class Checkinout extends AppModel{
  
	function findEmployeeLogIn($emp_id, $date)
	{
					$empFields = $this->find('all',array(
																	'fields' => array(
																					'Checkinout.CHECKTIME'
																					),
																	'joins' =>  array(
																					array( 
																									'type' => 'inner',
																									'table' => 'employees',
																									'alias' => 'Employee',
																									'conditions' => array(
																													'Checkinout.USERID = Employee.userinfo_id'
																													)
																							 )
																					),
																	'conditions' => array(
																					array('Employee.id' => $emp_id,'Checkinout.CHECKTYPE' => 'I', 'Checkinout.CHECKTIME LIKE' => $date. '%')
																					),
																	'order' => array(
																									array('Checkinout.CHECKTIME' => 'ASC')
																									),
																	));
					return $empFields;			
	}
	 function findEmployeeLogOut($emp_id, $date)
  {
          $empFields = $this->find('all',array(
                                  'fields' => array(
                                          'Checkinout.CHECKTIME'
                                          ),
                                  'joins' =>  array(
                                          array(
                                                  'type' => 'inner',
                                                  'table' => 'employees',
                                                  'alias' => 'Employee',
                                                  'conditions' => array(
                                                          'Checkinout.USERID = Employee.userinfo_id'
                                                          )
                                               )
                                          ),
                                  'conditions' => array(
                                          array('Employee.id' => $emp_id,
																									'Checkinout.CHECKTYPE' => 'O',
																									'Checkinout.CHECKTIME LIKE' => $date. '%')
                                          ),
                                  'order' => array(
                                                  array('Checkinout.CHECKTIME' => 'DESC')
                                                  ),
                                  ));
          return $empFields;
  }

}
?>
