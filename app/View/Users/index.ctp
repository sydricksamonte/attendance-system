<h2>Users</h2>
<div class='actions'>
<?php
  echo $this->Form->create('User',array('action' => 'index'));
  echo $this->Form->input('search_id', array('class' => 'input-medium search-query', 'label' => 'Search', 'type' => 'text'));
  echo $this->Form->end('Search');
?>  
</div>
<div class="sp1">
		<p><?php #echo $this->Html->link("Add New User", array('action' => 'add')); ?></p>
	  <table width=1080>
  	  <tr>
    	  <th width=253><font color="white">dd</font>Name</th>
	      <th width=207><font color="white">dd</font>Last Name</th>
				<th width=254><font color="white">dd</font>Username</th>
				<th width=185><font color="white">dd</font>Authorized</th>
      	<th width=181></th>
	    </tr>
</table></div>
<div class="sp1">
<div class="span3"><table width=1080>
			<?php foreach ($filter as $user): ?>
	    <tr>
        <td width=253><?php echo $user['User']['first_name']; ?></td>
        <td width=207><?php echo $user['User']['last_name']; ?></td>
        <td width=254><?php echo $user['User']['username']; ?></td>
        <td width=185><?php if($user['User']['authorize'] == '1'){echo 'Valid';}else{echo 'Invalid';} ; ?></td>
				<td width=181><div class="colorw"><div class="btn btn-info"><?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id']));?></div></td>
	    </tr>
			<?php endforeach; ?>
		</table></div></div>
