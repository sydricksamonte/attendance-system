<?php
	class History extends AppModel{
		var $name='Histories';
		var $actsAs=array('Searchable');
		# var $name = 'Histories';
        var $validate = array('emp_id' => array('rule' => 'notEmpty'));



	}
?>
