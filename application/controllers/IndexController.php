<?php
class IndexController extends Zend_Controller_Action{
    public function init(){
        
    }
    public function indexAction(){

        $this->booksTable = new Application_Model_DbTable_Books();
        $this->view->allBooks = $this->booksTable->fetchAll();

    }
}

?>
