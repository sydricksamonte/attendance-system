f<?php
$yesLeave=0;
$ssLoan=0;
$hmdfLoan=0;
$userid=$employee['Employee']['id'];
$dayin=0;
$ot = 0;
$empAuth = $employee['Employee']['employed'];
$sDate = ($employee['Schedule']['time_in']);
$eDate = ($employee['Schedule']['time_out']);
$late_total = 0;
$under_total = 0;
$absent_total = 0;
$nopay_total = 0;
$attbonus=0;
$ot_total =0;
$ot_amount = 0; $ot1_amount = 0; $ot2_amount = 0; $ot3_amount = 0; $ot4_amount = 0; $ot5_amount = 0;
$nd_amount = 0; $nd1_amount = 0; $nd2_amount = 0; $nd3_amount = 0; $nd4_amount = 0; $nd5_amount = 0;
$hd1_amount = 0; $hd2_amount = 0; $hd3_amount = 0; $hd4_amount = 0;
$late_amount = 0;
$under_amount = 0;
$absent_amount = 0;
$nopay_amount = 0;
$half_day_amount = 0;
$gov_mandated = 0;
$otamount = 0; $ndamount = 0; $hdamount = 0;
$dayCutOff = date('d');
if (($dayCutOff >= '1') && ($dayCutOff <= '15'))
{
				$dayCutVal  = 0;
				$monthStart = date('m', strtotime("-1 month"));
}
else {
				$dayCutVal = 1;
				$monthStart = date('m');	
}
?>
<div align="right">
<a href="javascript:window.history.back()"><--Back</a>
</div>
<div class="sp1">
<h2>Employee Profile</h2>
<table class='table table-striped'>
<tr>
<td>Employee ID:</td>
<td><?php echo $employee['Employee']['id']; ?></td>
</tr>
<tr>
<td>Name:</td>
<td><?php echo $employee['Employee']['last_name'].', '.$employee['Employee']['first_name']; ?></td>
</tr>
<tr>
<td>Group:</td>
<td><?php echo $employee['SubGroup']['name']; ?></td>
</tr>
<tr>

<tr>
<td>Status:</td>
<td><?php if ($empAuth == 1){echo 'Employed';} else {echo 'Resigned';}?></td>
</tr>
<tr>
<td><?php if ($empAuth == 1){ echo 'Shift Schedule';}?></td>
<td class='colow'><?php if ($empAuth == 1){ echo '<div class="colorw"><div class="btn btn-primary" style="width:170px">'.$this->Html->link('Add / Modify Schedule',array('action' => 'change_sched', $employee['Employee']['id']))."</div></div>";} ?></td>
</tr>
<tr>
<td><?php if($empAuth == 1){echo 'Cut-off End Date'; }  ?></td>
<td><?php echo
$this->Form->create('Emp',array('method' => 'post')).
'<table><tr><td>'.
$this->Form->input('cut_off',array('label' => false, 'type' => 'select', 'options' =>$total, 'value' => $cutDropDown)).
'</td></tr></table>'.

'<br>'.$this->Form->end('View schedule');

?>
</td>
</tr>
</table>
</div>
<h2>Schedule</h2>
<div class="span3" style='height:700px'>

<table class='table-bordered'>
<thead>
<tr>
<th >Date</th>
<th >Shift Start</th>
<th >Shift End</th>
<th >Log-in</th>
<th >Log-out</th>
<th >L</th>
<th >UT</th>
<th >OT1</th>
<th >OT2</th>
<th >OT3</th>
<th >OT4</th>
<th >OT5</th>
<th >N1</th>
<th >N2</th>
<th >N3</th>
<th >N4</th>
<th >N5</th>
<th >H1</th>
<th >H2</th>
<th >H3</th>
<th >H4</th>
<th >Remark</th>
<th >OT</th>
<th style='text-align:center;height:10px;'>Edit</th>
</tr>
</thead><tbody>

<?php
define('START_NIGHT_HOUR','22');
define('START_NIGHT_MINUTE','00');
define('START_NIGHT_SECOND','00');
define('END_NIGHT_HOUR','06');
define('END_NIGHT_MINUTE','00');
define('END_NIGHT_SECOND','00');

function night_difference($start_work,$end_work)
{
				$start_night = mktime(START_NIGHT_HOUR,START_NIGHT_MINUTE,START_NIGHT_SECOND,date('m',$start_work),date('d',$start_work),date('Y',$start_work));
				$end_night   = mktime(END_NIGHT_HOUR,END_NIGHT_MINUTE,END_NIGHT_SECOND,date('m',$start_work),date('d',$start_work) + 1,date('Y',$start_work));

				if($start_work >= $start_night && $start_work <= $end_night)
				{
								if($end_work >= $end_night)
								{
												return ($end_night - $start_work) / 3600;
								}
								else
								{
												return ($end_work - $start_work) / 3600;
								}
				}
				elseif($end_work >= $start_night && $end_work <= $end_night)
				{
								if($start_work <= $start_night)
								{
												return ($end_work - $start_night) / 3600;
								}
								else
								{
												return ($end_work - $start_work) / 3600;
								}
				}
				else
				{
								if($start_work < $start_night && $end_work > $end_night)
								{
												return ($end_night - $start_night) / 3600;
								}
								return 0;
				}
}
?>
<?php
$ot1total = 0; $ot2total = 0; $ot3total = 0; $ot4total = 0; $ot5total = 0;
$nd1total = 0; $nd2total = 0; $nd3total = 0; $nd4total = 0; $nd5total = 0;
$hd1total = 0; $hd2total = 0; $hd3total = 0; $hd4total = 0;
$errorCount = 0 ; $restDayCount = 0; $vacationLeaveCount = 0; $offSetCount = 0 ; $sickLeaveCount = 0; $absentCount = 0; $halfDayCount = 0;
$nd1 = 0; $nd2 = 0; $nd3 = 0; $nd4 = 0; $nd5 = 0;
$hd1 = 0; $hd2 = 0; $hd3 = 0; $hd4 = 0;

