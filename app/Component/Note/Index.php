<?php
namespace App\Component\Note;

use App\Repository\NoteRepository;
use sgoranov\Dendroid\Bootstrap\Component\FlashMessenger;
use sgoranov\Dendroid\Bootstrap\Component\Pagination;
use sgoranov\Dendroid\Component\Page;
use sgoranov\Dendroid\Component\Route;
use sgoranov\Dendroid\Component\RoutedComponent;

class Index extends Page implements RoutedComponent
{
    use Delete, Paginated;

    protected array $notes = [];

    protected Route $routing;
    protected FlashMessenger $flashMessenger;
    protected NoteRepository $noteRepository;

    public function onLoad(FlashMessenger $flashMessenger, Route $routing, NoteRepository $noteRepository)
    {
        $this->initDeletion();
        $this->addComponent('delete-confirmation-form', $this->deleteForm);

        $this->routing = $routing;
        $this->flashMessenger = $flashMessenger;
        $this->noteRepository = $noteRepository;

        $this->setTemplate('templates/Index.phtml');
        $this->addComponent('pagination', $this->getPagination());

        $this->notes = $this->noteRepository->filter(null, $this->getItemsToShow(), $this->getOffset());
    }

    public function onDelete()
    {
        if ($this->deleteForm->isValid()) {

            $id = $this->deleteForm->getData()['id'];

            $this->noteRepository->delete($id);

            $this->flashMessenger->addSuccess('Deleted successfully');
            $this->redirect($this->routing->createUrl(Index::class));
        }
    }

    public function getPagination(): Pagination
    {
        $pagination = new Pagination('/page/{PAGE}', 1, $this->noteRepository->getTotal(), $this->getItemsToShow());
        $pagination->setPaginationLabels('Previous', 'Next');

        return $pagination;
    }

    public function getRoutePath(): string
    {
        return '/';
    }
}