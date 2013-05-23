<?php

?>

<div class="index">
	<h2>Logsheet</h2>
	<table>
		<tr>
			<th>Employee ID</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Groups</th>
			<th>Actions</th>
		</tr>
		<?php foreach($employees as $employee): ?>
	  <tr>
      <td><?php echo $employee['Employee']['id']; ?></td>
      <td><?php echo $employee['Employee']['first_name']; ?></td>
      <td><?php echo $employee['Employee']['last_name']; ?></td>
      <td><?php echo $employee['Group']['name']; ?></td>
      <td class="actions">
        <?php echo $this->Html->link('Add',array('action' => 'add', $employee['Employee']['id']));?>
			</td>
    </tr>
	<? endforeach;?>
	</table>
</div>
<div>
	<h2>Menu</h2>
</div>
