<?php
class Application_Model_DbTable_Books extends Zend_Db_Table_Abstract {
    protected $_name = 'books';
    
    public function getBook($id,$option=0){
        $row = $this->fetchRow('id = ' . $id);
        if($option == 1)
        {
            $row = $row->toArray();
        }
        return $row;
    }
    public function showDate(){
        
    }
    public function createNewBook($form){
        unset($form['id']);
        $digits = new Zend_Filter_Digits;
        $form['ISBN'] = $digits->filter($form['ISBN']);
        $form['submit_date'] = new Zend_Date();
        $newBook = $this->createRow($form);
        $newBook->save();
    }
    public function editBook($form){
        $row = $this->fetchRow(
               $this->select()
                    ->where('id = ?', $form['id']));
        
        $digits = new Zend_Filter_Digits;
        $form['ISBN'] = $digits->filter($form['ISBN']);

        $row->ISBN = $form['ISBN'];
        $row->author = $form['author'];
        $row->name = $form['name'];
        $row->description = $form['description'];
        $row->save();
    }
    public function loanBook($id, $loaner_name){
        $row = $this->fetchRow(
               $this->select()
                    ->where('id = ?', $id));

        $row->loaned_by = $loaner_name;
        $row->times_loaned++;
        $row->save();
    }
    public function returnBook($id){
        $row = $this->fetchRow(
               $this->select()
                    ->where('id = ?', $id));
        $row->loaned_by = "";
        $row->save();
  
    }
}
