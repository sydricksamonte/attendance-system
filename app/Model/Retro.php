<?php
class Retro extends AppModel{
 public $validate = array(
        'Employee' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
            )
        ),
        'Retro Pay' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
		);
}
?>
