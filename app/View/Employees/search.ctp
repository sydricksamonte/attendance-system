<table>
<tr>
	<th>Actions</th>
  <th>Employee Name</th>
  <th>Schedule</th>
  <th>Shift</th>
  <th>Start Date</th>
  <th>End Date</th>
  <th>Start Time</th>
  <th>End Time</th>
  <th>Create Time</th>
  <th>Created By</th>
</tr>
<?php foreach ($history as $his):  ?>
<tr>
<td><?php echo $his['Histor']['history_type_id']; ?></td>
<td><?php echo $his['Histor']['emp_id']; ?></td>
<td><?php echo $his['Histor']['sched_id']; ?></td>
<td><?php echo $his['Histor']['shift_id']; ?></td>
<td><?php echo $his['Histor']['start_date']; ?></td>
<td><?php echo $his['Histor']['end_date']; ?></td>
<td><?php echo $his['Histor']['start_time']; ?></td>
<td><?php echo $his['Histor']['end_time']; ?></td>
<td><?php echo $his['Histor']['create_time']; ?></td>
<td><?php echo $his['Histor']['created_by']; ?></td>
</tr>
<?php endforeach; ?>
</table>
