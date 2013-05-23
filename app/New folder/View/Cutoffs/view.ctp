<div class="span13">
<?php //debug($groups);
 ?>
  <h2>Generate Cutoff</h2>
<?php
  echo $this->Form->create('CutOff', array( 'onsubmit' => 'alert("Generating... Press OK");'));
  echo $this->Form->input('cut_use',array('label'=>'Cut off end date','type' => 'select','selected' => 0, 'options' => $total));
?>
<?php echo $this->Form->end('Generate'); ?>
</div>

