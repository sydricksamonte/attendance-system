<h1>Edit Group</h1>
<?php
    echo $this->Form->create('Restday', array('action' => 'edit'));
    echo $this->Form->input('date');
    echo $this->Form->input('id', array('type' => 'hidden'));
    echo $this->Form->end('Save Post');
?>
<a href="javascript:window.history.back()">Back</a>

