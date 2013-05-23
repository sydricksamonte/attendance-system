<div class="span13">
<?php //debug($groups);
 ?>
  <h2>Save schedule</h2>
<?php
  echo $this->Form->create('EmpSched', array( 'onsubmit' => 'return confirm("Are you sure you want to continue? Changes cannot be undone once processed.");'));
  echo $this->Form->input('id');
  echo $this->Form->input('week_use',array('label'=>'Week(s) covered by this schedule: ','type' => 'select','selected' => 3, 'options' => array(1,2,3,4,5)));
  echo $this->Form->end('Save');
?>
</div>

