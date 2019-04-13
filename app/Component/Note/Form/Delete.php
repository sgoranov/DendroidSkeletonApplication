<?php
namespace App\Component\Note\Form;

use sgoranov\Dendroid\Component\Form;
use sgoranov\Dendroid\Component\Form\Input;

class Delete extends Form
{
    public function __construct()
    {
        parent::__construct('delete-confirmation-form');

        $hidden = new Input('id');
        $hidden->setType('hidden');
        $this->addComponent('form-id', $hidden);
    }
}