<?php 
?>
<br> <?php echo 'Table generated for the Week(s) of: '. $toGenWeek .'<br>';?> </br>
<div class="colorw" >
<div class="btn btn-primary" style='width:70px'>
<?php echo $this->Html->link("Reshuffle", array('action' => 'generate', $netType)); ?>
</div>
<div class="btn btn-primary" style='width:40px'><?php echo $this->Html->link("Save", array('action' => 'save')); ?></div>
<div><table class="table-bordered"><thead><tr><th>
<?php if ($unable != null) { echo 'Unable to generate schedule(s) for: '; ?> </th></tr></thead><br><tbody><tr><td>
<?php foreach ($names as $u): 
			 ?><?php {	echo $u;  ?><br><?php }
		endforeach;}
 ?>
</td></tr></tbody></table></div></div><br>
<table class="table-bordered">
  <thead>
    <tr>
      <th>Employee</th>
      <th>Mon</th>
      <th>Tue</th>
      <th>Wed</th>
      <th>Thu</th>
      <th>Fri</th>
      <th>Sat</th>
      <th>Sun</th>
    </tr>
  </thead>
<div>
    <?php foreach($tempSched as $employee):?>
    <?php $arrDays = $this->requestAction('Schedules/getWorkDayNames/'.$employee['Schedule']['days']);?>
    <?php $timeSchedIn =date('h:i a',strtotime($employee['Schedule']['time_in']));
          $timeSchedOut =date('h:i a',strtotime($employee['Schedule']['time_out']));?>
   <tbody>
    <tr>
     <td><?php echo $this->Html->link($employee['Employee']['last_name'].', '. $employee['Employee']['first_name'], array('controller'=>'Employees','action' => 'view_emp', $employee['Employee']['id']));?></td>
     <td><?php if (in_array("Monday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
     <td><?php if (in_array("Tuesday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
     <td><?php if (in_array("Wednesday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
     <td><?php if (in_array("Thursday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
     <td><?php if (in_array("Friday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
     <td><?php if (in_array("Saturday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
     <td><?php if (in_array("Sunday", $arrDays)){ echo $timeSchedIn.'-'.$timeSchedOut; }?> </td>
    </tr>
    </tbody>
    <?php endforeach;?>
  </table>
</div>
<?php
?>
<td><?php #echo $this->Form->end('Save', array('controller' => 'Groups', 'action' => 'edit') );?></td>

