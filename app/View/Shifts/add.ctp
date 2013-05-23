<div class="span13">
	<h2>Shift Schedule</h2>
	<?php
	echo $this->Form->create('Shift');
	echo $this->Form->input('start_time',array('default'=>'09:00:00','style'=>'width:60px'));
	echo $this->Form->input('end_time',array('default'=>'18:00:00','style'=>'width:60px'));
 echo $this->Form->input('authorize',array('type'=>'hidden', 'value' => '1'));	
	echo $this->Form->end('Save Shift');
	echo $this->Form->input('time_shift', array('type' => 'hidden'));
	?>
	<!--<a href="javascript:window.history.back()">Back</a>-->
</div>
