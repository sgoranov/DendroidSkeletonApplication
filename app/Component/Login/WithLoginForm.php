<?php
namespace App\Component\Login;

use App\Component\Login\Form\Login;
use App\Component\Login\Utils\AuthenticatedUser;
use sgoranov\Dendroid\Component\Page;
use sgoranov\Dendroid\Component\Route;
use sgoranov\Dendroid\Component\RoutedComponent;

class WithLoginForm extends Page implements RoutedComponent
{
    protected Login $form;

    protected Route $routing;

    public function onLoad(Route $routing)
    {
        $this->setTemplate('templates/WithLoginForm.phtml');

        $this->routing = $routing;

        $this->form = new Login();
        $this->form->attach('onSubmit', [$this, 'onSubmit']);
        $this->addComponent('form-login', $this->form);
    }

    public function onSubmit(AuthenticatedUser $authenticatedUserUtil)
    {
        if ($this->form->isValid()) {
            $data = $this->form->getData();

            if (!$authenticatedUserUtil->login($data['email'], $data['password'])) {

                $this->form->addError('Invalid email or password');
            } else {

                $this->redirect('/');
            }
        }
    }

    public function getRoutePath(): string
    {
        return '/';
    }
}
