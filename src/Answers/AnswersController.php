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
    public function getAnswerById($answerId)
    {
        $res = $this->answers->find($answerId);
        $res = $res->getProperties();
        return $res;   

    }

    /**
     * Get answers
     *
     */
    public function getAnswers($questionId)
    {
        $res = $this->answers->getAnswersforQuestion($questionId);

        return $res;   

    }

    public function addAction($text)
    {
        $questionId = $this->QuestionsController->getCurrentQuestionId();
        // Get user id from logged in user
        $user = $this->UserController->getUserAction();
        $userId = $user->id;
        $now = gmdate('Y-m-d H:i:s');

        try {
            $res = $this->answers->save([
            'text'    => $text,
            'userId' => $userId,
            'questionId' => $questionId,
            'created' => $now
        ]);
        }
        catch (\Exception $e) {
            $this->form->AddOutput("<p>Svaret kunde inte sparas</p>");
            $this->form->AddOutput($e->getMessage());
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