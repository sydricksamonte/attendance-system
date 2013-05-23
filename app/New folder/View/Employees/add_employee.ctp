<?php
echo $this->Form->create('Employee');
echo $this->Form->input('subgroup_id');
echo $this->Form->input('userinfo_id', array('label' => 'Biometric ID',  'type' => 'text'));
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('monthly',array('label' => 'Monthly Salary', 'type'=>'text', 'value'=> '0'));
echo $this->Form->input('tax_status',array('label'=> 'Tax type', 'type'=>'select', 'options'=> array('S-M-NO', 'S1-M1', 'S2-M2', 'S4-M4')));
echo $this->Form->input('account_id',array('label'=> 'AUB account', 'type'=>'text'));

echo $this->Form->input('Employee.employed', array('value' => '1', 'type' => 'hidden'));
echo $this->Form->input('Employee.id', array('value' => null, 'type' => 'hidden'));
echo $this->Form->end("Add Employee");
?>

