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
     * Reset and setup database table
     *
     * @return void
     */
    public function setupAction()
    {
       $this->users->setup();
    }


    /**
     * Login user
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
                $this->callbackFailLogin($this->loginForm);
            }
             return $this->loginForm->getHTML();
        
        }   
    }

    /**
     * Logout user
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
     
        $this->theme->setTitle("Visa alla användare");
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Alla användare</h1></div>");
        $this->views->add('users/list-all', [
            'users' => $all,
        ]);
    }

    /**
     * Get user with id or if no id - get current user.
     *
     * @param int $id of user to display
     *
     * @return obj User
     */
    public function getUserAction($id = null)
    {     
        if($id === null) {
            $user = $this->users->getLoggedInUser();
        }
        elseif (is_numeric($id)) {
            $user = $this->users->find($id);
        }


        return $user;
    }

    /**
     * Check if a user is logged in
     *
     * @param int $id of user to display
     *
     * @return boolean
     */
    public function isUserLoggedIn()
    {     
        $res = $this->users->isUserLoggedIn();

        return $res;
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
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>" . $user->acronym . "</h1></div>");
        $this->views->add('users/list-one', [
            'title' => "View user with id " . $id ,
            'user' => $user,
        ]);
    }

    // Register
    /**
     * @return string - html form
     *
     */
    public function registerAction()
    {
        
        $status = $this->registerForm->check();

        if($status === true) {
            $this->callbackSuccess($this->registerForm);
        }
        elseif($status === false) {
            $this->callbackFailRegister($this->registerForm);
        }
         return $this->registerForm->getHTML();
    }


    /**
     * Add new user.
     * @return void - redirects to login page.
     */
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
                $this->form->AddOutput("<p>Du har blivit registrerad med framgång goch kan nu logga in</p>");
            }
        }
        catch (\Exception $e) {
            $this->form->AddOutput("<p>Användaren kunde inte bli registrerad, testa med ett annat användarnamn</p>");
            $this->redirectTo();
        }

        
        $this->redirectTo('login');
        return true;
    }

    private function callbackSuccess($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Form was submitted and the callback method returned TRUE</i></p>");
            $this->redirectTo();
    }

    private function callbackFailLogin($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Användarnamn eller lösenord är felaktiga</i></p>");
            $this->redirectTo();
    }

    private function callbackFailRegister($form)
    {
            // What to do if the form was submitted?
            $form->AddOUtput("<p><i>Något gick fel</i></p>");
            $this->redirectTo();
    }
 
}