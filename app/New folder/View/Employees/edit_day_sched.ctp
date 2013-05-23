<div class="span13">
<div align="right">
<a href="javascript:window.history.back()"><--Back</a>
</div>
<? echo $this->Form->create('Employee') ?>
  <h2>Modify date information</h2>
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
		</tr>
	    <tr>
      <td>Date:</td>
      <td><?php  echo $curr_date_ymd;?> </td>
    </tr>
	 <tr>
      <td>Actions:</td>
      <td><?php echo $this->Form->input('Scheduleoverride.scheduleoverride_type_id',array('type' => 'select', 'options' => $actions)); ?>
 </td>  </tr>
   <tr>
			<td>Shift:</td>
    	<td><?php echo $this->Form->input('Scheduleoverride.time_in',array('label' => 'From:','type' => 'time','selected' =>$defaultTimeIn));?>
			<?php echo $this->Form->input('Scheduleoverride.time_out',array('label' => 'From:','type' => 'time','selected' => $defaultTimeOut));?>
</td>
		</tr>

<!--hidden schedule fields-->
<?php
echo $this->Form->input('Scheduleoverride.start_date', array('value' => $curr_date_ymd, 'type' => 'hidden'));
echo $this->Form->input('Scheduleoverride.end_date', array('value' => $curr_date_ymd, 'type' => 'hidden'));
echo $this->Form->input('Scheduleoverride.change_by', array('value' => $_SESSION['Auth']['User']['User']['id'], 'type' => 'hidden'));
echo $this->Form->input('Scheduleoverride.emp_id', array('value' => $employee['Employee']['id'], 'type' => 'hidden'));
echo $this->Form->input('Scheduleoverride.change_time', array('value' => date("Y-m-d H:i:s"), 'type' => 'hidden'));
echo $this->Form->input('Scheduleoverride.id', array('value' => $schedTime, 'type' => 'hidden'));

?>

	</tr>
</table>
		<?php echo $this->Form->end('Change schedule' );?>
</div>
