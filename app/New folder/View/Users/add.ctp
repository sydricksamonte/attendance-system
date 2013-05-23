
<h2>New User</h2>
<div class="span13">
<?php
echo $this->Form->create('User');
echo $this->Form->input('first_name');
echo $this->Form->input('last_name');
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('authorize',array('type'=>'hidden', 'value' => '1'));
echo $this->Form->end('Add User');
?>
</div>
