<?php
echo $this->Form->create('Loan');
echo $this->Form->input('id',array('type'=>'hidden','value'=>null));
echo $this->Form->input('emp_id',array('type'=>'hidden','value'=>$emp_id));
echo '<h3>'.$employee['Employee']['first_name'].' '.$employee['Employee']['last_name'].'</h3>';
echo $this->Form->input('loan_type',array('type'=>'select','options'=>array('SSS','HMDF')));
echo $this->Form->input('amount',array('type'=>'text'));
echo $this->Form->input('start_date',array('style'=>'width:90px'));
echo $this->Form->input('end_date',array('style'=>'width:90px'));
echo $this->Form->end("Save");
?>
<a href="javascript:window.history.back()">Back</a>
