<?php
$ssLoan = 0;
$hmdfLoan = 0;
$hmdf = 0;
$sssL = 0;
$yesLeave=0;
$dayin=0;
$ot = 0;
$empAuth = $employee['Employee']['employed'];
$sDate = ($employee['Schedule']['time_in']);
$eDate = ($employee['Schedule']['time_out']);
$late_total = 0;
$under_total = 0;
$absent_total = 0;
$nopay_total = 0;

$ot_total =0;
$ot_amount = 0; $ot1_amount = 0; $ot2_amount = 0; $ot3_amount = 0; $ot4_amount = 0; $ot5_amount = 0;
$nd_amount = 0; $nd1_amount = 0; $nd2_amount = 0; $nd3_amount = 0; $nd4_amount = 0; $nd5_amount = 0;
$hd_amount = 0; $hd1_amount = 0; $hd2_amount = 0; $hd3_amount = 0; $hd4_amount = 0;
$late_amount = 0;
$under_amount = 0;
$absent_amount = 0;
$half_day_amount = 0;
$otamount = 0; $ndamount = 0; $hdamount = 0;

$sss = 0;
$phil_health = 0;
$pagibig = 0;
$tax = 0;
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
$ot1 = 0; $ot2 = 0; $ot3 = 0; $ot4 = 0; $ot5 = 0;
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
	$curr_date_myd = date('M d, Y', $curr_date);
	if (!isset($temp[$curr_date_myd."-starttime"]) && isset($cout_all[$curr_date_myd])){
  	$curr_date_myd_minus_one = date('M d, Y', strtotime('-1 day'.$curr_date_myd));
    $alt_cout[$curr_date_myd_minus_one] = $cout_all[$curr_date_myd];
  }

	$curr_date += 86400;;
}

#$s_month = date('m',strtotime($sdates));
#$s_day = date('d',strtotime($sdates));
#$e_month = date('m',strtotime($edates));
#$e_day = date('d',strtotime($edates));

