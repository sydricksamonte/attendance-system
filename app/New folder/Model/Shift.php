<?php
class Shift extends AppModel {
				public function check($id)
				{
								$exist = $this->find('count', array('conditions' => array('time_shift' => $id)));
								if ($exist == 0)
								{
												return false;
								}
								else
								{
												return true;
								}
				}
function findStartTime($id)
        {
                $start_time = $this->find('first', array('conditions' => array('id' => $id)));
  return ($start_time['Shift']['start_time']);

        }

function findEndTime($id)
        {
                $end_time = $this->find('first', array('conditions' => array('id' => $id)));
                return ($end_time['Shift']['end_time']);

        }
}
?>

