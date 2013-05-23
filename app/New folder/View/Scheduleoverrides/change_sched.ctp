<?php debug($empname)?>
<div class="schedule form">
<h2>Change Schedule</h2>
<dl>
<dt>Employee Name:</dt>
<dd><?php echo  $this->Form->input('',array('type' => 'select', 'options' => $empname)); ?></dd>
<dt>Schedule:</dt>
</dl>
</div>
