<div class="colorw"><input type="button" value="Back" class="btn btn-warning" onclick="history.go(-1);" /></div>
<br>
<table border=1>
<tr><td>No.</td><td>Start Date</td><td>End Date</td></tr>
<?php
foreach ($coff as $cf):
	echo '
		<tr>
		<td>'.$cf['Cutoff']['id'].'</td>
		<td>'.date("M-d-Y",strtotime($cf['Cutoff']['start_date'])).'</td>
		<td>'.date("M-d-Y",strtotime($cf['Cutoff']['end_date'])).'</td>
		</tr>
	';
endforeach;
?>
	</table>
