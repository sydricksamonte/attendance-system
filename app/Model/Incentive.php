<?php
class Incentive extends AppModel{
				function getOverTime($emp_id,$date_id,$type)
				{
								$time = $this->find('first', array('conditions' => array('emp_id' => $emp_id,'type' => $type, 'date' => $date_id )));
#								if ($time != null)	
								{
												return ($time['Incentive']['hour']);
								}
#								else
#								{
#												return null;
#								}
				}
}
?>
