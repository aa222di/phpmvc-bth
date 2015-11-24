<?php

namespace Anax\Questions;
 
/**
 * A controller for users and admin related events.
 *
 */
class QuestionsController extends \Anax\MVC\CControllerBasic
{

    private $form;
    private $questions;

    public function __construct() {

    }

    public function setup() {

        $tags = $this->di->TagsController->getTags();

        $this->form = new CQuestionsForm($tags);
        $this->questions = new Questions();

        $this->form->setDI($this->di);
        $this->questions->setDI($this->di);
        
    }



    /**
     * Reset and setup database table
     *
     * @return void
     */
    public function setupAction()
    {
       $this->questions->setup();
    }


    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
     
        $all = $this->questions->findAll();
     
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Alla frågor</h1></div>");
        $this->theme->setTitle("Alla frågor");
        $this->views->add('questions/list-all', [
            'questions' => $all,
            'title' => "Alla nedan listas alla frågor",
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
        $question = $this->questions->find($id);
        $answerForm = $this->AnswersController->getForm();
        $answers = $this->AnswersController->getAnswers($id);
        
        $this->theme->setVariable('pageheader', "<div class='pageheader'><h1>Frågor</h1></div>");
        $this->theme->setTitle($question->id);
        $this->views->add('questions/list-one', [
            'question' => $question,
            'form' => $answerForm,
            'answers' => $answers
        ]);
    }

    // Register
    /**
     * Add new user.
     *
     */
    public function createAction()
    {
        if ($this->UserController->isUserLoggedIn()) {
            $status = $this->form->check();

            if($status === true) {
                $this->callbackSuccess($this->form);
            }
            elseif($status === false) {
                $this->callbackFail($this->form);
            }

            // Prepare the page content
            $this->theme->setVariable('title', "Skapa ny fråga")
                        ->setVariable('pageheader', "<div class='pageheader'><h1>Lägg till ny fråga</h1></div>")
                        ->setVariable('main', "
                    <h1>Lägg till ny fråga</h1>"
                    . $this->form->getHTML()
            );
        }
        else {
            // Prepare the page content
            $this->theme->setVariable('title', "Skapa ny fråga")
                        ->setVariable('pageheader', "<div class='pageheader'><h1>Lägg till ny fråga</h1></div>")
                        ->setVariable('main', "
                    <h1>Lägg till ny fråga</h1>
                    <a href=" . $this->url->create('login') . ">Logga in för att kunna skriva frågor</a>" 
            );
        }

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