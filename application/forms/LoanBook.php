<?php
class Application_Form_LoanBook extends Zend_Form {
    public function init(){

        $this->setName('loan_book');
        $this->setMethod("post");
        $this->setAction("../loan");

        $book_id = Zend_Registry::get('book_id');

        $id = new Zend_Form_Element_Hidden('book_id');
        $id->addFilter('Int');
        $id->setValue($book_id);

        $loans = new Application_Model_DbTable_Loans();
        $past_loaners_list = $loans->getPastLoaners();
        $loaned_to = $loans->getLoanedTo($book_id);
        $loaners = new Zend_Form_Element_Select('past_loaners');
        $loaners->setLabel('Past Loaners')
                ->addMultiOptions($past_loaners_list)
                ->setValue($loaned_to)
                ->addValidator('NotEmpty')
                ->addFilter('StripTags');

        $new_loaner = new Zend_Form_Element_Text("new_loaner");
        $new_loaner->setLabel("New Loaner")
                   ->addFilter('StripTags');


         $submit = new Zend_Form_Element_Submit('Loan');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id,$loaners,$new_loaner,$submit));
    }
}
