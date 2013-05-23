<div class = "span13">
	<?php
	echo $this->Form->create('Employee');
/*	$sDate = ($employee['Schedules']['start_date']);
	$eDate = ($employee['Schedules']['end_date']);
	$shftId = ($employee['Schedules']['shift_id']);

	if ($shftId == null) {
		$shftId = 1;
	}

	$actId = ($employee['Schedules']['action_taken']);

	if ($actId == null){
		$actId = 1;
	}
*/	?>
<div align="right"><a href="javascript:window.history.back()"><--Back</a></div>
	<h2>Employee Profile</h2>
	<div class="span3">
		<table class="table table-bordered">
    	<tr>
				<td>Employee ID:</td>
	    	<td><?php echo $employee['Employee']['id'];?></td>
			</tr>
    	<tr>
				<td>First Name:</td>
	    	<td><?php echo $employee['Employee']['first_name'] ;?></td>
			</tr>
    	<tr>
				<td>Last Name:</td>
	    	<td><?php echo $employee['Employee']['last_name'] ;?></td>
			<tr>
    	<tr>
				<td>Group:</td>
	    	<td><?php echo $employee['SubGroup']['name'] ; ?></td>
			</tr>
			<tr>
				<td>Schedule:</td>
				<td><?php echo $this->Form->input('scheds',array('label' => false,'type' => 'select','options' =>$shifts )); ?></td>
			</tr>
				<td>Start date:</td>
		  	<td><?php  echo $this->Form->input('start',array('label' => false, 
																					'options' => $weekStart, 
																					'type' => 'select', 'value' => $weekNum )); ?></td>
			</tr>
    	<tr>
				<td>End date:</td>
		  	<td><?php  echo $this->Form->input('end',array('label' => false, 
																					'options' => $weekEnd, 
																					'type' => 'select', 'value' => $weekNum)); ?></td>
		  	<td style='display:none'><?php  echo $this->Form->input('end_date2',array('label' => false, 'value' => $sDate, 'type' => 'date')); ?></td>
			</tr>

			<?php

			#<!--hidden schedule fields-->
			echo $this->Form->input('', array('name' => 'change_by', 'value' => $_SESSION['Auth']['User']['User']['id'], 'type' => 'hidden'));
			echo $this->Form->input('', array('id' => 'Employee', 'name' => 'emp_id', 'value' => $employee['Employee']['id'], 'type' => 'hidden'));
			echo $this->Form->input('', array('name' => 'changed_time', 'value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));

			#<!--hidden history fields-->
			echo $this->Form->input('', array('id' => 'History', 'name' => 'create_time', 'value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));
			echo $this->Form->input('', array('id' => 'History', 'name' => 'emp_id', 'value' =>  $employee['Employee']['id'], 'type' => 'hidden'));
			echo $this->Form->input('', array('id' => 'History', 'name' => 'history_type_id', 'type' => 'hidden'));
			echo $this->Form->input('', array('id' => 'History', 'name' => 'create_by', 'value' => $_SESSION['Auth']['User']['User']['id'], 'type' => 'hidden'));
			echo $this->Form->input('', array('id' => 'History', 'index' => 0, 'value' => null, 'type' => 'hidden'));	
			echo $this->Form->input('', array('name' => 'change_time', 'value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));
			echo $this->Form->input('EmpSched.sched_id', array( 'type' => 'hidden', 'value' => '1'));

			?>
	
			</tr>
				<td><?php echo $this->Form->end('Add Schedule');?></td>
			</tr>
	</table>
</div>
</div>

