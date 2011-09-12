<?php

class BooksController Extends Zend_Controller_Action {

    public function init() {
        $this->booksTable = new Application_Model_DbTable_Books();
        $this->loansTable = new Application_Model_DbTable_Loans();
    }

    public function IndexAction() {


        $this->view->allBooks = $this->booksTable->fetchAll();
    }

    public function showAction() {

        $id = (int) $this->_getParam('id');

        $book = $this->booksTable->getBook($id);
        Zend_Registry::set('book_id', $book->id);
        $this->view->setEncoding('iso-8859-1');
        $this->view->book = $book;
        $this->view->loan_book_form = new Application_Form_LoanBook();
        
        $this->view->loans = $this->loansTable->getLoanHistory($id);
    }

    public function newAction() {

        $form = new Application_Form_Book();
        $form->submit->setLabel('Add new book');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $bookData = $this->getRequest()->getPost();
            if ($form->isValid($bookData)) {
                $this->booksTable->createNewBook($bookData);
                $this->_redirect("index");
            } else {
                $form->populate($bookData);
            }
        }
    }

    public function editAction() {
        $form = new Application_Form_Book();
        $form->submit->setLabel('Edit book');
        $this->view->form = $form;

        if ($this->getRequest()->isPost()) {
            $bookData = $this->getRequest()->getPost();
            if ($form->isValid($bookData)) {
                $this->booksTable->editBook($bookData);
                $this->_redirect('index');
            } else {
                $form->populate($bookData);
            }
        } else {
            $id = (int) $this->_getParam('id');
            $form->populate(
                    $this->booksTable->getBook($id, 1)
            );
        }
    }

    public function loanAction() {
        $formData = $this->getRequest()->getPost();
        if ($formData['new_loaner'] == "") {
            $formData['loaner_name'] = $formData['past_loaners'];
        } else {
            $formData['loaner_name'] = $formData['new_loaner'];
        }
        $this->loansTable->loanBook($formData);
        $this->booksTable->loanBook($formData['book_id'], $formData['loaner_name']);

        $this->_redirect('/books/show/' . $formData['book_id']);
    }

    public function returnAction() {
        $book_id = (int) $this->_getParam('book_id');
        $loan_id = (int) $this->_getParam('loan_id');
        $this->booksTable->returnBook($book_id);
        $this->loansTable->setReturnDate($loan_id);
        $this->_redirect('/books/show/' . $book_id);
    }

}
