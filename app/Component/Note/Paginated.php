<?php
namespace App\Component\Note;

use sgoranov\Dendroid\Bootstrap\Component\Pagination;

trait Paginated
{
    abstract public function getPagination(): Pagination;

    public function getItemsToShow()
    {
        return 10;
    }

    public function getOffset()
    {
        return $this->getPagination()->getOffset();
    }
}