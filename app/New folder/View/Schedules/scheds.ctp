<h1>Shifts</h1>
<table>
<tr>
<thead>
<th>Time in</th>
<th>Time out</th>
<th>Days</th>
<th>Resdays</th></thead><tbody>
<?php
$day="";
$rd="";
foreach ($sched as $sx):
				echo '</tr><tr>';
				$t_i=$sx['Schedule']['time_in'];
				$tin = date('h:i:s A', strtotime($t_i));
				echo '<td>'.$tin;
				$t_o=$sx['Schedule']['time_out'];
				$ton = date('h:i:s A', strtotime($t_o));
				echo '</td><td>'.$ton;
				$d=$sx['Schedule']['days'];

if ($d=='01-05'){
				$day='Mon-Fri';
				$rd='Sat-Sun';
				}
else if($d=='02-06'){
				$day='Tue-Sat';
				$rd='Sun-Mon';
}
else if($d=='03-07'){
				$day='Wed-Sun';
				$rd='Mon-Tue';
}
else if($d=='04-01'){
				$day='Thu-Mon';
				$rd='Tue-Wed';
}
else if($d=='05-02'){
				$day='Fri-Tue';
				$rd='Wed-Thu';
}
else if($d=='06-03'){
				$day='Sat-Wed';
				$rd='Thur-Fri';
}
else{
				$day='Sun-Tue';
				$rd='Wed-Thu';
}


echo '</td><td>'.$day;
echo '</td><td>'.$rd;
endforeach;
?>
</tbody>
</table>
