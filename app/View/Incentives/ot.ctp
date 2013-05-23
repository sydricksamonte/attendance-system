<?php
$i = $hour;
$j = 0;
do{
				$x[$j] = $i;
				$i = $i-0.5;

								$j = $j+1;
				$k = 1;
				if ($i < 1)
				{$x[$j] = 0; break; }
}while($j < $hour *2);
$x = array_combine($x, $x);
echo $curr_date_ymd;  
echo $this->Form->create('Incentive');
echo $this->Form->input('date',array('label'=>'Date','type'=>'hidden', 'value'=>$curr_date_ymd));
echo $this->Form->input('hour',array('label'=>'Hour(s) to approve','type'=>'select','options'=>$x));
echo $this->Form->input('type',array('label'=> 'Type', 'type'=>'hidden', 'value'=>$type));
echo $this->Form->input('emp_id',array('label'=> 'Type', 'type'=>'hidden', 'value'=>$emp_id));
echo $this->Form->input('id',array('label'=> 'Type', 'type'=>'hidden', 'value'=>null));
echo $this->Form->end('Save');
?>
