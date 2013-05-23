<?debug($shift);?>
	<h2>Shift Schedules</h2>
<div class="sp1">  	
<table width=1180>
    	<thead>
				<tr>
      		<th width=632><font color="white">dd</font>Shift Period</th>
	      	<th width=216>Status</th>
					<th width=232></th>
  		  </tr>
			</thead></table>
</div><div class="sp1">
		<div class="span3">
			<table width=1180>
  		<?php foreach ($shift as $shift): ?>
    		<tr>
        	<tbody>
						<td width=632><?php echo $shift['Shift']['time_shift']; ?></td>
						<td width=216><?php if( $shift['Shift']['authorize'] == '1') {echo 'Valid';} else {echo 'Invalid';}?></td>
						<td width=232 class="actions">
       	    	<?php 
              echo $this->Html->link('Edit', array('action' => 'edit', $shift['Shift']['id']));?>
   	       	</td>
					</tbody>
   		 	</tr>
			<?php endforeach; ?>
		</table>
</div></div>
