<style type="text/css">
table {width:100%;}
thead { background-color:#000268;color:#FFFFFF;text-align:center; position:fixed; top:0px; }
thead th { height:50px;}
tbody {background-color:#cccccc;color:#000000;text-align:center; overflow: scroll; margin:0px; }
tbody td {height:30px;}
tfoot {background-color:#000268; color:#FFFFFF;text-align:center; position:fixed; bottom:0px;}
tfoot td { height:50px; width:120px;}
p{width:60px; word-wrap:break-word;}
</style>
    <p><?php #echo $this->Html->link("Add New User", array('action' => 'add'));
function formatAmount($amount)
{
return number_format($amount, 2, '.', '');
}

 ?></p>
    <table>
     <thead> <tr>
				<th width=350>Name</th>
				<th width=120>Monthly</th>
				<th width=190>AUB<br>Account</th>
				<th width=180>Half Month</th>
				<th width=180>Day Rate</th>
				<th width=180>Hour Rate</th>
				<th width=180>Min Rate</th>
				<th width=100>Absent (Days)</th>
				<th width=80>Lates (Min)</th>
				<th width=100>Deduction</th>
				<th width=80>Attendance Bonus</th>
				<th width=80>SSS</th>
				<th width=100>Philhealth</th>
				<th width=100>Pagibig</th>
				<th width=100>Withholding tax</th>
				<th width=100>OT</th>
				<th width=100>Night Diff</th>
				<th width=100>Holiday</th>
				<th width=100>SSS Loan</th>
				<th width=100>HMDF Loan</th>
				<th width=280>Net Pay</th>
      </tr></thead>
      <tbody><tr></tr><tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>
      <?php foreach ($total as $t): ?>
<tr>

<?php if ($t['Total']['error'] > 0){ $bg = "style='background-color:rgb(255, 153, 153);'";}else { $bg = ''; } ?>
				<?php $decBasic = Security::cipher($t['Total']['monthly'], 'my_key');?>

 <?php echo "<td $bg width=300>". $this->Html->link( $t['Emp']['last_name'].', '.$t['Emp']['first_name'], array('controller'=>'Employees','action' => 'view_emp', $t['Total']['emp_id']))."</td>" ?>
        <?php echo "<td $bg width=120>". formatAmount($decBasic)."</td>" ?>
        <?php echo "<td $bg width=100>". $t['Total']['account_number'] ."</td>" ?>

<?php echo "<td $bg width=150>". formatAmount($decBasic / 2)."</td>" ?>
        <?php echo "<td $bg width=150>". formatAmount($decBasic / 22)."</td>" ?>
        <?php echo "<td $bg width=150>". formatAmount(($decBasic / 22) / 8)."</td>" ?>
        <?php echo "<td $bg width=150>". formatAmount((($decBasic / 22) / 8) / 60)."</td>" ?>
				
<?php echo "<td $bg width=100>". $t['Total']['absents']."</td>" ?>
				<?php echo "<td $bg width=100>". $t['Total']['lates']."</td>" ?>
        <?php echo "<td $bg width=100>".  formatAmount($t['Total']['deductions'])."</td>" ?>

				<?php echo "<td $bg width=100>". formatAmount($t['Total']['att_bonus'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['sss'])."</td>" ?>

				<?php echo "<td $bg width=100>".  formatAmount($t['Total']['phil_health'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['pagibig'])."</td>" ?>

				<?php echo "<td $bg width=100>". formatAmount($t['Total']['tax'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['OT'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['night_diff'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['holiday'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['sss_loan'])."</td>" ?>
				<?php echo "<td $bg width=100>". formatAmount($t['Total']['hmdf_loan'])."</td>" ?>
				<?php echo "<td $bg width=200>". formatAmount($t['Total']['net_pay'])."</td>" ?>
				</tr>
      <?php endforeach; ?>
    </tbody></table></div>