$s_month = date('m',strtotime($startCut));
$s_day = date('d',strtotime($startCut));
$e_month = date('m',strtotime($endCut));
$e_day = date('d',strtotime($endCut));
$s_year = date('Y',strtotime($startCut));
$e_year = date('Y',strtotime($endCut));

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
		$fcolor = null;
		$curr_date_myd = date('M d, Y', $curr_date);
    if(isset($temp[$curr_date_myd.'-type_name']) == 'Excemption'){
      $temp_start_ex = $temp[$curr_date_myd.'-shift'];
      $temp_start = $excemp_ti; 
      $temp_end = $excemp_to;
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
#			$under = '0';
		}

		if ($temp_start==null && $temp_end==null && $temp_cin == null && $temp_cout == null){
			$remark = null;
			$late = null;
			$under = null;
		} else if($temp_cin == null or $temp_cout == null){
			$remark = 'ERROR';
			/*if($temp_cin == null){
				$temp_cin='NO IN';
			}else if($temp_cout == null){
				$temp_cout='NO OUT';
			}*/
		}
		$tempOt = 0;

		if ($temp_start!=null && $temp_end!=null && $temp_cin == null && $temp_cout == null){
			if (isset($temp[$curr_date_myd."-type_name"])){
				$remark = $temp[$curr_date_myd."-type_name"];
				if ($remark == "Rest Day"){
								$temp_start = null;
								$temp_end = null;
                $rd="yes";
				}
			} else {
							$remark = "Absent";
							$fcolor = "style='color:red'";
			}

			$late = null;
			$under = null;
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
			if ($remark == 'Overtime')
			{
							$ot_remark = 'Y';
							$remark = null;
			}
		}
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

		if(isset($temp[$curr_date_myd."-holiday"])){
			if ( isset($temp[$curr_date_myd."type_of_holiday"]))
			{
				 if ($remark == "Rest Day" or  $remark == "Excemption" or $remark == "Absent" ) {
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
			
			if ($employee['Group']['name'] != 'Network Engineer'){
			}
		}

		$late_total += $late;
		$under_total += $under;
#		if(isset($temp[$curr_date_myd.'-type_name']) == 'Overtime')	
#		{
#						$tempOt = $ot;
#		}
		$ot_total += $tempOt;
		if(isset($temp[$curr_date_myd.'-type_name']) == 'Excemption'){
			$temp_start_ex = $temp[$curr_date_myd.'-shift'];
			$temp_start = $excemp_ti;
			$temp_end = $excemp_to;
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
		{ $sickLeaveCount = $sickLeaveCount + 1;
						 $late_total = $late_total - $late;						
						 $late = 0;
						 $under =0 ;
						 $bg= "bgcolor = #ADD6FF";
						 $yesLeave=1;
		}
		else if ($remark == 'Offset')
		{ $offSetCount = $offSetCount + 1;
						$late_total = $late_total - $late;
						$late = 0;
						$under =0 ;
						$bg= "bgcolor = #ADD6FF";
						$yesLeave = 1;
		}
		else if ($remark == 'Vacation Leave')
		{
						$vacationLeaveCount = $vacationLeaveCount + 1;
						$late_total = $late_total - $late;
						$late = 0;
						$under = 0;
						$bg= "bgcolor = #ADD6FF"; 
						$yesLeave=1;
		}
		else if ($remark == 'Half Day')
    {
            $halfDayCount = $halfDayCount + 1;
    }

		else if ($remark == 'Absent')
		{
		  $absent_total = $absent_total + 1;
		}
		else if ($remark == 'No pay' and $bg == "bgcolor = #CCCCCC" )
		{
						$nopay_total = $nopay_total + 1;
		}
		else if ($remark == 'ERROR')
		{
						$errorCount = $errorCount + 1;
						$bg= "bgcolor = #FF9999";
		}
		else if ($remark == 'No pay' and $bg == "bgcolor = #CCCCCC" )
		{
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
						{       $remark = 'Excemption';
						}
						$bg = null;
		}

		if ($excemp == 1)
		{
						if ($remark != 'R Holiday' and $remark != 'S Holiday')
						{       $remark = 'Excemption';
						}
						$bg = null;
		}
		else if ($bg == "bgcolor = #D6FFC2" or $remark == 'Rest Day')
		{       $bg = "bgcolor = #D6FFC2";
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
		if (($rd != 'yes')&&($temp_start!=null or $temp_start!=0)){ $dayin++;}
		$trimTempStart = substr($temp_start, 0, -3);
		$trimTempEnd = substr($temp_end, 0, -3);
		$trimTempCin = substr($temp_cin, 0, -3);
		$trimTempCout = substr($temp_cout, 0, -3);
		$tempCinDate = date('Y-m-d',strtotime($curr_date_myd));
		$tempCoutDate = (strtotime($trimTempCin) > strtotime($trimTempCout)) ? date('Y-m-d',strtotime($curr_date_myd.'+1 day')) : date('Y-m-d',strtotime($curr_date_myd));

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
	
#CODE FOR OT	
		if (($temp_cin != null) && ($temp_cout != null))
		{
						if ( ($bg == 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
						{
										$ot3 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot3'.'/' );
										$ot3total = $ot3total + $ot3;
						}
						else if (  ($bg != 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
						{
										$ot4 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot4'.'/' );
										$ot4total = $ot4total + $ot4;
						}
						else if (  ($bg == 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
						{
										$ot5 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot5'.'/' );
										$ot5total = $ot5total + $ot5;
						}
						else if ( ($bg == 'bgcolor = #D6FFC2' or $remark == 'S Holiday'))
						{
										$ot2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot2'.'/' );
#         $ot2total = $ot2total + $ot2;
						}
						else if ( $bg != 'bgcolor = #D6FFC2' and $remark != 'S Holiday' and $remark != 'R Holiday')
						{
										$ot1 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot1'.'/' );
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
                        $nd1total = $nd1total + $nd1;
                }
		}
#CODE FOR HOLIDAY
    if (($temp_cin != null) && ($temp_cout != null))
    {
						$tempCinDateHoliday =strtotime($tempCinDate . ' ' . $temp_cin);
						$tempCoutDateHoliday = strtotime($tempCoutDate . ' ' . $temp_cout);
						$diffHoliday =(($tempCoutDateHoliday - $tempCinDateHoliday) / 3600);
						$holidayHours =  floor($diffHoliday * 2) / 2;
						if ($holidayHours >= 8)
						{
							$holidayHours = 8;
						}

            if (($bg == 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
            {
                    $hd2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd2'.'/' );
										$hd2total = $hd2total + $hd2;
            }
            else if (($bg != 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
            {
                    $hd3 = $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd3'.'/' );
										$hd3total = $hd3total + $hd3;
            }
            else if (($bg == 'bgcolor = #D6FFC2' and $remark == 'R Holiday'))
            {
                    $hd4 = $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd4'.'/' );
										$hd4total = $hd4total + $hd4;
            }
            else if (($bg != 'bgcolor = #D6FFC2' and $remark == 'S Holiday'))
            {
                    $hd1 = $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'hd1'.'/' );
										$hd1total = $hd1total + $hd1;
            }
						else if (($bg == 'bgcolor = #D6FFC2' and $remark != 'S Holiday' and $remark != 'S Holiday'))
						{
										$ot2 =  $this->requestAction('Incentives/getOverTime/'. $employee['Employee']['id'] .'/'. $curr_date .'/'. 'ot2'.'/' );
										$ot2total = $ot2total + $ot2;
						}
		}

		$curr_date += 86400;
		$ot1 = 0;$ot2 = 0;$ot3 = 0;$ot4 = 0;$ot5 = 0;
		$temp_scale = 0;
		$nd1 = 0;$nd2 = 0;$nd3 = 0;$nd4 = 0;$nd5 = 0;
		$hd1 = 0;$hd2 = 0;$hd3 = 0;$hd4 = 0;
 $ot1b = 0;$ot2b = 0;$ot3b = 0;$ot4b = 0;$ot5b = 0;
        $nd1b = 0;$nd2b = 0;$nd3b = 0;$nd4b = 0;$nd5b = 0;
        $hd1b = 0;$hd2b = 0;$hd3b = 0;$hd4b = 0;

}
?>
<?php 
$basic =Security::cipher($employee['Employee']['monthly'], 'my_key');
$d_rate = $basic / 22;
$h_rate = $d_rate / 8;
$m_rate = $h_rate / 60;
function formatAmount($amount)
{
return number_format($amount, 2, '.', ',');  
}
?>
<?php if ($no_log > 0){
  $late_total = 0;
  $under_total = 0;
  $absent_total = 0;
  $errorCount = 0;
  }
?>

<?php $ot1_amount = ((($h_rate * .25))* $ot1total);?>
<?php $ot2_amount = ((($h_rate * .3))* $ot2total);?>
<?php $ot3_amount =((($h_rate * .5))* $ot3total);?>
<?php $ot4_amount =((($h_rate * .3))* $ot4total);?>
<?php $ot5_amount = ((($h_rate * 1.6))* $ot5total);?>
<?php $otamount = ($ot1_amount + $ot2_amount + $ot3_amount + $ot4_amount + $ot5_amount);  ?>
<?php
formatAmount($deduc=$otamount - ($otamount * 0.10)); $otamount=$deduc;
?>
<?php $nd1_amount =  ((($h_rate * .1))* $nd1total);?>
<?php $nd2_amount = ((($h_rate * .3))* $nd2total);?>
<?php $nd3_amount = ((($h_rate * .5))* $nd3total);?>
<?php $nd4_amount = ((($h_rate * 1))* $nd4total);?>
<?php $nd5_amount =((($h_rate * 1.6))* $nd5total);?>
<?php $ndamount = ($nd1_amount + $nd2_amount + $nd3_amount + $nd4_amount + $nd5_amount);
 ?>

<?php $hd1_amount = ((($h_rate * .3))* $hd1total);?>
<?php $hd2_amount = ((($h_rate * .5))* $hd2total);?>
<?php $hd3_amount = ((($h_rate * 1))* $hd3total);?>
<?php $hd4_amount = ((($h_rate * 1.6))* $hd4total);?>
<?php $hdamount = ($hd1_amount + $hd2_amount + $hd3_amount + $hd4_amount);
?>

<?php $late_amount = $late_total * $m_rate;?>
<?php $under_amount = $under_total * $m_rate;?></td>
<?php $absent_amount = ($absent_total +  $nopay_total) * $d_rate;?>
<?php $half_day_amount = $halfDayCount * ($d_rate/2);?>

<?php $sss = $govDeduc['Govdeduction']['sss'] / 2;?>
<?php $philhealth = $govDeduc['Govdeduction']['philhealth'] / 2;?>
<?php $pagibig = $govDeduc['Govdeduction']['pagibig'] / 2;?>
<?php $tax = $govDeduc['Govdeduction']['tax'] / 2;?>
<?php $gov_deductions = $tax + $pagibig + $philhealth + $sss;?>
<?php $deduction_amount = $half_day_amount + $absent_amount + $late_amount + $under_amount;?>

<?php  
foreach ($empLoans as $eLoan):
 if ($eLoan['Loan']['loan_type']==0){
  $ssid = $eLoan['Loan']['id'];
  $ssLoan = $eLoan['Loan']['amount']/2;
  }else if($eLoan['Loan']['loan_type']==1){
  $hmdfid = $eLoan['Loan']['id'];
  $hmdfLoan = $eLoan['Loan']['amount']/2;}
endforeach;
?>


<?php $account_id = $employee['Employee']['account_id'];
$attbonus = 0;
if(($late_total==0)&&($absent_total==0)&&($halfDayCount==0)&&($under_total==0)&&($yesLeave == 0)){
              $attbonus=($dayin*100);
              }
  $net_pay = ($basic / 2) + $otamount + $ndamount + $hdamount - ($deduction_amount + $gov_deductions) + $attbonus - ($hmdfLoan + $ssLoan);
$all_deduction = $deduction_amount + $gov_deductions;
echo $net_pay;
if ($net_pay <= 0)
{$errorCount= $errorCount+1;
}

?>

<?php
$employeeID = $employee['Employee']['id']; 
$basic = Security::cipher($basic, 'my_key'); 
$net = Security::cipher($net_pay, 'my_key');
$this->requestAction('Totals/saveInfo/'.$dateId . '/' .$employeeID.'/'.$basic.'/'.$account_id.'/'.$absent_total.'/'.$late_total.'/'.$all_deduction .'/'. $attbonus .'/'. $sss .'/'. $philhealth .'/'. $pagibig  .'/'. $tax .'/'. $otamount .'/'. $ndamount .'/'. $hdamount .'/'. $net.'/'. $errorCount.'/'.$ssLoan. '/'.$hmdfLoan .'/'  );
?>
