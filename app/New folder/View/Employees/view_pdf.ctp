<?php 
  
#  ob_start();
  foreach($employees as $data){
    $name = $data['Employee']['first_name'].' '.$data['Employee']['last_name'];
    $id = $data['Employee']['id'];
    $tr  .= "<tr><td colspan=16><iframe frameborder=0 width=100% height=100 src=/cakephp/Employees/view_all2/$id>test</iframe> <td></tr>";
  }
?>
<table>
	<tr>
		<th width=200>Name</th>
		<th width=100>Monthly</th>
		<th width=100>Account Number</th>
		<th width=100>Half Month</th>
		<th width=100>Start Date</th>
		<th width=100>Day Rate</th>
		<th width=100>Hour Rate</th>
		<th width=100>Min Rate</th>
		<th width=100>Absent (Days)</th>
		<th width=100>Lates (Min)</th>
		<th width=100>Deduction</th>
		<th width=100>OT</th>
		<th width=100>Night Diff</th>
		<th width=100>Holiday</th>
		<th width=100>Net Pay</th>
  <?=$tr?>
</table>

<?php
#   $contents = ob_get_clean();

 #  var_dump($contents);
?>