$temp_scale =0;
$holiday_type = 0; 
if (($holidays[0]['Holiday']['date']!=null)) {
				foreach($holidays as $holiday):
								$holiday_start_date = date('M d, Y', strtotime($holiday['Holiday']['date']));
				$temp[$holiday_start_date."-holiday"] = $holiday_start_date;
				$holiday_type = $holiday['Holiday']['regular'];
				$temp[$holiday_type."-holiday"] = $holiday_type;
				$temp[date('M d, Y', strtotime($holiday['Holiday']['date'])).'type_of_holiday'] = $holiday['Holiday']['regular'];
				endforeach;
}
foreach($exs as $ex2):
				$os[$ex2['Schedule']['id']]['start'] = $ex2['Schedule']['time_in'];
				$os[$ex2['Schedule']['id']]['end'] = $ex2['Schedule']['time_out'];
				endforeach;
				foreach($excemptions as $excemption):
								$excemption_date = date('M d, Y', strtotime($excemption['Scheduleoverride']['start_date']));
								$excemp_to=$excemption['Scheduleoverride']['time_out'];
								$excemp_ti=$excemption['Scheduleoverride']['time_in'];
								$temp[$excemption_date."-shift"] = $excemption['Scheduleoverride']['time_in'].'-'.$excemption['Scheduleoverride']['time_out'];
								$temp[$excemption_date."-type_name"] = $excemption['Scheduleoverride_type']['name'];
								$excemptype=$temp[$excemption_date."-type_name"];
								endforeach;
								if($histor[0]['Week']['start_date']!=null){
												foreach($histor as $history):
																$start_date = date('M d, Y', strtotime($history['Week']['start_date']));
												$end_date = date('M d, Y', strtotime($history['Week']['end_date']));
												$daydiff = floor( ( strtotime( $end_date ) - strtotime( $start_date ) ) / 86400 );

												for($x=0;$x<=$daydiff;$x++){
																$temp[$start_date."-start"] = $history['Schedule']['time_in'];
																$temp[$start_date."-end"] = $history['Schedule']['time_out'];
																$restd=$history['Schedule']['rd'];
																$start_date = date('M d, Y',strtotime($start_date."+1 day"));
												}
												endforeach;
								}

if($couts[0]['Checkinout']['CHECKTIME']!=null){
				foreach($couts as $cout):
								$cout_start_date = date('M d, Y', strtotime($cout['Checkinout']['CHECKTIME']));
				$cout_start_time = date('H:i:s', strtotime($cout['Checkinout']['CHECKTIME']));
				$cout_all[$cout_start_date] = $cout_start_time;
				endforeach;
}

if($cout_reverses[0]['Checkinout']['CHECKTIME']!=null){
				foreach($cout_reverses as $cout_reverse): 
								$cout_reverse_start_date = date('M d, Y', strtotime($cout_reverse['Checkinout']['CHECKTIME']));
				$cout_reverse_start_time = date('H:i:s', strtotime($cout_reverse['Checkinout']['CHECKTIME']));
				$cout_reverse_all[$cout_reverse_start_date] = $cout_reverse_start_time;
				endforeach;
}
$cin_start_date_coder = null;
if($cins[0]['Checkinout']['CHECKTIME']!=null){
				foreach($cins as $cin):
								$cin_start_date = date('M d, Y', strtotime($cin['Checkinout']['CHECKTIME']));
				$cin_start_time = date('H:i:s', strtotime($cin['Checkinout']['CHECKTIME']));
# $cin_start_date_coder = date('Y-M-d', strtotime($cin['Checkinout']['CHECKTIME']));	
				$temp[$cin_start_date."-starttime"] = $cin_start_time;
				$temp[$cin_start_date."-endtime"] = isset($cout_all[$cin_start_date]) ? $cout_all[$cin_start_date] : null;
				if (isset($cout_reverse_all[$cin_start_date]) && $cout_reverse_all[$cin_start_date] < $temp[$cin_start_date."-starttime"]){
								$cin_minus_one = date('M d, Y', strtotime('-1 day'.$cin_start_date));
								$alt_cout[$cin_minus_one] = $cout_reverse_all[$cin_start_date];
								if ($alt_cout[$cin_minus_one] == $temp[$cin_start_date."-endtime"]){
												$temp[$cin_start_date."-endtime"] = null;
								} 
				}

				endforeach;
}
$curr_date = mktime(0,0,0,01,01,date("Y"));
$yearend_date = mktime(23,59,59,12,31,date("Y"));

while ($curr_date <= $yearend_date){
$ot1b = 0; $ot2b = 0; $ot3b = 0; $ot4b = 0; $ot5b = 0;
$ot1 = 0; $ot2 = 0; $ot3 = 0; $ot4 = 0; $ot5 = 0;
$nd1b = 0; $nd2b = 0; $nd3b = 0; $nd4b = 0; $nd5b = 0;
$hd1b = 0; $hd2b = 0; $hd3b = 0; $hd4b = 0; $hd5b = 0;
				$curr_date_myd = date('M d, Y', $curr_date);
				if (!isset($temp[$curr_date_myd."-starttime"]) && isset($cout_all[$curr_date_myd])){
								$curr_date_myd_minus_one = date('M d, Y', strtotime('-1 day'.$curr_date_myd));
								$alt_cout[$curr_date_myd_minus_one] = $cout_all[$curr_date_myd];
				}

				$curr_date += 86400;;
}

$s_month = date('m',strtotime($sdates));
$s_day = date('d',strtotime($sdates));
$e_month = date('m',strtotime($edates));
$e_day = date('d',strtotime($edates));
$s_year = date('Y',strtotime($sdates));
$e_year = date('Y',strtotime($edates));

#$curr_date = mktime(0,0,0,3,26,date("Y"));
#$yearend_date = mktime(23,59,59,4,10,date("Y"));
#######SYD
$curr_date = mktime(0,0,0,$s_month,$s_day,$s_year);
$yearend_date = mktime(23,59,59,$e_month,$e_day,$e_year);



