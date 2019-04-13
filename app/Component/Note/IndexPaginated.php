<?php
namespace App\Component\Note;

use sgoranov\Dendroid\Bootstrap\Component\Pagination;

class IndexPaginated extends Index
{
    public function getPagination(): Pagination
    {
        list($route, $page) = $this->getRouteParams();

        $pagination = new Pagination('/page/{PAGE}', $page, $this->noteRepository->getTotal(), $this->getItemsToShow());
        $pagination->setPaginationLabels('Previous', 'Next');

        return $pagination;
    }

    public function getRoutePath(): string
    {
        return '/page/(\d+)';
    }
}