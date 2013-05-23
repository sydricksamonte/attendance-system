<?php
echo $this->Form->create('Total');
echo $this->Form->input('Cutoff List',array('type'=>'select','options'=>$cutoffList));
echo $this->Form->end('View Payslip');
debug ($this->data);
?>
