<?php
function formatAmount($amount)
{
return number_format($amount, 2, '.', ',');
}
foreach ($empret as $empS):
?>
Employees PAYSLIP
<br>
<?php
echo 'From: '.$empS['Cutoff']['start_date'].'<br>To: '.$empS['Cutoff']['end_date'];
?>
<div align="right">
</div>
<table>
<tr><td>
	<table border=1>
<tr>
	<td>Name</td>
	<td><?php echo $empS['Employee']['last_name'].', '.$empS['Employee']['first_name']?></td>
</tr>
<tr>
	<td>Position</td>
	<td><?php echo $empS['Group']['name']?></td>
</tr>
<tr>
	<td>Tax Code</td>
	<td><?php echo $empS['Govstat']['name']?></td>
</tr>
<tr>
	<td colspan=2><center> Salary Details</td>
</tr>
<tr>
	<td>Basic Salary</td><td><?php $basics= Security::cipher($empS['Employee']['monthly'], 'my_key'); echo formatAmount($basics/2)?></td>
</tr>
<tr>
	<td>Night Differential</td><td><?php echo formatAmount($empS['Total']['night_diff']);?></td>
</tr>
<tr>
	<td>Over Time</td><td><?php echo formatAmount($empS['Total']['OT'])?></td>
</tr>
<tr>
	<td>Attendance Bonus</td><td><?php echo formatAmount($empS['Total']['att_bonus'])?></td>
</tr>
<tr>
	<td>Holiday Pay</td><td><?php echo  formatAmount($empS['Total']['holiday'])?></td>
</tr>
	</table>
</td><td>
	<table border=1>
<tr>
	<td>Deduction</td><td><?php echo  formatAmount($empS['Total']['deductions'])?></td>
</tr>
<tr>
	<td>Absences / Tardiness</td><td><?php
$tard1= $empS['Total']['absents'];
$tard2= $empS['Total']['lates'];
echo  formatAmount($tard1 + $tard2);
?></td>
</tr>
<tr>
	<td>Company Advances</td><td><?php echo  formatAmount($empS['Total']['att_bonus'])?></td>
</tr>
<tr>
	<td>SSS</td><td><?php echo  formatAmount($empS['Total']['sss'])?></td>
</tr>
<tr>
	<td>PhilHealth</td><td><?php echo  formatAmount($empS['Total']['phil_health'])?></td>
</tr>
<tr>
	<td>Home Mutual Dev't Fund</td><td><?php echo  formatAmount($empS['Total']['pagibig'])?></td>
</tr>
<tr>
	<td>Witholding Tax</td><td><?php echo  formatAmount($empS['Total']['tax'])?></td>
</tr>
<tr>
	<td>SSS Loan</td><td>0</td>
</tr>
<tr>
  <td>HMDF (Pagibig) Loan</td><td>0</td>
</tr>
<tr>
  <td>Retro Pay</td><td><?php
$retropay=$empS['Retro']['retropay'];
 $retropay=$retropay-($retropay * .10);
 echo formatAmount($retropay)?></td>
</tr>
</table>
</td></tr>
<tr>
<td></td><td><u>Net Pay: <?php echo formatAmount((Security::cipher($empS['Total']['net_pay'], 'my_key'))+($retropay))?><td>
</tr>
</table>
</center><?php endforeach;?>
