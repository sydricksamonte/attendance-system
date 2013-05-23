<div class="index">
<h2>Restdays</h2>
<div class="span3">
 <table  class="table table-striped">
  <thead>
  <tr>
      <th>ID</th>
      <th>Restday</th>
      <th>Assigned to</th>
	    <th>Actions</th>
    </tr>
  </thead>
  <?php foreach ($restdays as $restday): ?>
  <tbody>
    <tr>
        <td><?php echo $restday['Restday']['id']; ?></td>
         <td><?php echo $restday['Restday']['date']; ?></td>
				<td><?php echo $restday['Restday']['date']; ?></td>
         <td class="actions">
               <?php echo $this->Html->link('Edit', array('action' => 'edit', $restday['Restday']['id']));?>
 <?php echo $this->Html->link('Delete', array('action' => 'delete', $restday['Restday']['id']));?>

          </td>
   </tbody>
    </tr>
<?php endforeach; ?>
  </table>
</div>

