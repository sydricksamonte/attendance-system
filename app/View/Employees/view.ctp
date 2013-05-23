<?php
//	debug($employees);
?>

	<h2>Employee list</h2>
	<table>
		<tr>
			<th>Employee ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Group</th>
			<th class="actions"></th>
		</tr>
		<?php foreach($employees as $employee):?>
		<tr>
			<td><?php echo $employee['Employee']['id']; ?></td>
      <td><?php echo $employee['Employee']['first_name']; ?></td>
      <td><?php echo $employee['Employee']['last_name']; ?></td>
      <td><?php echo $employee['Employee']['group_id']; ?></td>
			<td class="actions">
			  <?php echo $this->Html->link('View',array('action' => 'view_emp', $employee['Employee']['id']));?>
				<?php echo $this->Html->link('Edit',array('action' => 'edit', $employee['Employee']['id']));?>
			</td>
		</tr>
		<? endforeach;?>
	</table>

