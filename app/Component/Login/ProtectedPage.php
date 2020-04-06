<?php
namespace App\Component\Login;

use App\Component\Login\Exception\AccessDeniedException;
use App\Component\Login\Utils\AuthenticatedUser;
use sgoranov\Dendroid\Component\Page;

class ProtectedPage extends Page
{

    public function onInit()
    {
        if (!AuthenticatedUser::isLoggedIn()) {

            throw new AccessDeniedException('This resource is protected');
        }
    }
}