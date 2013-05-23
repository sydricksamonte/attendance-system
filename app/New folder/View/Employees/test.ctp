<?php
//debug($all);
//echo $this->
echo $this->form->input('User.id',array('type'=>'select', 'options'=>array(1,2,3,4,5,6,7), 'value' => array(1,2,3,4,5,6),'multiple' =>  'checkbox'));
//echo $this->form->checkbox('User.id'.$all['Employee']['id'].'', array('value' => $all['Employee']['id']));
echo $this->form->end('test');
debug($this->data['User']);

?>
