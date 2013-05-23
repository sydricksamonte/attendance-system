<?php
class TempEmpSched extends AppModel{
        function fetchTempEmp(){
								$tempString = null;
                $tempFields = $this->find('all',array(
                                        'fields' => array(
                                                'emp_id',
                                                )
                                        ));
                foreach ($tempFields as $tf):
                {
                $tempString = $tempString . $tf['TempEmpSched']['emp_id']. '_';
                }
                endforeach;
								$tempString =	substr_replace($tempString ,"",-1);
								$arrayTemp = explode("_", $tempString);
								return ($arrayTemp);
				}
				 function fetchTempSched(){
                $tempString = null;
                $tempFields = $this->find('all',array(
                                        'fields' => array(
                                                'sched_id',
                                                )
                                        ));
                foreach ($tempFields as $tf):
                {
                $tempString = $tempString . $tf['TempEmpSched']['sched_id']. '_';
                }
                endforeach;
                $tempString = substr_replace($tempString ,"",-1);
                $arrayTemp = explode("_", $tempString);
                return ($arrayTemp);
        }
				function fetchTempField(){
                $tempFields = $this->find('all');
                return ($tempFields);
        }
}
?>

