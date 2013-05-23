<h2>History</h2>
				story</h2>
<div class="actions">
<?php
    echo $this->Form->create("History");
    echo $this->Form->input("emp_id", array('class'=>'input-medium search-query','label' => 'Search','type'=>'text'));
    echo $this->Form->end("Search");
?>
</div>
<div style="max-width:95%">
<table width=1063>
<tr>
  <th>ddID</th>
  <th>dEmployee Name</th>
  <th>Start Date</th>
  <th>dEnd Date</th>
  <th>Shift</th>
  <th>Action</th>
  <th>Date Created</th>
</tr></table>
<div>
<div style="max-width:95%;">
<div class="span3">
<table width=1063><?php
#debug ($res);
 foreach ($res as $e):  ?>
<tr>
<td><?php echo $e['Employee']['id']; ?></td>
<td><?php echo $e['Employee']['last_name'];
          echo ", " . $e['Employee']['first_name']; ?></td>
<td><?php echo $e['History']['start_date']?></td>
<td><?php echo $e['History']['end_date']?></td>
<td><?php echo $e['Shift']['time_shift']?></td>
<td><?php echo $e['Historytype']['name']?></td>
<td><?php echo $e['History']['create_time']?></td>
</tr>
<?php endforeach; ?>
<?php #echo $this->element('sql_dump');?>
</table>
</div></div>
<div class="actions">
				<?php
						echo $this->Form->create("History");
						echo $this->Form->input("emp_id", array('class'=>'input-medium search-query','label' => 'Search','type'=>'text'));
						echo $this->Form->end("Search");
				?>
				</div>
				<div style="max-width:95%">
				<table width=1063>
				<tr>
					<th>ddID</th>
					<th>dEmployee Name</th>
					<th>Start Date</th>
					<th>dEnd Date</th>
					<th>Shift</th>
					<th>Action</th>
					<th>Date Created</th>
				</tr></table>
				<div>
				<div style="max-width:95%;">
				<div class="span3">
				<table width=1063><?php
				#debug ($res);
				 foreach ($res as $e):  ?>
				<tr>
				<td><?php echo $e['Employee']['id']; ?></td>
				<td><?php echo $e['Employee']['last_name'];
									echo ", " . $e['Employee']['first_name']; ?></td>
				<td><?php echo $e['History']['start_date']?></td>
				<td><?php echo $e['History']['end_date']?></td>
				<td><?php echo $e['Shift']['time_shift']?></td>
				<td><?php echo $e['Historytype']['name']?></td>
				<td><?php echo $e['History']['create_time']?></td>
				</tr>
				<?php endforeach; ?>
<?php #echo $this->element('sql_dump');?>
</table>
</div></div>
