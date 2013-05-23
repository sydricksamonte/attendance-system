<?php #debug($holi);?>
<div class="span13">
<h2>Holidays</h2>
		<table>	<tr>
				<td>ID:</td>
				<td><?php echo $holiday['Holiday']['id'];?></td>
			</tr><tr>	<td>Name:</td>
				<td><?php echo $holiday['Holiday']['name'];?></td>
			</tr><tr>	<td>Date:</td>
				<td><?php echo date('M d, Y',strtotime($holiday['Holiday']['date']));?></td>
			</tr> </table>
</div>
