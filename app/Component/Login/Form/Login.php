<?php
namespace App\Component\Login\Form;

use sgoranov\Dendroid\Bootstrap\Form;
use sgoranov\Dendroid\Bootstrap\FormElement;
use sgoranov\Dendroid\Component\Form\Input;
use sgoranov\Dendroid\Validator\RegularExpression;

class Login extends Form
{
    public function __construct()
    {
        parent::__construct('login', 'post');

        // Email
        $element = new Input('email');
        $element->setValidator(new RegularExpression('/[\s\S]/', 'This field is required'));

        $wrapper = new FormElement($element);
        $wrapper->setLabel('Email');
        $this->addComponent('email', $wrapper);

        // Password
        $element = new Input('password');
        $element->setType('password');
        $element->setValidator(new RegularExpression('/[\s\S]/', 'This field is required'));

        $wrapper = new FormElement($element);
        $wrapper->setLabel('Password');
        $this->addComponent('password', $wrapper);
    }
}