<?php
$date_string = date("D Y-m-d", time());
$wkno=date("W", strtotime($date_string));
$wkplus1=$date_string;
$totalwk=1;
do{

echo "<br> Weeknumber: ".$wkno;
#$day = date("D", time());
#echo "<br>".$date_string;


echo "<br> MONDAY  ".date('Y-m-d',strtotime('monday this week',strtotime($wkplus1)));
echo "<br> TUESDAY  ".date('Y-m-d',strtotime('tuesday this week',strtotime($wkplus1)));
echo "<br> WEDNESDAY  ".date('Y-m-d',strtotime('wednesday this week',strtotime($wkplus1)));
echo "<br> THURSDAY  ".date('Y-m-d',strtotime('thursday this week',strtotime($wkplus1)));
echo "<br> FRIDAY  ".date('Y-m-d',strtotime('friday this week',strtotime($wkplus1)));
echo "<br> SATURDAY  ".date('Y-m-d',strtotime('saturday this week',strtotime($wkplus1)));
echo "<br> SUNDAY  ".date('Y-m-d',strtotime('sunday this week',strtotime($wkplus1)));
echo "<br><br>";
/*
$i=1;
while ($i<7)
{
$dayplus1 = date('D', strtotime('+1 day', strtotime($date_string)));
$plus1 = date('Y-m-d', strtotime('+1 day', strtotime($date_string)));
$i++;
$date_string=$dayplus1;
echo " ".$plus1.$dayplus1."<br>";
}

*/
$wkplus1=date('Y-m-d', strtotime('+1 week',strtotime($wkplus1)));
$wkno=date("W", strtotime($wkplus1));
#echo "<br>"." ".$wkplus1;
#$totalwk++;
}
while ($wkno!=01);
?>
