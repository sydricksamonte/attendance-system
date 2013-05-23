<?php echo $this->Html->link(__('PDF'), array('action' => 'view_pdf', 'ext' => 'pdf', $empS['Retro']['id'])); ?>

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
	<td>Basic Salary</td><td><?php echo Security::cipher($empS['Employee']['monthly'], 'my_key');?></td>
</tr>
<tr>
	<td>Night Differential</td><td><?php echo $empS['Total']['night_diff']?></td>
</tr>
<tr>
	<td>Over Time</td><td><?php echo $empS['Total']['OT']?></td>
</tr>
<tr>
	<td>Attendance Bonus</td><td>0</td>
</tr>
<tr>
	<td>Holiday Pay</td><td><?php echo $empS['Total']['holiday']?></td>
</tr>
</table>
</td><td>
<table border=1>
<tr>
	<td>Deduction</td><td><?php echo $empS['Total']['deductions']?></td>
</tr>
<tr>
	<td>Absences / Tardiness</td><td><?php
$tard1= $empS['Total']['absents'];
$tard2= $empS['Total']['lates'];
echo $tard1 + $tard2;
?></td>
</tr>
<tr>
	<td>Company Advances</td><td><?php echo $empS['Total']['att_bonus']?></td>
</tr>
<tr>
	<td>SSS</td><td><?php $empS['Total']['sss']?></td>
</tr>
<tr>
	<td>PhilHealth</td><td><?php $empS['Total']['phil_health']?></td>
</tr>
<tr>
	<td>Home Mutual Dev't Fund</td><td><?php $empS['Total']['pagibig']?></td>
</tr>
<tr>
	<td>Witholding Tax</td><td><?php $empS['Total']['tax']?></td>
</tr>
<tr>
	<td>SSS Loan</td><td>0</td>
</tr>
<tr>
	<td>HMDF (Pagibig) Load</td><td>0</td>
</tr>
<tr>
  <td>Retro Pay</td><td><?php echo $retroPay['Retro']['retropay']?></td>
</tr>
</table>
</td></tr>
<tr>
<td></td><td>Net Pay: <?php echo (($total['Total']['net_pay'])+($retroPay['Retro']['retropay']))?><td>
</tr>
</table>
</center>
