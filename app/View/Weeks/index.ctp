<div class="colorw"><input type="button" value="Back" class="btn btn-warning" onclick="history.go(-1);" /></div>
<br>
<table border=1>
<tr><td>Week NO.</td><td>Monday</td><td>Tuesday</td><td>Wednesday</td><td>Thursday</td><td>Friday</td><td>Saturday</td><td>Sunday</td></tr>
<?php
foreach ($wks as $wk):
echo '<tr>
  <td>'.$wk['Week']['week_no'].'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['monday'])).'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['tuesday'])).'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['wednesday'])).'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['thursday'])).'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['friday'])).'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['saturday'])).'</td>
	<td>'.date("M.d, Y", strtotime($wk['Week']['sunday'])).'</td>
</tr>';
endforeach;
?>
</table>
