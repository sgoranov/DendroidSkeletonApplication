<?php
namespace App\Component\Login;

use App\Component\Login\Utils\AuthenticatedUser;
use sgoranov\Dendroid\Bootstrap\Component\FlashMessenger;
use sgoranov\Dendroid\Component\RoutedComponent;

class Logout extends ProtectedPage implements RoutedComponent
{

    public function onLoad(FlashMessenger $flashMessenger)
    {
        AuthenticatedUser::logout();

        $flashMessenger->addSuccess("You've been logged out successfully");

        $this->redirect('/');
    }

    public function getRoutePath(): string
    {
        return '/logout';
    }
}