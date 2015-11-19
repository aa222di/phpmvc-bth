<?php

namespace Anax\User;
 
/**
 * A controller for users and admin related events.
 *
 */
class UserController extends \Anax\MVC\CControllerBasic
{

    private $registerForm;

    private $loginForm;

    private $users;

    public function __construct() {
        $this->registerForm = new CRegisterForm();
        $this->loginForm = new CLoginForm();
        $this->users = new User();

    }

    public function setDI($di) {
        $this->di = $di;
        $this->registerForm->setDI($this->di);
        $this->loginForm->setDI($this->di);
        $this->users->setDI($this->di);
    }

    /**
     * List all users.
     *
     * @return void
     */
    public function loginAction($login=false, $acronym=null, $password=null)
    {
        if($login) {
            $res = $this->users->login($acronym, $password);
            return $res;
        }

        else {
            $status = $this->loginForm->check();

            if($status === true) {
                $this->callbackSuccess($this->loginForm);
            }
            elseif($status === false) {
                $this->callbackFail($this->loginForm);
            }
             return $this->loginForm->getHTML();
        
        }   
    }

    /**
     * List all users.
     *
     * @return void
     */
    public function logoutAction()
    {
        $this->users->logout();
        $this->redirectTo('login');
    }

    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
     
        $all = $this->users->findAll();
     
        $this->theme->setTitle("List all users");
        $this->views->add('users/list-all', [
            'users' => $all,
            'title' => "View all users",
        ]);
    }

    /**
     * List user with id.
     *
     * @param int $id of user to display
     *
     * @return void
     */
    public function idAction($id = null)
    {     
        $user = $this->users->find($id);
     
        $this->theme->setTitle("View user with id");
        $this->views->add('users/list-one', [
            'title' => "View user with id " . $id ,
            'user' => $user,
        ]);
    }

    // Register
    /**
     * Add new user.
     *
     */
    public function registerAction()
    {
        
        $status = $this->registerForm->check();

        if($status === true) {
            $this->callbackSuccess($this->registerForm);
        }
        elseif($status === false) {
            $this->callbackFail($this->registerForm);
        }
         return $this->registerForm->getHTML();
    }

    public function addAction($acronym, $password, $email)
    {
        try {
            $res = $this->users->save([
            'acronym'  => $acronym,
            'email'    => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);
            if ($res == true) {
                $url = $this->url->create('user/list/');
                $this->form->AddOutput("<p>User with id " . $this->users->id . " was successfully added to the database</p>");
                $this->form->AddOutput("<p><a href='" . $url . "' title='list all users'>List all users</a></p>");
            }
        }
        catch (\Exception $e) {
            $this->form->AddOutput("<p>Användaren kunde inte bli registrerad, testa med ett annat användarnamn</p>");
        }

        
        $this->redirectTo();
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