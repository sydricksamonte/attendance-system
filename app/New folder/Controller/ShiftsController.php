<?php
  class ShiftsController extends AppController {
     public $helpers = array('Html', 'Form');
    var $name = 'Shifts';
         function index() {
          $this->set('shift', $this->Shift->find('all'));

        }
        function view($id = null) {
        $this->Group->id = $id;
        $this->set('groups', $this->Group->read());
    }

     function edit($id = null) {
    $this->Shift->id = $id;
    if (empty($this->data)) {
    
 $this->data = $this->Shift->read();

    } else {
 $endTime = $this->data['Shift']['end_time'];
                  $startTime = $this->data['Shift']['start_time'];
                          debug($startTime);
                                  debug($endTime);
                                          $this->request->data['Shift']['time_shift'] = $startTime['hour'].':'.$startTime['min'].' '.$startTime['meridian'] .' - '. $endTime['hour'].':'.$endTime['min'].' '.$endTime['meridian'];
                                                  debug($this->data);

        if ($this->Shift->save($this->data)) {
            $this->Session->setFlash('The shift has been updated.');
            $this->redirect(array('action' => 'index'));
        }
    }
    }
       function delete($id) {
    if ($this->Shift->delete($id)) {
        $this->Session->setFlash('Shift has been deleted.');
        $this->redirect(array('action' => 'index'));
    }
    }
    function add() {

        if (!empty($this->data)) {
			    $endTime = $this->data['Shift']['end_time'];
					        $startTime = $this->data['Shift']['start_time'];
									        debug($startTime);
													        debug($endTime);
																	        $this->request->data['Shift']['time_shift'] = $startTime['hour'].':'.$startTime['min'].' '.$startTime['meridian'] .' - '. $endTime['hour'].':'.$endTime['min'].' '.$endTime['meridian'];
																					        debug($this->data);
					$shift = $this->data['Shift']['time_shift'];	
					if ($this->Shift->check($shift)==false)
					{					
									if ($this->Shift->save($this->data)) {
										$this->Session->setFlash('The shift has been saved.');
										$this->redirect(array('action' => 'index'));
						}
					}
					else
					{
									$this->Session->setFlash('The shift exists!');
									$this->redirect(array('action' => 'add'));
					}   
   
}
}
}
?>
