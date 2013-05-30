<h2>Update Logsheet</h2>
<?php 
echo $this->Form->create('Upload', array('type' => 'file'));
echo $this->Form->input('file', array('type' => 'file', 'label' => false));
echo $this->Form->end("Upload file");
?>