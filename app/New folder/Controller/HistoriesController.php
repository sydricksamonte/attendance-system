<?php
	class HistoriesController extends AppController{
		public $uses = array('History','Employee','Shift','User');

		public function search(){
			$ressult=$this->data;
$this->set(compact('ressult'));
			$res=$this->Employee->find('all',array(
				'fields'=>array(
          'Employee.id',
          'Employee.first_name',
          'Employee.last_name',
          'History.start_date',
          'History.end_date',
          'Shift.time_shift',
          'History.create_time',
          'Historytype.name',
          'User.first_name',
          'User.last_name'),
      'joins'=>array(
        array(
          'type'=>'left',
          'table'=>'histories',
          'alias'=>'History',
          'conditions'=>array(
              'Employee.id=History.emp_id'
            )
            ),
        array(
          'type'=>'left',
          'table'=>'shifts',
          'alias'=>'Shift',
          'conditions'=>array(
              'History.shift_id=Shift.id'
            )
        ),
        array(
          'type'=>'left',
          'table'=>'historytypes',
          'alias'=>'Historytype',
          'conditions'=>array(
              'History.history_type_id=Historytype.id'
            )
        ),
        array(
          'type'=>'left',
          'table'=>'users',
          'alias'=>'User',
          'conditions'=>array(
              'History.create_by=User.id'
            )
        ),
					
			),

					'conditions' => array(
															array('OR' => array(
																									'OR' =>array(
																																array('Employee.last_name LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('Employee.first_name LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('Employee.id LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('History.start_date LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('Historytype.name LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('History.end_date LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('Shift.time_shift LIKE' => '%'.$ressult['History']['emp_id'].'%'),
																																array('History.create_time LIKE' => '%'.$ressult['History']['emp_id'].'%')
	)))),
      'order'=>array(
        'History.create_time'=>'desc'
      ),
));
#debug($this->data);
      $this->set(compact('res'));
		}

		public function searchall(){
	
			$emp=$this->Employee->find('all',array(
			'fields'=>array(
					'Employee.id',
					'Employee.first_name',
					'Employee.last_name',
					'History.start_date',
					'History.end_date',
					'Shift.time_shift',
					'History.create_time',
					'Historytype.name',
					'User.first_name',
					'User.last_name'
										),
			'joins'=>array(
				array(
					'type'=>'left',
					'table'=>'histories',
					'alias'=>'History',
					'conditions'=>array(
							'Employee.id=History.emp_id'
						)
						),
				array(
          'type'=>'left',
          'table'=>'shifts',
          'alias'=>'Shift',
          'conditions'=>array(
              'History.shift_id=Shift.id'
            )
        ),
				array(
          'type'=>'left',
          'table'=>'historytypes',
          'alias'=>'Historytype',
          'conditions'=>array(
              'History.history_type_id=Historytype.id'
            )
				),
				array(
					'type'=>'left',
          'table'=>'users',
          'alias'=>'User',
          'conditions'=>array(
              'History.create_by=User.id'
            )
				),
									),
			'conditions'=>array(
				'History.id'
			),
			'order'=>array(
				'History.create_time'=>'desc'		
			),
			'group'=>'Employee.id'
			)	
			);
			$this->set(compact('emp'));
	

	
/*lastcreated=$this->History->find('first',array(
			'order'=>array(
					'History.create_time'=>'desc'
				),
				'conditions'=>array(
						'History.emp_id'=>$id
					),
					'fields'=>array(
						'History.create_time',
						1
					)
				));
			$this->set(compact('lastcreated'));
*/
}	
}
?>