while ($curr_date <= $yearend_date){
				$excemp = 0;
				$remark = null;
				$ot_remark = null;
				$bg = null;
				$bg1 = null;				
				$fcolor = null;
				$curr_date_myd = date('M d, Y', $curr_date);
				if(isset($temp[$curr_date_myd.'-type_name']) != null){
								$temp_start_ex = $temp[$curr_date_myd.'-shift'];
								$temp_start = substr($temp_start_ex, 0, -9);
								$temp_end = substr($temp_start_ex, 9);
				}else{
								$temp_start = isset($temp[$curr_date_myd."-start"]) ? $temp[$curr_date_myd."-start"] : null;
								$temp_end = isset($temp[$curr_date_myd."-end"]) ? $temp[$curr_date_myd."-end"] : null;
	}
				$cin_start_date_coder = isset($temp[$curr_date_myd."-startdate"]) ? $temp[$curr_date_myd."-startdate"] : null; 
				$temp_cin = isset($temp[$curr_date_myd."-starttime"]) ? $temp[$curr_date_myd."-starttime"] : null;
				$temp_cout = isset($temp[$curr_date_myd."-endtime"]) ? $temp[$curr_date_myd."-endtime"] : null;
				$temp_cout = isset($alt_cout[$curr_date_myd]) ? $alt_cout[$curr_date_myd] : $temp_cout;
				$cin_time = strtotime($curr_date_myd. " ". $temp_cin);
				$shift_time = strtotime($curr_date_myd. " ". $temp_start);
				$ndCounter = 0;
				if (($temp_cin != null)	&& ($temp_cout != null))
				{ 
								$interval = night_difference(strtotime('today '.$temp_cin),strtotime('tomorrow '.$temp_cout));
				}
				if (isset($temp_cout) && $temp_cout != null){	
								$cout_time = strtotime($curr_date_myd." ".$temp_cout);
				} else {
								$cout_time = null;
				}

				$shift_time_end = strtotime($curr_date_myd." ".$temp_end);
				$late = floor(($cin_time - $shift_time) / 60);
				$late = $late < 0 ? 0: $late;
				if ($cout_time != null) {
								$temp_scale_catch = 0;
								$under = floor(($cout_time - $shift_time_end) / 60);
								$temp_scale_catch = $under;		
								$under = $under > 0 ? 0: $under*-1;
								if ($temp_scale_catch >= 60){
												$temp_scale_catch = $temp_scale_catch/60;
												$temp_scale = floor($temp_scale_catch * 2) /2;
								}
				} else {
								$under = '0';
				}
				if (isset($alt_cout[$curr_date_myd])){
		####						$under = '0';
				}
				if ($temp_start==null && $temp_end==null && $temp_cin == null && $temp_cout == null){
								$remark = null;
								$late = null;
								$under = null;
				} 
				else if($temp_cin == null or $temp_cout == null){
								$remark = 'ERROR';
								/*if($temp_cin == null){
									$temp_cin='NO IN';
									}else if($temp_cout == null){
									$temp_cout='NO OUT';
									}*/
				}
				$tempOt = 0;
				if (isset($temp[$curr_date_myd."-type_name"])){
								{
#debug($temp[$curr_date_myd."-type_name"]);
								}               # $bg = "bgcolor = #D6FFC2";
				}

				if ($temp_start!=null && $temp_end!=null && $temp_cin == null && $temp_cout == null){
								if ($temp_cin == null and $temp_cout == null)
								{
												$remark = "Absent";
												$fcolor = "style='color:red'";
								}								
								if (isset($temp[$curr_date_myd."-type_name"])){
												$remark = $temp[$curr_date_myd."-type_name"];
												if ($remark == "Rest Day"){
																$temp_start = null;
																$temp_end = null;
																$remark = '';
																$rd="yes";
																$bg = "bgcolor = #D6FFC2";
												}
								} else {
												$remark = "Absent";
												$fcolor = "style='color:red'";
								}

								$late = 0;
								$under = 0;
				}
				$ddays=date('D',strtotime($curr_date_myd));
				if((strstr($restd,$ddays))==true){
								$rd='yes';
								$fcolor = "style='color:black'";
								$remark='';
								$bg= "bgcolor = #D6FFC2";
				}else{
								$rd='no';
				}

				if (isset($temp[$curr_date_myd."-type_name"])){
								$remark = $temp[$curr_date_myd."-type_name"];
        }
				/*			if ($remark == 'Overtime')
								{
												$ot_remark = 'Y';
												$remark = null;
											$ot_time =	$this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot1'.'/' );
debug($ot_time);/
								} */
					
				if ($remark == "Rest Day"){
								$rd="yes";
								$bg = "bgcolor = #D6FFC2";
				}
				if ($bg != "bgcolor = #D6FFC2")
				{
					if ($remark == "No pay")
					{
                $bg = "bgcolor = #CCCCCC";
       		}
				}
#echo( $temp[$curr_date_myd."-type_name"]);
				if(isset($temp[$curr_date_myd."-holiday"])){
								if ( isset($temp[$curr_date_myd."type_of_holiday"]))
								{
												if ($remark == "Rest Day" or $remark = 'R Holiday' or $remark = 'S Holiday' or  $remark == "Excemption" or $remark == "Absent" ) {
																if ($temp[$curr_date_myd."type_of_holiday"] == '1')
																{
																				$remark = 'R Holiday';
																				$fcolor = "style='color:black'";
																}
																else
																{
																				$remark = 'S Holiday';
																				$fcolor = "style='color:black'";
																}
												}
								}
#if ($employee['Group']['name'] != 'Network Engineer'){
#}
				}
				$late_total += $late;
				$under_total += $under;
#		if(isset($temp[$curr_date_myd.'-type_name']) == 'Overtime')	
#		{
#						$tempOt = $ot;
#		}
				$ot_total += $tempOt;
				if(isset($temp[$curr_date_myd.'-type_name']) != null){
								if(($temp[$curr_date_myd.'-type_name'])== 'Excemption')
								{
												$excemp = 1;
								}	
				}
				if(substr($temp_cin, 0, -3) == substr($temp_cout, 0, -3)and $temp_cin != null){
								$remark = 'ERROR';
        }

				if($temp_cin == null and $temp_cout != null){
								$remark = 'ERROR';
				}
				if($temp_cin != null and $temp_cout == null){
								$remark = 'ERROR';
				}
				if ($ot_remark != 'Y')
				{ 
								$ot_remark = 'N';
								$otcolor = "style='color:black'";
				}
				else{
								$otcolor = "style='font-weight:bold'";
				}

				if ($remark == 'Sick Leave')
				{ 
								$sickLeaveCount = $sickLeaveCount + 1;
								$late_total = $late_total - $late;						
								$under_total = $under_total - $under;							
								$late = 0;
								$under =0 ;
								$bg= "bgcolor = #ADD6FF";
								$yesLeave = 1;
				}
				else if ($remark == 'Offset')
				{ 
								$offSetCount = $offSetCount + 1;
                $late_total = $late_total - $late;
								$under_total = $under_total - $under;                
								$late = 0;
                $under =0 ;
                $bg= "bgcolor = #ADD6FF";
                $yesLeave = 1;
        }

				else if ($remark == 'Vacation Leave')
				{
								$vacationLeaveCount = $vacationLeaveCount + 1;
								$late_total = $late_total - $late;
								$under_total = $under_total - $under;	
								$late = 0;
								$under = 0;
								$bg= "bgcolor = #ADD6FF";
								$yesLeave = 1; 
				}
				else if ($remark == 'Half Day')
				{			
								$late_total = $late_total - $late;	
								$under_total = $under_total - $under;							
								$late = 0;
                $under = 0;
								$halfDayCount = $halfDayCount + 1;
				}

				else if ($remark == 'Absent')
				{
								$absent_total = $absent_total + 1;
				}
				else if ($remark == 'No pay' and $bg == "bgcolor = #CCCCCC" )
        {
								$under_total = $under_total - $under;
								$late_total = $late_total - $late;
                $late = 0;
                $under = 0;
                $nopay_total = $nopay_total + 1;
        }

				else if ($remark == 'ERROR')
				{
								$errorCount = $errorCount + 1;
								$bg= "bgcolor = #FF9999";
				}
				if ($excemp == 1)
				{
								if ($remark != 'R Holiday' and $remark != 'S Holiday')				
								{				$remark = 'Excemption';
								}
								$bg = null;
				}
				else if ($bg == "bgcolor = #D6FFC2" or $remark == 'Rest Day')
				{				$bg = "bgcolor = #D6FFC2";
								$under_total = $under_total - $under;
								$late_total = $late_total - $late;
								$late = 0;
								$under = 0;
								$restDayCount = $restDayCount + 1;
								$fcolor = "style='color:black'";
				}	
				if (($temp_cin != null and $temp_cout == null) or ($temp_cin == null and $temp_cout != null))
        {
                $halfDayCount = $halfDayCount + 1;
        }

				$trimDate = substr($curr_date_myd, 0, -6);
				$trimTempStart = substr($temp_start, 0, -3);
				$trimTempEnd = substr($temp_end, 0, -3);
				$trimTempCin = substr($temp_cin, 0, -3);
				$trimTempCout = substr($temp_cout, 0, -3);
				$tempCinDate = date('Y-m-d',strtotime($curr_date_myd));
				$tempCoutDate = (strtotime($trimTempCin) > strtotime($trimTempCout)) ? date('Y-m-d',strtotime($curr_date_myd.'+1 day')) : date('Y-m-d',strtotime($curr_date_myd));
$ot2c = 0;
#CODE FOR OT	
				if ($cout_time != null and $cin_time != null) {
								if ($bg != "bgcolor = #D6FFC2"){
												$temp_scale_catch = 0;
												$under = floor(($cout_time - $shift_time_end) / 60);
												$temp_scale_catch = $under;
												$under = $under > 0 ? 0: $under*-1;
												if ($temp_scale_catch >= 60){
																$temp_scale_catch = $temp_scale_catch/60;
																$temp_scale = floor($temp_scale_catch * 2) /2;
												}
								}
				}
				if (($temp_cin != null) && ($temp_cout != null))
				{
								if ( ($bg == 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
								{
												$ot3 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot3'.'/' );
												$ot3b = $temp_scale;
												$ot3total = $ot3total + $ot3;
								}
								else if (  ($bg != 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
								{
												$ot4 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot4'.'/' );
												$ot4b = $temp_scale;
												$ot4total = $ot4total + $ot4;
								}
								else if (  ($bg == 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
								{
												$ot5 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot5'.'/' );
												$ot5b = $temp_scale;
												$ot5total = $ot5total + $ot5;
								}
								else if ( ($bg == 'bgcolor = #D6FFC2' or $remark == 'S Holiday'))
								{
												$ot2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot2'.'/' );
												$ot2c = $temp_scale;
						#					$ot2total = $ot2total + $ot2;
								}
								else if ( $bg != 'bgcolor = #D6FFC2' and $remark != 'S Holiday' and $remark != 'R Holiday')
								{
											$ot1 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot1'.'/' );
											$ot1b = $temp_scale;
											$ot1total = $ot1total + $ot1;
								}
				}

#CODE FOR NIGHT DIFF
				if (($temp_cin != null) && ($temp_cout != null))
				{	
								$interval = night_difference(strtotime($tempCinDate.' '.$temp_cin),strtotime($tempCoutDate.' '.$temp_cout));
								$ndCounter = floor($interval * 2) / 2;
								if (($bg == 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
								{
												if ($temp_start != '21:00:00'){
																$nd3 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'nd3'.'/' );
												}
												else
												{
																$nd3 = $ndCounter;
												}
												$nd3b = $ndCounter;
												$nd3total = $nd3total + $nd3;
								}
								else if (($bg != 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
								{
												if ($temp_start != '21:00:00'){
																$nd4  =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'nd4'.'/' );
												}
												else
												{
																$nd4 = $ndCounter;
												}
												$nd4b = $ndCounter;
												$nd4total = $nd4total + $nd4;
								}
								else if (($bg == 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
								{
												if ($temp_start != '21:00:00'){
																$nd5 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'nd5'.'/' );
												}
												else
												{								
																$nd5 = $ndCounter;				
												}								
												$nd5b = $ndCounter;
												$nd5total = $nd5total + $nd5;
								}
								else if (($bg == 'bgcolor = #D6FFC2' or $remark == 'S Holiday'))
								{ 
												if ($temp_start != '21:00:00'){
																$nd2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'nd2'.'/' );
												}							
												else{		
																$nd2 = $ndCounter;
												}										
												$nd2b = $ndCounter;
												$nd2total = $nd2total + $nd2;
								}
								else if ($bg != 'bgcolor = #D6FFC2' and $remark != 'S Holiday' and $remark != 'R Holiday')
								{
												if ($temp_start != '21:00:00'){
																$nd1 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'nd1'.'/' );
												}										
												else
												{
																$nd1 = $ndCounter;
												}											
												$nd1b = $ndCounter;
												$nd1total = $nd1total + $nd1;
								}
				}
#CODE FOR HOLIDAY
				if (($temp_cin != null) && ($temp_cout != null))
				{
								$tempCinDateHoliday =strtotime($tempCinDate . ' ' . $temp_cin);
	$tempCoutDateHoliday = strtotime($tempCoutDate . ' ' . $temp_cout);
#debug($tempCinDate.' '.$temp_cin);
#debug($tempCoutDate.' '.$temp_cout);			
					$diffHoliday =(($tempCoutDateHoliday - $tempCinDateHoliday) / 3600);
								$holidayHours =  floor($diffHoliday * 2) / 2;
								if (($bg == 'bgcolor = #D6FFC2' and $remark != 'S Holiday' and $remark != 'S Holiday'))
								{
								#			$ot2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot2'.'/' );
								#			$ot2b = $holidayHours;
								#			$ot2total = $ot2total + $ot2;
								}
												if ($holidayHours >= 8){
																$holidayHours  = 8;
												}

												if (($bg == 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
												{$hd2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd2'.'/' );
																$hd2b = $holidayHours;
																$hd2total = $hd2total + $hd2;
												}
												else if (($bg != 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
												{$hd3 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd3'.'/' );
																$hd3b = $holidayHours;
																$hd3total = $hd3total + $hd3;
												}
												else if (($bg == 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
												{$hd4 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd4'.'/' );
																$hd4b = $holidayHours;
																$hd4total = $hd4total + $hd4;
												}
												else if (($bg != 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
												{$hd1 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd1'.'/' );
																$hd1b = $holidayHours;
																$hd1total = $hd1total + $hd1;
												}
												else if (($bg == 'bgcolor = #D6FFC2' and $remark != 'S Holiday' and $remark != 'S Holiday'))
												{
																$ot2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot2'.'/' );
																$ot2b = $holidayHours + $ot2c;
																$ot2total = $ot2total + $ot2;
												}
				}
				if ($trimTempStart == '' and $trimTempEnd == '' and ($trimTempCin != null or $trimTempCout != null))
				{
								$errorCount = $errorCount + 1;
								$bg= "bgcolor = #FF9999";
				}
				echo "<tr> 
								<td $bg>$trimDate </td>
								<td $bg>";echo $trimTempStart;if(($rd != 'yes')&&($temp_start!=null or $temp_start!=0)){$dayin++;}
				echo "</td>
								<td $bg>";echo $trimTempEnd;
				echo "</td><td $bg>";
								if($temp_cin == null and $remark=='ERROR'){
									echo $this->Html->link('No in',array('action' => 'error', $employee['Employee']['id'], $curr_date));
								}
								else if($temp_cin != null and $remark=='ERROR'){
                  echo $this->Html->link($trimTempCin,array('action' => 'error', $employee['Employee']['id'], $curr_date));
                }

								else{
								#	echo $this->Html->link($trimTempCin,array('action' => 'error', $employee['Employee']['id'], $curr_date));
						 echo $trimTempCin;
								};
								if($temp_cin == null and $remark=='Absent'){
									echo $this->Html->link('Absent',array('action' => 'error', $employee['Employee']['id'], $curr_date));}
									echo "</td>
							<td $bg>";
								if($temp_cout == null && $remark=='ERROR'){
									echo $this->Html->link('No out',array('action' => 'error', $employee['Employee']['id'], $curr_date));
							}
								else if($temp_cout != null and $remark=='ERROR'){
                  echo $this->Html->link($trimTempCout,array('action' => 'error', $employee['Employee']['id'], $curr_date));
                }
							else{
								echo $trimTempCout;
								};
			if($temp_cout == null && $remark=='Absent'){
				echo $this->Html->link('Absent',array('action' => 'error', $employee['Employee']['id'], $curr_date));}
	echo "</td>
				<td $bg>".$late.
				"</td>
        <td $bg>".$under.
        "</td>";
				$bg1 = $bg;
				if($ot1b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($ot1 > 0 ){$bg1= $bg;}
				echo  "<td $bg1>";if( $bg1== 'bgcolor = #CCB2FF' or $ot1b != 0) { echo $this->Html->link($ot1,array('controller' => 'Incentives', 'action' => 'ot', $employee['Employee']['id'], $curr_date, 'ot1',$ot1b));$bg1 = $bg;}else{echo $ot1;}
				echo "</td>";
				
				if($ot2b!=0  and ($temp_start != null and $temp_end != null  and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($ot2 > 0){$bg1= $bg;} 
				echo "<td $bg1>";if( $bg1== 'bgcolor = #CCB2FF' or $ot2b != 0){ echo $this->Html->link($ot2,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'ot2',$ot2b)); $bg1 = $bg;}else{echo $ot2;}
       	echo "</td>";
				
				if($ot3b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($ot3 > 0){$bg1= $bg;}
       	echo "<td $bg1>";if($bg1== 'bgcolor = #CCB2FF' or $ot3b != 0){ echo $this->Html->link($ot3,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'ot3',$ot3b));$bg1 = $bg;}else{echo $ot3;}
        echo "</td>";
			 
				if($ot4b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)) {$bg1= 'bgcolor = #CCB2FF';}if($ot4 > 0){$bg1= $bg;}	
        echo "<td $bg1>";if($bg1== 'bgcolor = #CCB2FF' or $ot4b != 0){echo $this->Html->link($ot4,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'ot4',$ot4b)); $bg1 = $bg;}else{echo $ot4;}
        echo "</td>";

				if ($ot5b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)) {$bg1= 'bgcolor = #CCB2FF';}if($ot5 > 0){$bg1= $bg;}        
				echo "<td $bg1>";if($bg1== 'bgcolor = #CCB2FF' or $ot5b != 0){echo $this->Html->link($ot5,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'ot5',$ot5b)); $bg1 = $bg;}else{echo $ot5;}
        echo "</td>";


				if($nd1b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($nd1 > 0){$bg1= $bg;}
        echo "<td $bg1>";if($bg1 == 'bgcolor = #CCB2FF' or $nd1b != 0){echo $this->Html->link($nd1,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'nd1',$nd1b)); $bg1 = $bg;}else{echo $nd1;}
        echo "</td>";

				if($nd2b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)) {$bg1= 'bgcolor = #CCB2FF';}if($nd2 > 0){$bg1= $bg;}       
echo "<td $bg1>";if($bg1 == 'bgcolor = #CCB2FF' or $nd2b != 0){echo $this->Html->link($nd2,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'nd2',$nd2b)); $bg1 = $bg;}else{echo $nd2;}
        echo "</td>";

				if($nd3b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';} if($nd3 > 0){$bg1= $bg;}       
echo "<td $bg1>";if($bg1 == 'bgcolor = #CCB2FF' or $nd3b != 0){echo $this->Html->link($nd3,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'nd3',$nd3b)); $bg1 = $bg;}else{echo $nd3;}
        echo "</td>";

				if($nd4b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($nd4 > 0){$bg1= $bg;}
        echo "<td $bg1>";if($bg1 == 'bgcolor = #CCB2FF' or $nd4b != 0){echo $this->Html->link($nd4,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'nd4',$nd4b)); $bg1 = $bg;}else{echo $nd4;}
        echo "</td>";

				if($nd5b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($nd5 > 0){$bg1= $bg;}
        echo "<td $bg1>";if($bg1 == 'bgcolor = #CCB2FF' or $nd5b != 0){echo $this->Html->link($nd5,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'nd5',$nd5b));$bg1 = $bg;}else{echo $nd5;}
        echo "</td>";

				if($hd1b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($hd1 > 0){$bg1= $bg;}
        echo "<td $bg1>";if($bg1== 'bgcolor = #CCB2FF' or $hd1b != 0){echo $this->Html->link($hd1,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'hd1',$hd1b));$bg1 = $bg;}else{echo $hd1;}
        echo "</td>";
        
				if($hd2b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($hd2 > 0){$bg1= $bg;}
				echo "<td $bg1>";if($hd2b != 0 or $bg1== 'bgcolor = #CCB2FF'){echo $this->Html->link($hd2,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'hd2',$hd2b));$bg1 = $bg;}else{echo $hd2;}
        echo "</td>";
       
				if($hd3b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($hd3 > 0){$bg1= $bg;}
				echo "<td $bg1>";if($hd3b != 0 or $bg1== 'bgcolor = #CCB2FF'){echo $this->Html->link($hd3,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'hd3',$hd3b));$bg1 = $bg;}else{echo $hd3;}
        echo "</td>";
       
				if($hd4b!=0 and ($temp_start != null and $temp_end != null and $temp_cin != null and $temp_cout != null)){$bg1= 'bgcolor = #CCB2FF';}if($hd4 > 0){$bg1= $bg;} 
				echo "<td $bg1>";if($hd4b != 0 or $bg1== 'bgcolor = #CCB2FF'){echo $this->Html->link($hd4,array('controller' => 'Incentives','action' => 'ot', $employee['Employee']['id'], $curr_date, 'hd4',$hd4b));$bg1 = $bg;}else{echo $hd4;}
        echo "</td>

        <td  $bg $fcolor>".$remark.
				"</td>
				<td $bg $otcolor>".$ot_remark.
				"</td>
				<td class='colorw' $bg>";
				echo '<div class="btn btn-info">'.$this->Html->link('Edit',array('action' => 'edit_day_sched', $employee['Employee']['id'], $curr_date));
				"</td>
				</tr>";
				$curr_date += 86400;
				$ot1 = 0;$ot2 = 0;$ot3 = 0;$ot4 = 0;$ot5 = 0;
				$temp_scale = 0;
				$nd1 = 0;$nd2 = 0;$nd3 = 0;$nd4 = 0;$nd5 = 0;
				$hd1 = 0;$hd2 = 0;$hd3 = 0;$hd4 = 0;
				$ot1b = 0;$ot2b = 0;$ot3b = 0;$ot4b = 0;$ot5b = 0;
        $nd1b = 0;$nd2b = 0;$nd3b = 0;$nd4b = 0;$nd5b = 0;
        $hd1b = 0;$hd2b = 0;$hd3b = 0;$hd4b = 0;			
				$temp_start = null;
				$temp_end = null;
	}
?></tbody>
</div>
</table>
</div></div>
<?php $basic = Security::cipher($employee['Employee']['monthly'], 'my_key');
$d_rate = $basic / 22;
$h_rate = $d_rate / 8;
$m_rate = $h_rate / 60;

function formatAmount($amount)
{
	return number_format($amount, 2, '.', ',');  
}
?>
<h2>Total Computation</h2>
<div class="spantable">
<table >
<tr><td>
<table name="Overtime" class="table table-bordered">
<tr>
<th>Overtime</th>
<th>Total (in hours)</th>
<th>Amount</th>
</tr> 
<tr>
<td>Regular days: </td>
<td><?php echo $ot1total;?></td>
<td><?php $ot1_amount = ((($h_rate * .25))* $ot1total); echo formatAmount($ot1_amount);  ?></td>
</tr>
<tr>
<td>Special holiday or restday</td>
<td><?php echo $ot2total ?></td>
<td><?php $ot2_amount = ((($h_rate * .3))* $ot2total);echo formatAmount($ot2_amount); ?></td>
</tr>
<tr>
<td>Special holiday & restday</td>
<td><?php echo $ot3total ?></td>
<td><?php $ot3_amount =((($h_rate * .5))* $ot3total); echo formatAmount($ot3_amount);?></td>
</tr>
<tr>
<td>Regular holiday:</td>
<td><?php echo $ot4total ?></td>
<td><?php  $ot4_amount =((($h_rate * .3))* $ot4total);echo formatAmount($ot4_amount); ?></td>
</tr>
<tr>
<td>Regular holiday & restday:</td>
<td><?php echo $ot5total ?></td>
<td><?php  $ot5_amount = ((($h_rate * 1.6))* $ot5total);echo formatAmount($ot5_amount); ?></td>
</tr>
<tr>
<td>Total Overtime</td>
<td><?php echo $ot1total + $ot2total + $ot3total + $ot4total + $ot5total; ?></td>
<td><?php echo $otamount = formatAmount($ot1_amount + $ot2_amount + $ot3_amount + $ot4_amount + $ot5_amount);  ?></td>
</tr>
<tr>
<td>Over Time with deductions</td>
<?php $ottotals=($ot1_amount + $ot2_amount + $ot3_amount + $ot4_amount + $ot5_amount);?>
<td colspan=2><center><?php echo formatAmount($deduc=$ottotals - ($ottotals * 0.10)); $otamount=$deduc;?></td>
</tr>
</table>
</td><td>
<table name="Night" class="table table-bordered">
<tr>
<th>Night Differential</th>
<th>Total (in hours)</th>
<th>Amount</th>
</tr>
<tr>
<td>Regular days: </td>
<td><?php echo $nd1total;?></td>
<td><?php  $nd1_amount =  ((($h_rate * .1))* $nd1total);echo formatAmount($nd1_amount);  ?></td>  
</tr>
<tr>
<td>Special holiday or restday</td>
<td><?php echo $nd2total ?></td>
<td><?php  $nd2_amount = ((($h_rate * .3))* $nd2total); echo formatAmount($nd2_amount); ?></td>
</tr>
<tr>
<td>Special holiday & restday</td>
<td><?php echo $nd3total ?></td>
<td><?php  $nd3_amount = ((($h_rate * .5))* $nd3total); echo formatAmount($nd3_amount); ?></td>
</tr>
<tr>
<td>Regular holiday:</td>
<td><?php echo $nd4total ?></td>
<td><?php $nd4_amount = ((($h_rate * 1))* $nd4total); echo formatAmount($nd4_amount);?></td>
</tr>
<tr>
<td>Regular holiday & restday:</td>
<td><?php echo $nd5total ?></td>
<td><?php $nd5_amount =((($h_rate * 1.6))* $nd5total); echo formatAmount($nd5_amount); ?></td>
</tr>
<tr>
<td>Total Night Differential</td>
<td><?php echo $nd1total + $nd2total + $nd3total + $nd4total + $nd5total; ?></td>
<td><?php $ndamount = ($nd1_amount + $nd2_amount + $nd3_amount + $nd4_amount + $nd5_amount); echo formatAmount($ndamount); ?></td>
</tr>

</table>

</td><td>
<table name="Holiday" class="table table-bordered">
<tr>
<th>Holiday pay</th>
<th>Total (in hours)</th>
<th>Amount</th>
</tr>
<tr>
<td>Special holiday</td>
<td><?php echo $hd1total ?></td>
<td><?php  $hd1_amount = ((($h_rate * .3))* $hd1total); echo formatAmount($hd1_amount)?></td>
</tr>
<tr>
<td>Special holiday & restday</td>
<td><?php echo $hd2total ?></td>
<td><?php $hd2_amount = ((($h_rate * .5))* $hd2total); echo formatAmount($hd2_amount)?></td>
</tr>
<tr>
<td>Regular holiday:</td>
<td><?php echo $hd3total ?></td>
<td><?php  $hd3_amount = ((($h_rate * 1))* $hd3total); echo formatAmount($hd3_amount)?></td>
</tr>
<tr>
<td>Regular holiday & restday:</td>
<td><?php echo $hd4total ?></td>
<td><?php  $hd4_amount = ((($h_rate * 1.6))* $hd4total); echo formatAmount($hd4_amount)?></td>
</tr>
<tr>
<td>Total Holiday pay</td>
<td><?php echo $hd1total + $hd2total + $hd3total + $hd4total; ?></td>
<td><?php $hdamount = ($hd1_amount + $hd2_amount + $hd3_amount + $hd4_amount); echo formatAmount($hdamount); ?></td>
</tr>

</table>
</td></tr><tr><td>
<table label="Salary" class="table table-bordered">
<tr>
<th>Salary</th>
<th>Amount</th>
</tr>
<tr>
<td>Monthly rate</td>
<td><?php echo $this->Html->link(formatAmount($basic),array('action' => 'edit', $employee['Employee']['id']));?></td>
</tr>
<tr>
<td>Daily Rate</td>
<td><?php echo formatAmount($d_rate);?></td>
</tr>
<tr>
<td>Hour Rate</td>
<td><?php echo formatAmount($h_rate);?></td>
</tr>
<tr>
<td>Minute Rate</td>
<td><?php echo formatAmount($m_rate);?></td>
</tr>

</table>

</td><td>
<table label="Deductions" class="table table-bordered">
<tr>
<th>Deductions</th>
<th>Total period</th>
<th>Amount</th>
</tr>
<tr>
<?php if ($no_log > 0){
	$late_total = 0;
	$under_total = 0;
	$absent_total = 0;
	$errorCount = 0;
	}
?>
<td>Lates: (in minutes)</td>
<td><?php echo $late_total;?></td>
<td><?php $late_amount = $late_total * $m_rate; echo number_format($late_amount, 2, '.', ',');?></td>
</tr>
<tr>
<td>Under times: (in minutes)</td>
<td><?php echo $under_total ?></td>
<td><?php $under_amount = $under_total * $m_rate; echo number_format($under_amount, 2, '.', ',');?></td>

</tr>
<tr>
<td>Absents: (in days)</td>
<td><?php echo $absent_total ?></td>
<td><?php $absent_amount = $absent_total * $d_rate; echo number_format($absent_amount, 2, '.', ',');?></td>
</tr>

<tr>
<td>No pay: (in days))</td>
<td><?php echo $nopay_total ?></td>
<td><?php $nopay_amount = $nopay_total * $d_rate; echo number_format($nopay_amount, 2, '.', ',');?></td>
</tr>
<tr>
<td>Half Days: (in days)</td>
<td><?php echo $halfDayCount ?></td>
<td><?php $half_day_amount = $halfDayCount * ($d_rate/2); echo number_format($half_day_amount, 2, '.', ',');?></td>
</tr>

<tr>
<td>Total Amount</td>
<td><?php echo null ?></td>
<td><?php $deduction_amount =$half_day_amount + $absent_amount + $nopay_amount + $late_amount + $under_amount; echo number_format($deduction_amount, 2, '.', ',');?></td>
</tr>

</table>
</td><td>

<table label="Government" class="table table-bordered">
<tr>
<th>Govt Mandated</th>
<th>Amount</th>
</tr>
<tr>
<td>SSS</td>
<td><?php $sss = $govDeduc['Govdeduction']['sss'] / 2; echo number_format($sss, 2, '.', ',');?></td>
</tr>
<tr>
<td>Philhealth</td>
<td><?php $philhealth = $govDeduc['Govdeduction']['philhealth'] / 2; echo number_format($philhealth, 2, '.', ',');?></td>
</tr>
<tr>
<td>Pag-ibig</td>
<td><?php $pagibig = $govDeduc['Govdeduction']['pagibig'] / 2; echo number_format($pagibig, 2, '.', ',');?></td>
</tr>
<tr>
<td>Tax</td>
<td><?php $tax = $govDeduc['Govdeduction']['tax'] / 2; echo number_format($tax, 2, '.', ',');?></td>
</tr>
<tr>
<td>Total Amount</td>
<td><?php $gov_deductions =$tax + $pagibig + $philhealth + $sss; echo number_format($gov_deductions, 2, '.', ',');?></td>
</tr>
</table>
</td>
</tr>
</table>
<table><tr>
<td>
<?php
foreach ($empLoans as $eLoan):
 if ($eLoan['Loan']['loan_type']==0){
	$ssid = $eLoan['Loan']['id'];
	$ssLoan = formatAmount($eLoan['Loan']['amount']/2);
	}else if($eLoan['Loan']['loan_type']==1){
	$hmdfid = $eLoan['Loan']['id'];
	$hmdfLoan = formatAmount($eLoan['Loan']['amount']/2);}
endforeach;
?>
<table name="" class="table table-bordered">
<tr>
<th>Loans</th>
<th>Amount</th>
</tr>
<tr>
<td>SSS Loan</td>
<td><?php
if ($ssLoan == 0){
echo $this->Html->link($ssLoan,array('controller'=>'Loans','action' => 'add_loan', $employee['Employee']['id'],$ssid));
}
else{
echo $this->Html->link($ssLoan,array('controller'=>'Loans','action' => 'edit_loan', $employee['Employee']['id'],$ssid));
}
?>
</td>
</tr>
<tr>
<td>HMDF Loan</td>
<td><?php 
if($hmdfLoan ==0){
echo $this->Html->link($hmdfLoan,array('controller'=>'Loans','action' => 'add_loan', $employee['Employee']['id'],$hmdfid));
}else{
echo $this->Html->link($hmdfLoan,array('controller'=>'Loans','action' => 'edit_loan', $employee['Employee']['id'],$hmdfid));
}
?>
</td>
</tr>
</tr>
</table>
</td>
<td>
<table name="Cutoff Summary" class="table table-bordered">
<tr>
<th>Summary</th>
<th>Total Amount</th>
</tr>
<tr>
<td>Basic pay</td>
<td><?php $basicHalf = $basic / 2; echo formatAmount($basicHalf)?></td>
</tr>
<tr>
<td>Deductions</td>
<td><?php echo formatAmount('-'.$deduction_amount)?></td>
</tr>
<tr>
<td>Gov Deductions</td>
<td><?php echo formatAmount('-'.$gov_deductions)?></td>
</tr>
<tr>
<td>Overtime pay</td>
<td><?php echo formatAmount($otamount)?></td>
</tr>
<tr>
<td>Night differentials:</td>
<td><?php echo formatAmount($ndamount)?></td>
</tr>
<tr>
<td>Holiday pay</td>
<td><?php echo formatAmount($hdamount)?></td>
</tr>
<tr>
<?php
$net =  $hdamount + $ndamount + $otamount - $gov_deductions - $deduction_amount + $basicHalf;
$totalsalary=$net;
?>
</tr>
<tr>
<td>Attendance Bonus</td>
<td><?php if(($late_total==0)&&($absent_total==0)&&($halfDayCount==0)&&($under_total==0)&&($yesLeave == 0)){
				$attbonus=($dayin*100);
				echo formatAmount($attbonus);
}else{
				echo "NONE";
}?></td>
</tr>
<tr>
<td>Net pay</td>
<td><?php echo formatAmount($totalsalary + $attbonus - $ssLoan - $hmdfLoan);?></td>
</tr>
<tr>
<td>
<div class="colorw">
<div class="btn btn-primary" style="width:90px">
<?php
echo $this->Html->link('Add Retro',array('controller'=>'Retros','action' => 'index', $employee['Employee']['id'],$cutDropDown));
$curr_date = null;
$temp_start = null;
$temp_end = null;
$temp_cin = null;
$temp_cout = null;
?>

</div></div>
</td><td></td>
</tr></tr>
</table>
</td></tr>
</table></div>
