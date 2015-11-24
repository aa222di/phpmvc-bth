<?php

namespace Anax\Tags;
 
/**
 * A controller for users and admin related events.
 *
 */
class TagsController extends \Anax\MVC\CControllerBasic
{

    private $form;
    private $tags;
    private $t2q;
    private $allTags;

    public function __construct() {

        $this->tags = new Tags();
        $this->t2q = new TagToQuestion();


    }

    public function setup() {
        $this->tags->setDI($this->di);
        $this->t2q->setDI($this->di);
        $this->allTags = $this->tags->findAll();
    }



    /**
     * Reset and setup database table
     *
     * @return void
     */
    public function setupAction()
    {
       $this->t2q->dropTable();
       $this->tags->setup();
       $this->t2q->setup();
       
    }


    /**
     * List all users.
     *
     * @return void
     */
    public function listAction()
    {
     
        $all = $this->allTags;
        $tagsArray = array();
        foreach ($all as $tag) {
            $tagsArray[$tag->id] = $this->t2q->getQuestionsByTag($tag->id);
         
        }     
        $this->theme->setTitle("Alla taggar");
        $this->views->add('tags/list-all', [
            'number' => $tagsArray,
            'tags' => $all,
            'title' => "Alla taggar",
        ]);
    }

    /**
     *
     */
    public function getTags()
    {     
        return $this->allTags;
    }

    /**
     *
     */
    public function getTagsByQuestion($id)
    {     
        $tagIds = $this->t2q->getTagsByQuestion($id);
        $relatedTags = array();

        foreach ($tagIds as $key => $tagId) {
            foreach ($this->allTags as $tag) {
                if( $tagId[0] === $tag->id) {
                    $relatedTags[$tag->id] = $tag->name;
                }
            }
        }
        return $relatedTags;
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
        $tag = $this->tags->find($id); 
        $questions = array();
        $qId = $this->t2q->getQuestionsByTag($tag->id);

        foreach ($qId as $key => $value) {
            $q = $this->QuestionsController->getQuestion($value[0]);
            $questions[] = $q;
        }
        $title = "Alla frågor taggade med " . $tag->name;

        $this->theme->setTitle($title);
        $this->views->add('tags/list-one', [
            'title' => $title,
            'questions' => $questions,
        ]);
    }

    // Register
    /**
     * Add new user.
     *
     */
    public function createAction()
    {


    }

    public function addAction($tags)
    {
        $exists = false;

        $tagsArray = explode(",", $tags);
        foreach ($tagsArray as $tag) {
            $tag = trim($tag);
            if(!empty($tag)) {
                foreach ($this->allTags as $existingTag) {
                    if($tag === $existingTag->name) {
                        $exists = true;
                    }
                }
                if(!$exists) {
                    $this->tags->create(['name'  => $tag,]);
                    $exists = false;
                }
                
            }
        }
        $this->allTags = $this->tags->findAll();
    }

    public function connectTagsAction($oldTags = array(), $newTags = null, $questionId)
    {
        $allTags = array();
        if($newTags) {

            $newTagsArray = explode(",", $newTags);

            foreach ($newTagsArray as $tag) {
                $tag = trim($tag);
            }

            // Get all id's 
            $ids = array();
            foreach ($newTagsArray as $tag) {
                foreach ($this->allTags as $tableTag) {
                    if($tag === $tableTag->name) {
                        $ids[] = $tableTag->id;
                    }
                }
            }
            if(!empty($oldTags)) {
                 $allTags = array_merge($oldTags, $ids);
            }
            else {
                $allTags = $ids;
            }
        }

        if(empty($allTags)) {
            $allTags = $oldTags;
        }

        foreach ($allTags as $id) {
            $this->t2q->create(['idTags'  => $id, 'idQuestions' => $questionId]);
        }

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