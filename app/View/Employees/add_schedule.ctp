<?php
//debug($shifts);
//debug($employee);
?>

<div class="index">
	<h2> Modify Schedule </h2>
	<dl>
		<dt>Employee ID</dt>
		<dd><?php echo $employee['Employee']['id'];?></dd>
		<dt>First Name</dt> 
    <dd><?php echo $employee['Employee']['first_name'];?></dd>
    <dt>Last Name</dt>
    <dd><?php echo $employee['Employee']['last_name'];?></dd>
    <dt>Group</dt>
    <dd><?php echo $employee['Group']['name'];?></dd>
		<dt>Start Date</dt>
		<dd>__</dd>
		<dt>End Date</dt>
		<dd>_</dd>
    <dt><b>Shift schedule</b></dt>
		<dd>
		<?php
				echo $this->Form->input('',array('type' => 'select', 'options' => $shifts));
				echo $this->Form->end('Modify schedule');
		?>
		</dd>
</div>
<div >
	<h2>Menu</h2>
	<li><?php echo $this->Html->link('Add new employee',array('controller' => 'Employees', 'action' => 'add_employee'));?></li>
	<li><?php echo $this->Html->link('View employee',array('action' => 'view'));?></li>
</div>
