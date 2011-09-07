<?php

class Application_Form_Register extends Zend_Form {

    public function init() {
        $this->setName('register');
        $this->setMethod("post");
        $this->setAction("create");

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
                ->setRequired(true)
                ->addValidator('EmailAddress')
                ->addValidator('NotEmpty');

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Password:')
                ->addValidator('StringLength', false, array(6, 24))
                ->setLabel('Choose your password:')
                ->setRequired(true);

        $password2 = new Zend_Form_Element_Password('password-confirm');
        $password2->setLabel('Confirm:')
                ->addValidator('StringLength', false, array(6, 24))
                ->setLabel('Confirm your password:')
                ->addValidator(new Zend_Validate_Identical($_POST['password']))
                ->setRequired(true);


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton');

        $this->addElements(array($email, $password,$password2, $submit));

        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form')),
            array('Description', array('placement' => 'prepend')),
            'Form'
        ));
    }

}