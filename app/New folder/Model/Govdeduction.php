<?php
class Govdeduction extends AppModel{
				function getGovTax($id, $basic)
				{
								$govStat = $this->find('first',array(
																				'fields' => array('basic','sss','philhealth','pagibig','tax'),
																				'conditions' => array(
																								array('type' => $id, 'basic <=' => $basic ),
																								),
																				'order' => array(
																								array('basic' => 'DESC' )
																								)
																				));

								return $govStat;

				}
}
?>
