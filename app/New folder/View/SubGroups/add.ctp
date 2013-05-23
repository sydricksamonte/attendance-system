<div class="span13">
<h1>SubGroup</h1>
<?php
    echo $this->Form->create('SubGroup', array('action' => 'edit'));
    echo $this->Form->input('name');
    echo $this->Form->input('authorize', array('value' => '1', 'type' => 'hidden'));
		echo $this->Form->input('group_id', array('value' => $group_id, 'type' => 'hidden'));   
		echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Add', array('action' => 'edit'));
?>
</div>

