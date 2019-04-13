<?php
namespace App\Component\Note;

use App\Component\Note\Form\Delete as DeleteForm;

trait Delete
{
    protected DeleteForm $deleteForm;

    abstract public function onDelete();

    public function initDeletion()
    {
        // delete confirmation form
        $this->deleteForm = new DeleteForm();
        $this->deleteForm->attach('onSubmit', [$this, 'onDelete']);
    }
}