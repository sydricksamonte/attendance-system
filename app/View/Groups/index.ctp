<h2>Group List</h2> 
<div class='actions'>
<?php
  echo $this->Form->create('Group',array('action' => 'index'));
  echo $this->Form->input('search_id', array('class' => 'input-medium search-query', 'label' => 'Search', 'type' => 'text'));
  echo $this->Form->end('Search');
?>    
</div>
<div class="sp1">
 <table width=1080 class="table table-striped">
	<thead>    
	<tr>
      <th style="text-align:center" width=153>Group ID</th>
      <th width=540>Group Name</th>
		  <th width=147>Valid</th>
			<th width=240></th>
    </tr>
	</thead>
	<?php foreach ($filter as $group): ?>
	<tbody>
    <tr>
        <td style="text-align:center"><?php echo $group['Group']['id']; ?></td>
         <td><?php echo $group['Group']['name']; ?></td>
        <td><?php if ($group['Group']['authorize']=='1'){echo 'Yes';} else {echo 'No';}; ?></td>
					 <td><div class="colorw"><div class="btn btn-info">
						   <?php echo $this->Html->link('Edit', array('action' => 'edit', $group['Group']['id']));?></div>
					</td>
   </tbody>  
    </tr>
<?php endforeach; ?>
	</table></div></div>
