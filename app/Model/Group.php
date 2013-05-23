<?php
class Group extends AppModel{
				function findGroupName($id)
				{
								$groupName = $this->find('first', array('conditions' => array('id' => $id)));
								return($groupName['Group']['name']);
				}
				var $name = 'Groups';
				var $validate = array('name' => array('rule' => 'notEmpty'));
}
?>

