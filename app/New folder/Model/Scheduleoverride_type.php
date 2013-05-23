<?php
	class Scheduleoverride_type extends AppModel{	
					function findTypes(){
									$types =	$this->find('list',array('fields' => array('name')));
									return ($types);
					}
	}
?>
