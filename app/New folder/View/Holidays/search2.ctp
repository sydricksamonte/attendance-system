<?php #debug($holid); debug($holi)?>
<div class="span13">
	<h2>Holidays</h2>
	<div class="actions">
		<?php
		echo $this->Form->create("Holiday", array('action'=>'search'));
		echo $this->Form->input("search",array('class'=>'input-medium search-query','label'=>'Search','type'=>'text'));
		echo $this->Form->end("Search");
		?>
	</div>

  <div class='span3' style="height:550px">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Date</th>
					<th></th>
				</tr>
			</thead>
			<?php foreach ($holi as $h):?>
			<tbody>
				<tr>
					<td><?php echo $h['Holiday']['id'];?></td>
					<td><?php echo $h['Holiday']['name'];?></td>
					<td><?php echo date('M d, Y',strtotime($h['Holiday']['date']));?></td>
					<td class="actions"><?php echo $this->Html->link('Edit',array('action'=>'edit',$h['Holiday']['id']));?></td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
	</div>
</div>
