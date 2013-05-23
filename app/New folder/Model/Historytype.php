<?php
class Historytype extends AppModel{
				function fetchLimHistoryTypeForEditDay()
				{ $limitList =  $this->find('list', array('conditions' => array('or' => array(
																								array('id' => '4',
																												'id' => '13'
																										 )
																								))));
				}
}
?>
