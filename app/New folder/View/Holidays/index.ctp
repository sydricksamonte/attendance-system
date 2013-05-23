<?php #debug($holi);?>
	<h2>Holidays</h2>
	<div class="actions">
		<?php
		echo $this->Form->create("Holiday", array('action'=>'search'));
		echo $this->Form->input("search",array('class'=>'input-medium search-query','label'=>'Search','type'=>'text'));
		echo $this->Form->end("Search");
		?>
	</div>
<div class="sp1">
		<table width=1080>
			<thead>
				<tr>
					<th width=63><font color="white">dd</font>ID</th>
					<th width=340><font color="white">dd</font>Name</th>
					<th width=321><font color="white">dd</font>Date</th>
					<th width=171><font color="white">dd</font>Status</th>	
					<th width=185></th>
				</tr></thead></table>
	<div class="span3">
			<table width=1080>
			<?php foreach ($holi as $h):?>
			<tbody>
				<tr>
					<td width=63><?php echo $h['Holiday']['id'];?></td>
					<?php #echo $this->Html->link($h['Holiday']['name'],array('action'=>'view',$h['Holiday']['id']));?>
					<td width=340><?php echo $h['Holiday']['name'];?></td>
					<td width=321><?php echo date('M d, Y',strtotime($h['Holiday']['date']));?></td>
				  <td width=171><?php  if  ($h['Holiday']['authorize'] == '1'){echo 'Valid';} else {echo 'Invalid';} ?></td>
					<td width=185><div class="colorw"><div class="btn btn-info" ><?php echo $this->Html->link('Edit',array('action'=>'edit',$h['Holiday']['id']));?></div></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table></div>
</div>
