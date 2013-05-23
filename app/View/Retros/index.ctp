<?php
echo $this->Form->create('Retro');
echo $this->Form->input('Employee',array('type'=>'text','value'=>$employee['Employee']['first_name'].' '.$employee['Employee']['last_name']));
echo $this->Form->input('Retro Pay',array('type'=>'text'));
echo $this->Form->end("Save");
?>

<div class="colorw">
<div class="btn btn-primary" style="width:90px">
<?php
echo $this->Html->link('View Payslip',array('controller'=>'Retros','action' => 'payslip', $employee['Employee']['id'], $cuts['Cutoff']['id']));
?></div></div>

