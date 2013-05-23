<?php
#debug($sched);
?>
<div align="right"><a href="javascript:window.history.back()"><--Back</a></div>
<div class="sp1">
	<h2>Modify Schedule</h2>
<table>
	<tr>
		<td>Employee ID:</td>
		<td><?php echo $sched['Employee']['id']; ?></td>
	</tr>
	<tr>
		<td>First Name:</td>
		<td><?php echo $sched['Employee']['first_name']; ?></td>
	</tr>
	<tr>
		<td>Last Name:</td>
		<td><?php echo $sched['Employee']['last_name']; ?></td>
	</tr>
	<tr>
		<td>Group:</td>
		<td><?php echo $sched['Group']['name']; ?></td>
	</tr>
</table>
<br>
<h2>Schedule</h2>
<div class="span3">
<table width=1080>
	<tr>
		<th width=209>Start Date</th>
		<th width=209>End Date</th>
		<th width=330>Shift Schedule</th>
		<th width=211>Type of Shift</th>
		<th width=121>Actions</th>
	</tr></table>
<?php
if ($histories[0]['Schedule']['start_date'] != null){
	foreach($histories as $history):
?>
	<table class="1080"><tr>
		<td width=209><? echo date('M d, Y',strtotime($history['Schedule']['start_date'])); ?></td>
		<td width=209><? echo date('M d, Y',strtotime($history['Schedule']['end_date'])); ?></td>
		<td width=330><? echo $history['Shifts']['time_shift']; ?></td>
		<td width=211><? echo $history['Historytype']['name']; ?></td>
		<td width=121 class='actions'>
        <?php echo $this->Html->link('Edit',array('action' => 'edit_selected_sched', $sched['Employee']['id'], $history['Schedule']['id']));?>
		</td>
	</tr>
<?
	endforeach;
} else {
	echo "<tr><td>No schedule</td><td></td><td></td><td></td><td></td></tr>";
}
?>
</table>
</div></div>
