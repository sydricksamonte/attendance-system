<?php
class SubGroup extends AppModel{
				function fetchGroupName($id)
				{
								$subGroup = $this->find('all', array('conditions' => array('group_id' => $id)));
								return($subGroup);
				}
}
?>

