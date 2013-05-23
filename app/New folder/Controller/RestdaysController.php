<?php
  class RestdaysController extends AppController {
    public $uses = array('Restday');
     public $helpers = array('Html', 'Form');
    var $name = 'Restdays';
         function index() {
          $this->set('restdays', $this->Restday->find('all'));

        }
        function view($id = null) {
        $this->Restday->id = $id;
        $this->set('restdays', $this->Group->read());
    }

     function edit($id = null) {
    $this->Restday->id = $id;
    if (empty($this->data)) {
        $this->data = $this->Restday->read();
    } else {
        if ($this->Restday->save($this->data)) {
            $this->Session->setFlash('Restday has been updated.');
            $this->redirect(array('action' => 'index'));
        }
    }
    }
       function delete($id) {
    if ($this->Restday->delete($id)) {
        $this->Session->setFlash('Restday with id: ' . $id . ' has been deleted.');
        $this->redirect(array('action' => 'index'));
    }
    }
        function add() {
        if (!empty($this->data)) {
            if ($this->Restday->save($this->data)) {
                $this->Session->setFlash('Restday has been saved.');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

  }
?>

