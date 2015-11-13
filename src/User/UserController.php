<?php

namespace Anax\User;
 
/**
 * A controller for users and admin related events.
 *
 */
class UserController extends \Anax\MVC\CControllerBasic
{

    private $registerForm;

    public function __construct() {
        $this->registerForm = new CRegisterForm();
    }

    // Register
    /**
     * Add new user.
     *
     */
    public function registerAction()
    {
        $this->registerForm->setDI($this->di);
        $status = $this->registerForm->check();

        if($status === true) {
            $this->callbackSuccess($this->registerForm);
        }
        elseif($status === false) {
            $this->callbackFail($this->registerForm);
        }
         return $formHTML = $this->registerForm->getHTML();
    }

    public function addAction($acronym, $password, $email)
    {
        $this->registerForm->AddOUtput("<p><i>add user was called " . $acronym . "</i></p>");
        return true;
    }

    private function callbackSuccess($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Form was submitted and the callback method returned TRUE</i></p>");
            $this->redirectTo();
    }

    private function callbackFail($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Form was submitted and the callback method returned FALSE</i></p>");
            $this->redirectTo();
    }


    // Login

    // Logout

    // Register form
   


    // Login form

    // Logout form
 
}