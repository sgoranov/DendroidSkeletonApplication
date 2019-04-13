<?php
namespace App\Component\Note;

use App\Component\Note\Form\Note;
use Doctrine\ORM\EntityManagerInterface;
use sgoranov\Dendroid\Bootstrap\Component\FlashMessenger;
use sgoranov\Dendroid\Component\Page;
use sgoranov\Dendroid\Component\Route;
use sgoranov\Dendroid\Component\RoutedComponent;

class Create extends Page implements RoutedComponent
{
    private Note $form;
    private FlashMessenger $flashMessenger;
    private Route $routing;

    public function onLoad(FlashMessenger $flashMessenger, Route $routing)
    {
        $this->setTemplate('templates/Create.phtml');

        $this->flashMessenger = $flashMessenger;
        $this->routing = $routing;

        $this->form = new Note();
        $this->form->attach('onSubmit', [$this, 'onSubmit']);
        $this->addComponent('note-form', $this->form);
    }

    public function onSubmit(EntityManagerInterface $entityManager)
    {
        if ($this->form->isValid()) {

            $data = $this->form->getData();

            // save to database
            $note = new \App\Entity\Note();
            $note->setTitle($data['title']);
            $note->setDescription($data['description']);

            $entityManager->persist($note);
            $entityManager->flush();

            $this->flashMessenger->addSuccess('Created successfully');
            $this->redirect($this->routing->createUrl(Index::class));
        }
    }

    public function getRoutePath(): string
    {
        return '/create-note';
    }
}
