<div class="span13">
	<h2>Edit Shift</h2>
	<?php
	echo $this->Form->create('Shift', array('action' => 'edit'));
	echo $this->Form->input('start_time',array('style'=>'width:90px;'));
	echo $this->Form->input('end_time',array('style'=>'width:90px;'));
	echo $this->Form->input('authorize',array('label' => 'Valid'));
	echo $this->Form->end('Save Shift');
	echo $this->Form->input('time_shift', array('type' => 'hidden'));
	?>
	<!--a href="javascript:window.history.back()">Back</a--> 
</div>
