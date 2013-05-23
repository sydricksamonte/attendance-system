<?php
debug($employees);
?>
<div class='index'>
	<table>
		<tr>
			<td>Employee ID:</td>
			<td><?php echo $employees['Employee']['id'];?></td>
		</tr>
		<tr>
			<td>First Name:</td>
			<td><?php echo $employees['Employee']['first_name']; ?></td>
		</tr>
		<tr>
			<td>Last Name:</td>
			<td><?php echo $employees['Employee']['last_name']; ?></td>
		</tr>
		<tr>
			<td>Group:</td>
			<td><?php echo $employees['Group']['name']; ?></td>
		</tr>
		<tr>
			<td>Log-in:</td>
			<td></td>
		</tr>
		<tr>
			<td>Log-out:</td>
			<td></td>
		</tr>
		<tr>
			<td colspan=2><center><?php echo $this->Form->end('Add logs'); ?></center></td>
		</tr>
	</table>
</div>
