<div class="span13">
<h1>Change subgroup shift</h1>
<?php 
    echo $this->Form->create('SubGroup', array( 'onsubmit' => 'return confirm("Continuing will override affected schedule(s). Are you sure you want to continue?");')); ?>
  <table class="table table-bordered">
    <tr>
      <td>Subgroup ID:</td>
      <td><?php echo $subgroup['SubGroup']['id'];?></td>
    </tr>
    <tr>
      <td>Name:</td>
      <td><?php echo $subgroup['SubGroup']['name'] ;?></td>
    </tr>
    <tr>
      <td>Group:</td>
      <td><?php echo $subgroup['SubGroup']['group_id'] ;?></td>
    </tr>
    <tr>
      <td>Shift:</td>
		<td><?php  echo $this->Form->input('start',array('label' => 'From: ', 'type' => 'select' ,'options' => $weekStart, 'value' => $weekNum));	?>
				 <?php  echo $this->Form->input('end',array('label' => 'To: ', 'type' => 'select' ,'options' => $weekEnd, 'value' => $weekNum)); ?></td>
      <td><?php  echo $this->Form->input('scheds',array('label' => 'New Schedule: ', 'type' => 'select', 'options' => $shifts , 'value' => $shifts,)); ?></td>
			</tr>
		<tr>
	</tr>
</div>
<?php
echo $this->Form->input('Employee.subgroup_id', array( 'value' => $subgroup['SubGroup']['id'], 'type' => 'hidden'));
?>
<td><?php echo $this->Form->end('Save', array('controller' => 'Groups', 'action' => 'edit') );?></td>
