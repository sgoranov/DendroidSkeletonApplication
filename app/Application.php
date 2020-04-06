<?php
namespace App;

use App\Component\Login\Logout;
use App\Component\Login\Utils\AuthenticatedUser;
use App\Component\Login\WithLoginForm;
use App\Component\Note\Create;
use App\Component\Note\Index;
use App\Component\Note\IndexPaginated;
use App\Component\Note\Update;
use App\Entity\User;
use App\Repository\UserRepository;
use sgoranov\Dendroid\Bootstrap\Component\FlashMessenger;
use sgoranov\Dendroid\Component\Application as DendroidApplication;
use sgoranov\Dendroid\Component\Route;

class Application extends DendroidApplication
{
    protected Route $routing;

    public function onStart()
    {

        // flash messenger component
        $flashMessenger = $this->container->get(FlashMessenger::class);
        $this->addComponent('flash-messenger', $flashMessenger);

        // Routing - we are going to use only one instance of Route
        // ===========================
        $this->routing = $this->container->get(Route::class);

        // Index or Login form
        if (AuthenticatedUser::isLoggedIn()) {

            $userRepository = $this->container->get(UserRepository::class);
            $user = $userRepository->findById(AuthenticatedUser::getUserId());
            $this->container->set(User::class, $user);

            $this->setTemplate("templates/Layout.phtml");
            $this->routing->addRoutedComponent($this->container->get(Index::class));
        } else {

            $this->setTemplate("Component/Login/templates/Layout.phtml");
            $this->routing->addRoutedComponent($this->container->get(WithLoginForm::class));
        }

        $this->routing->addRoutedComponent($this->container->get(IndexPaginated::class));

        // Create Note
        $this->routing->addRoutedComponent($this->container->get(Create::class));

        // Update Note
        $this->routing->addRoutedComponent($this->container->get(Update::class));

        // Logout
        $this->routing->addRoutedComponent($this->container->get(Logout::class));

        $this->addComponent('main-content', $this->routing);
    }
}
