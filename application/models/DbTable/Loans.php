<?php
class Application_Model_DbTable_Loans extends Zend_Db_Table_Abstract {
    protected $_name = 'loans';
    protected $_primary = 'id';
    public function getPastLoaners(){

        $select = $this->select();
        $select->from('loans')
               ->group('loaner_name');

        $rows = $this->fetchAll($select);
        $loaners = array();
        foreach($rows as $row){
            $loaners[$row->loaner_name] = $row->loaner_name;
        }
        return $loaners;
    }
    public function loanBook($loan_info){
       
        $newLoan = $this->createRow();
        $newLoan->book_id = $loan_info['book_id'];
        $newLoan->loaner_name = $loan_info['loaner_name'];
        $newLoan->date_loaned = new Zend_Date();
        $newLoan->save();
    }
    public function getLoanedTo($id){
        $row = $this->fetchRow($this->select()->where('book_id = ?', $id));
        return $row->loaner_name;
    }
    public function getLoanHistory($id){
        $select = $this->select();
        $select->where('book_id = ?', $id)
               ->order('id DESC');

        $loans = $this->fetchAll($select);
        return $loans;
    }
    public function setReturnDate($id){
        $row = $this->fetchRow(
               $this->select()
                    ->where('id = ?', $id));
        $row->date_returned = new Zend_Date();
        $row->save();
    }
}