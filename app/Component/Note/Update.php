<?php
namespace App\Component\Note;

use App\Component\Note\Form\Note;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use sgoranov\Dendroid\Bootstrap\Component\FlashMessenger;
use sgoranov\Dendroid\Component\Page;
use sgoranov\Dendroid\Component\Route;
use sgoranov\Dendroid\Component\RoutedComponent;

class Update extends Page implements RoutedComponent
{
    private \App\Entity\Note $note;
    private Note $form;
    private FlashMessenger $flashMessenger;
    private Route $routing;
    private NoteRepository $noteRepository;

    public function onLoad(FlashMessenger $flashMessenger, Route $routing, NoteRepository $noteRepository)
    {
        $this->setTemplate('templates/Update.phtml');

        $this->routing = $routing;
        $this->flashMessenger = $flashMessenger;
        $this->noteRepository = $noteRepository;

        $this->form = new Note();
        $this->form->attach('onSubmit', [$this, 'onSubmit']);
        $this->addComponent('note-form', $this->form);

        list($route, $id) = $this->getRouteParams();
        $this->note = $this->noteRepository->findById($id);

        $this->form->setData([
            'title' => $this->note->getTitle(),
            'description' => $this->note->getDescription(),
        ]);
    }

    public function onSubmit(EntityManagerInterface $entityManager)
    {
        if ($this->form->isValid()) {

            $data = $this->form->getData();

            $this->note->setTitle($data['title']);
            $this->note->setDescription($data['description']);

            $entityManager->persist($this->note);
            $entityManager->flush();

            $this->flashMessenger->addSuccess('Updated successfully');
            $this->redirect($this->routing->createUrl(Index::class));
        }
    }

    public function getRoutePath(): string
    {
        return '/update/(\d+)';
    }
}


