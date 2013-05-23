<div class="span13">
<?php
# debug($varx);
#debug($emp); 
#	$searchby=array('ID', 'Last Name','First Name','Start Date','End Date','Shift','Action','Created By');
#echo $this->Form->create('Search');
#echo $this->Form->input('search', array('type'=>'select','options'=>$searchby));
#echo $this->Form->input('text');
#echo $this->FOrm->end('Search');?>
<h2>History</h2>
<div class="actions">
<?php  
    echo $this->Form->create("History",array('action' => 'search')); 
    echo $this->Form->input("emp_id", array('class'=>'input-medium search-query','label' => 'Search','type'=>'text'));
    echo $this->Form->end("Search"); 
?> 
</div>
<div style="max-width:95%">
<table width=1063>
<tr>
	<th width=32><font color="white">dd</font>ID</th>
  <th width=209><font color="white">d</font>Employee Name</th>
  <th width=105>Start Date</th>
  <th width=105><font color="white">d</font>End Date</th>
  <th width=180>Shift</th>
  <th width=200>Action</th>
	<th width=184>Date Created</th>
	<th width=48></th>
</tr></table>
</div>
<div style="max-width:95%">
<div class="span3">
<table width=1063>
<?php foreach ($emp as $e):  ?>
<tr>
<td width=32><?php echo $e['Employee']['id']; ?></td>
<td width=209><?php echo $e['Employee']['last_name'];
			 		echo ", " . $e['Employee']['first_name']; ?></td>
<td width=105><?php echo $e['History']['start_date']?></td>
<td width=105><?php echo $e['History']['end_date']?></td>
<td width=180><?php echo $e['Shift']['time_shift']?></td>
<td width=200><?php echo $e['Historytype']['name']?></td>
<td width=184><?php echo $e['History']['create_time']?></td>
<td width=48 class="actions"><?php echo $this->Html->link('View', array('controller' => 'Employees','action' => 'view_emp', $e['Employee']['id']));?>
          </td>
</tr>

<?php endforeach; ?>
</table>
</div>
</div>
