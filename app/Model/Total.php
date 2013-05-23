<?php
class Total extends AppModel{
				function findCutOff($id, $emp_id)
				{
								$cut = $this->find('first',array(
																				'fields' => array(
																								'id',
																								),
																				'conditions' => array(
																								'cutoff_id' => $id, 
																								'emp_id' => $emp_id
																								)
																				));
 								return $cut['Total']['id'];
				}
				function fetchEmployeesOfCutOff($id)
				{
								$totals = $this->find('all',array(
																				'fields' => array('Total.*',
																								'Emp.first_name',
																								'Emp.last_name',
																								'CO.start_date',
																								'CO.end_date'),
																				'joins' => array(
																								array(
																												'type' => 'inner',
																												'table' => 'employees',
																												'alias' => 'Emp',
																												'conditions' => array(
																																'Emp.id = Total.emp_id'
																																)
																										 ),
																								array(
																												'type' => 'inner',
																												'table' => 'cutoffs',
																												'alias' => 'CO',
																												'conditions' => array(
																																'CO.id = Total.cutoff_id'
																																)
																										 )
																								),
																				'conditions' => array(
																												'cutoff_id' => $id,
																												),
																				'order' => array(
																								#				'Emp.subgroup_id' => 'ASC',
																												'Emp.last_name' => 'ASC',
																												'Emp.first_name' => 'ASC'
																								)));
				return $totals;
				}
}
