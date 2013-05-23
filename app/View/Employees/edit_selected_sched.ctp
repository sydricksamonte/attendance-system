
<div class = "span13">
<?php
#debug($cond);
echo $this->Form->create('Employee');
$sDate = ($employee['Schedules']['start_date']);
$eDate = ($employee['Schedules']['end_date']);
$shftId = ($employee['Schedules']['shift_id']);

if ($shftId == null) {
	$shftId = '1';
}

$actId = ($employee['Schedules']['action_taken']);

if ($actId == null){
	$actId = '1';
}

?>

  <h2>Modify Schedule</h2>
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
    	<td><?php echo $employee['Group']['name'] ; ?></td>
		</tr>
    <tr>
			<td>Shift:</td>
    	<td><?php echo $this->Form->input('',array('name' => 'shift_id','type' => 'select', 'options' => $shifts, 'value' => $shftId)); ?></td>
		</tr>
    <tr>
      <td>Start date:</td>
      <td><?php  echo $this->Form->input('start_date',array( 'label' => false, 'type' => 'date', 'value' => $sDate)); ?></td>
    </tr>
    <tr>
      <td>End date:</td>
<?php list($year,$month,$day)=explode("-",$eDate); ?>

      <td><?php  echo $this->Form->input('end_date',array('label' => false, 'type' => 'date', 'value' => $eDate)); ?></td>
      <td style='display:none'><?php  echo $this->Form->input('end_date2',array('label' => false, 'value' => $sDate, 'type' => 'date')); ?></td>
    </tr>

		<tr>
			<td></td>
    	<td><?php echo $this->Form->input('',array('name' => 'action_taken','type' => 'select', 'options' => $actions, 'value' => $actId,'type' => 'hidden')); ?></td>
		</tr>

<!--hidden schedule fields-->
<?php
echo $this->Form->input('', array('name' => 'change_by', 'value' => $_SESSION['Auth']['User']['User']['id'], 'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'Employee', 'name' => 'emp_id', 'value' => $employee['Employee']['id'], 'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'Schedule',  'name' => 'id', 'value' => $employee['Schedules']['id'], 'type' => 'hidden'));
echo $this->Form->input('', array('name' => 'changed_time', 'value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));
?>

<!--hidden history fields-->
<?php
echo $this->Form->input('', array('id' => 'History', 'name' => 'create_time', 'value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'History', 'name' => 'emp_id', 'value' =>  $employee['Employee']['id'], 'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'History', 'name' => 'history_type_id', 'value' => $actId,'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'History', 'name' => 'create_by', 'value' => $_SESSION['Auth']['User']['User']['id'], 'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'History', 'index' => 0, 'value' => null, 'type' => 'hidden'));
echo $this->Form->input('', array('name' => 'change_time', 'value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));
echo $this->Form->input('', array('id' => 'Schedule', 'name' => 'sched_id', 'value' => $employee['Schedules']['id'], 'type' => 'hidden'));
?>

<!--hidden scheduleoverride fields-->
<?php #echo $this->Form->input('', array('id' => 'Scheduleoverride', 'name' => 'Scheduleoverride.id', 'value' => $this->data['Scheduleoverride']['id'], 'type' => 'hidden'));?>

		</table>
			<?php echo $this->Form->end('Change schedule');?>
</div>
