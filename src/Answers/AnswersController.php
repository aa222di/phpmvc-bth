<?php

namespace Anax\Answers;
 
/**
 * A controller for users and admin related events.
 *
 */
class AnswersController extends \Anax\MVC\CControllerBasic
{

    private $form;
    private $answers;

    public function __construct() {

    }

    public function setup() {

        $this->form = new CAnswersForm();
        $this->answers = new Answers();

        $this->form->setDI($this->di);
        $this->answers->setDI($this->di);
        
    }



    /**
     * Reset and setup database table
     *
     * @return void
     */
    public function setupAction()
    {
       $this->answers->setup();
    }


    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
     
        $all = $this->answers->findAll();
     
        $this->theme->setTitle("Alla frågor");
        $this->views->add('questions/list-all', [
            'questions' => $all,
            'title' => "Alla frågor",
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
    public function getForm()
    {
        if ($this->UserController->isUserLoggedIn()) {
            $status = $this->form->check();

            if($status === true) {
                $this->callbackSuccess($this->form);
            }
            elseif($status === false) {
                $this->callbackFail($this->form);
            }

             return $this->form->getHTML();
        }
        else {
            
                $loginLink = "<a href=" . $this->url->create('login') . ">Logga in för att kunna svara på frågor</a>";
                return $loginLink;
          
        }

    }

        // Register
    /**
     * Get answers
     *
     */
    public function getAnswers($id)
    {
        $res = $this->answers->getAnswersforQuestion($id);

        return $res;   

    }

    public function addAction($subject, $text, $oldTags = array(), $newTags = null)
    {
        // Add new tags
        if($newTags) {
            $this->di->TagsController->addAction($newTags);
        }

        // Get user id from logged in user
        $user = $this->UserController->getUserAction();
        $userId = $user->id;
        $now = gmdate('Y-m-d H:i:s');

        try {
            $res = $this->questions->save([
            'subject'  => $subject,
            'text'    => $text,
            'userId' => $userId,
            'created' => $now
        ]);
            if ($res == true) {
                $url = $this->url->create('question');
                $this->form->AddOutput("<p>Question with id " . $this->questions->id . " was successfully added to the database. " . $now . "</p>");
                $this->form->AddOutput("<p><a href='" . $url . "' title='Se alla frågor'>Se alla frågor</a></p>");
            }
        }
        catch (\Exception $e) {
            $this->form->AddOutput("<p>Frågan kunde inte sparas</p>");
        }
        // Add tag relationsships between tags and question
        $this->di->TagsController->connectTagsAction($oldTags, $newTags, $this->questions->id );
        
        $this->redirectTo();
        return true;
    }


    public function getQuestion($id)
    {
        $res = $this->questions->find($id);
        $res = $res->getProperties();
        return $res;

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