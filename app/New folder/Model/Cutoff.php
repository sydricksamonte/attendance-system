<?php
class Cutoff extends AppModel{
				function getCutOffAvailable($edate)
				{ $edate = Date('Y-m-d', strtotime("+0 days"));
								$cond = $this->find('list',array(
																				'fields' => array('end_date'),
																				'conditions' => array('end_date <= ' => $edate),
																				'order' => array('end_date' => 'DESC')));
								return $cond;
				}
				 function getCutOffPeriodStart($id)
        {
                $cond = $this->find('first',array(
                                        'conditions' => array('id' => $id)));
								return $cond['Cutoff']['start_date'];
        }
				 function getCutOffPeriodEnd($id)
        {
                $cond = $this->find('first',array(
                                        'conditions' => array('id' => $id)));
                return $cond['Cutoff']['end_date'];
        }
				 function getCutOffRecent($edate)
        {				 $edate = Date('Y-m-d', strtotime("+10 days"));
                $cond = $this->find('first',array(
																				'fields' => array('id'),
																				'conditions' => array('end_date <= ' => $edate),
																				'order' => array('end_date' => 'DESC')));
				 				return $cond['Cutoff']['id'];
        }
				function getCutOffRecentEnd($edate)
        {				 $edate = Date('Y-m-d', strtotime("+10 days"));
                $cond = $this->find('first',array(
                                        'fields' => array('id'),
                                        'conditions' => array('end_date <= ' => $edate),
                                        'order' => array('end_date' => 'DESC')));
                return $cond['Cutoff']['end_date'];
        }
				function getCutOffRecentStart($edate)
        {				 $edate = Date('Y-m-d', strtotime("+10 days"));
                $cond = $this->find('first',array(
                                        'fields' => array('id'),
                                        'conditions' => array('end_date <= ' => $edate),
                                        'order' => array('end_date' => 'DESC')));
                return $cond['Cutoff']['start_date'];
        }

        public $validate = array(
                        'start_date' => array(
                                'rule'    => 'isUnique',
                                )
                        );	
}
?>
