 <h2>Employee list</h2>
<?php
	echo $this->Form->create('Employee',array('action' => 'filter'));
	echo $this->Form->input('emp_id', array('class' => 'input-medium search-query', 'label' => 'Search', 'type' => 'text'));
	echo $this->Form->end('Search');
?>


<div class="span3">
  <table>
    <thead>
		<tr>
      <th>ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Group</th>
			<th>Employed</th>
  		<th></th>  
	</tr>
		</thead>

		<tr></tr>
    <?php foreach($res as $employee):?>
    <tbody>
		<tr>
      <td style="vertical-align:middle"><?php echo $employee['Employee']['id']; ?></td>
			<td style="vertical-align:middle"><?php echo $employee['Employee']['last_name']; ?></td>
			<td style="vertical-align:middle"><?php echo $employee['Employee']['first_name']; ?></td>     
			      <td style="vertical-align:middle"><?php
                      if($employee['SubGroup']['name']==''){
                          echo '<div class="colorw"><div class="btn btn-danger" style="height:15px;">';
                          echo $this->Html->link('No Group',array('class' => 'btn', 'action' => 'edit', $employee['Employee']['id'])).'</div></div>';
                      }else{
                          echo $employee['SubGroup']['name'];}
                       ?></td>
			<td width=153 style="vertical-align:middle"><?php if ($employee['Employee']['employed']=='1'){echo 'Employed';} else {echo  'Resigned';} ?></td> 
     <td style="vertical-align:middle"><div class="colorw"><div class="btn btn-info" style='height:15px;'>
        <?php echo $this->Html->link('View',array('action' => 'view_emp', $employee['Employee']['id']));?></div>
       <div class="btn btn-info" style='height:15px;'>
        <?php echo $this->Html->link('Edit',array('class' => 'btn', 'action' => 'edit', $employee['Employee']['id']));?></div>
</td>
    </tr>
		</tbody>
    <? endforeach;?>
  </table>
</div>
