<?php
namespace App\Component\Note\Form;

use sgoranov\Dendroid\Bootstrap\Form;
use sgoranov\Dendroid\Bootstrap\FormElement;
use sgoranov\Dendroid\Component\Form\Input;
use sgoranov\Dendroid\Component\Form\Textarea;
use sgoranov\Dendroid\Validator\Chain;
use sgoranov\Dendroid\Validator\RegularExpression;

class Note extends Form
{
    public function __construct()
    {
        parent::__construct('note-form');

        // Title
        $validator = new Chain();
        $validator->addValidator(new RegularExpression('/[\s\S]/', 'This field is required'));
        $validator->addValidator(new RegularExpression('/[A-Za-z\d]+/', 'This field must contains letters and digits only'));

        $element = new Input('title');
        $element->setValidator($validator);

        $wrapper = new FormElement($element);
        $wrapper->setLabel('Title');
        $this->addComponent('title', $wrapper);

        // Description
        $wrapper = new FormElement(new Textarea('description'));
        $wrapper->setLabel('Description');
        $this->addComponent('description', $wrapper);
    }
}