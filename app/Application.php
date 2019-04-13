<?php
namespace App;

use App\Component\Note\Create;
use App\Component\Note\Index;
use App\Component\Note\IndexPaginated;
use App\Component\Note\Update;
use sgoranov\Dendroid\Bootstrap\Component\FlashMessenger;
use sgoranov\Dendroid\Component\Application as DendroidApplication;
use sgoranov\Dendroid\Component\Route;

class Application extends DendroidApplication
{
    protected Route $routing;

    public function onStart()
    {
        $this->setTemplate("templates/Layout.phtml");

        // flash messenger component
        $flashMessenger = $this->container->get(FlashMessenger::class);
        $this->addComponent('flash-messenger', $flashMessenger);

        // Routing - we are going to use only one instance of Route
        // ===========================
        $this->routing = $this->container->get(Route::class);

        // Index
        $this->routing->addRoutedComponent($this->container->get(Index::class));
        $this->routing->addRoutedComponent($this->container->get(IndexPaginated::class));

        // Create Note
        $this->routing->addRoutedComponent($this->container->get(Create::class));

        // Update Note
        $this->routing->addRoutedComponent($this->container->get(Update::class));

        $this->addComponent('main-content', $this->routing);
    }
}
