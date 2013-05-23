
<?php debug($lastCreated); 
	$searchby=array('ID', 'Last Name','First Name','Start Date','End Date','Shift','Action','Created By');
	echo "<dt>" . $this->Form->input("Search By:", array('type'=>'select','options'=>$searchby)) . "</dt>";
	echo "<dd>". $this->Form->input("Search Text") ."</dd>";

?>

<br><hr><br>
<table>
<tr>
	<th>ID</th>
  <th>Employee Name</th>
  <th>Start Date</th>
  <th>End Date</th>
  <th>Shift</th>
  <th>Action</th>
  <th>Created By</th>
</tr>
<?php foreach ($emp as $e):  ?>
<tr>
<td><?php echo $e['Employee']['id']; ?></td>
<td><?php echo $e['Employee']['last_name'];
			 		echo ", " . $e['Employee']['first_name']; ?></td>
</tr>
<?php endforeach; ?>
</table>
