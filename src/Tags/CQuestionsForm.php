<?php
namespace Anax\Tags;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CQuestionsForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;
    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
        'subject' => [
            'type'        => 'text',
            'label'       => 'Rubrik',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'text' => [
            'type'        => 'textarea',
            'label'       => 'Fråga',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function() {

                $res = $this->di->dispatcher->forward([
                    'controller' => 'questions',
                    'action'     => 'add',
                    'params'     => [$this->Value('subject'), $this->Value('text')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
        'submit-fail' => [
            'type'      => 'submit',
            'callback'  => function() {
                $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                return false;
            }
        ],
    ]);

    }
}