 <h2>Employee list</h2>
<?php
	echo $this->Form->create('Loan',array('action' => 'emp_loan'));
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
			<th>Employment Status</th>
  		<th></th>  
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
                          echo $this->Html->link('No Group',array('class' => 'btn', 'controller'=>'Employees','action' => 'edit', $employee['Employee']['id'])).'</div></div>';
                      }else{
                          echo $employee['SubGroup']['name'];}
                       ?></td>
			<td width=153 style="vertical-align:middle"><?php if ($employee['Employee']['employed']=='1'){echo 'Employed';} else {echo  'Resigned';} ?></td> 
     <td style="vertical-align:middle"><div class="colorw"><div class="btn btn-info" style='height:15px;'>
        <?php echo $this->Html->link('Add Loan',array('action' => 'add_loan_loan', $employee['Employee']['id']));?></div>
     <td style="vertical-align:middle"><div class="colorw"><div class="btn btn-info" style='height:15px;'>
        <?php echo $this->Html->link('Edit Loan',array('action' => 'edit_emp_loan', $employee['Employee']['id']));?></div>
</td>
    </tr>
		</tbody>
    <? endforeach;?>
  </table>
</div>
