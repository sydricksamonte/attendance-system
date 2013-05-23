<?php  echo $this->Form->create('Schedule',array('action' => 'index'));
echo $this->Form->input('week_id', array('class' => 'input-small search-query', 'label' => 'Week', 'value' => $weekVal,'type' => 'select','options' => $weeks));
echo $this->Form->input('subgroup_id', array('class' => 'input-large search-query', 'label' => 'Group', 'value' => $subgroup,'type' => 'select'));
echo 'Week range: '. $weekRange;
echo $this->Form->end('Search',array('class'=>'btn btn-info'));
?> </br>
<div class="colorw">
<div class="btn btn-primary">
<?php echo $this->Html->link("Generate schedule for network engineers (w/ shifting schedule)", array('action' => 'generate','4')); ?>
</div>
<div class="btn btn-primary">
<?php echo $this->Html->link("Generate schedule for team leaders", array('action' => 'generate','3')); ?>
</div>
<div class="btn btn-primary">
<?php echo $this->Html->link("Create schedule for other groups", array('controller' => 'Groups', 'action' => 'index')); ?>
</div>

</div>
<br><br>
<table class="bordered">
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
    <?php foreach($empSched as $employee):?>
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
    <? endforeach;?>
  </table>
</div>

