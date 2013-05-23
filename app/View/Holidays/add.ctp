<div class="span13">
	<h2>New Holiday</h2>
	<?php
	echo $this->Form->create('Holiday');
	echo $this->Form->input('name');
	echo $this->Form->input('authorize',array('value'=>'1', 'type' => 'hidden'));
	echo $this->Form->input('date',array('style'=>'width:110px'));
	echo $this->Form->input('regular', array('label'=>'Regular Holiday'));
	echo $this->Form->end('Save Holiday');
	?>
</div>
