<?php
class Application_Form_Book extends Zend_Form {

    public function init(){
        $this->setName('Book');
        $this->setMethod("post");
        $this->setAction("new");

        $id = new Zend_Form_Element_Hidden('id');
        $id->addFilter('Int');

        $ISBN = new Zend_Form_Element_Text('ISBN');
        $ISBN->setLabel('ISBN number')
               ->setRequired(true)
               ->addFilter('StringTrim')
               ->addFilter('StripTags')
               ->addFilter('Digits')
               ->addValidator('NotEmpty')
               //->addValidator('Int', true, array('messages'=>array('notInt' => 'Only numbers allowed in ISBN')))
               ->addValidator('Isbn');

        $author = new Zend_Form_Element_Text('author');
        $author->setLabel('Author name')
               ->setRequired(true)
               ->addFilter('StringTrim')
               ->addFilter('StripTags')
               ->addValidator('NotEmpty');

        $book_name = new Zend_Form_Element_Text('name');
        $book_name->setLabel('Name of the book')
               ->setRequired(true)
               ->addFilter('StringTrim')
               ->addFilter('StripTags')
               ->addValidator('NotEmpty');

        $description = new Zend_Form_Element_Textarea('description');
        $description->setLabel('Description for the book')
              ->setRequired(true)
              ->setAttrib('cols', '40')
              ->setAttrib('rows', '10')
              ->addFilter('StringTrim')
              ->addFilter('StripTags')
              ->addValidator('NotEmpty');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($id,$ISBN,$author,$book_name, $description, $submit));
    }
}
