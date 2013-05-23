<div class="span13">
<h1>Group</h1>
<?php
    echo $this->Form->create('Group', array('action' => 'edit'));
    echo $this->Form->input('name');
		 echo $this->Form->input('authorize', array('label' => 'Valid'));
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save Group');
?>
<h2>Subgroup(s)</h2>
<div class="colorw">
<div class="btn btn-info">

<?php echo $this->Html->link('Add Subgroup', array('controller' => 'SubGroups', 'action' => 'add', $id));?>
</div>
 <table width=1080 class="table table-striped">
  <thead>
  <tr>
      <th width=153>Subgroup ID</th>
      <th width=540>Name</th>
      <th width=147>Valid</th>
      <th width=240></th>
    </tr>
  </thead>


  <?php foreach ($subGroup as $group): ?>
  <tbody> 
 <tr>
        <td><?php echo $group['SubGroup']['id']; ?></td>
         <td><?php echo $group['SubGroup']['name']; ?></td>
        <td><?php if ($group['SubGroup']['authorize']=='1'){echo 'Yes';} else {echo 'No';}; ?></td>
				<td>
						<div class="btn btn-info">
           <?php echo $this->Html->link('View', array('controller' => 'SubGroups', 'action' => 'view', $group['SubGroup']['id']));?></div>
						<div class="btn btn-info">
    			 <?php echo $this->Html->link('Edit', array('controller' => 'SubGroups', 'action' => 'edit', $group['SubGroup']['id']));?></div>
							 <?php if ( $group['SubGroup']['id'] != '3' and $group['SubGroup']['id'] != '4' )  {echo '<div class="btn btn-info">'.$this->Html->link('Change shift', array('controller' => 'SubGroups', 'action' => 'change_sched', $group['SubGroup']['id']));}?></div>
          </td>
    </tr>
   </tbody>
<?php endforeach; ?>
  </table></div></div>
<!--a href="javascript:window.history.back()">Back</a-->
