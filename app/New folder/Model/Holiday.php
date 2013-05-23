<?php
class Holiday extends AppModel{
				var $name = 'Holidays';
				var $validate = array('name' => array('rule' => 'notEmpty'));
}
?>
