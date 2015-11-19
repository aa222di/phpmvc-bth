<?php
namespace Anax\User;
/**
 * Anax base class for wrapping sessions.
 *
 */
class CRegisterForm extends \Mos\HTMLForm\CForm
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
        'acronym' => [
            'type'        => 'text',
            'label'       => 'Användarnamn',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'password' => [
            'type'        => 'password',
            'label'       => 'Lösenord',
            'required'    => true,
            'validation'  => ['not_empty'],
        ],
        'pwd-repeat' => [
            'type'        => 'password',
            'label'       => 'Repetera lösenord',
            'required'    => true,
             'validation' => [
                'match' => 'password'
            ],
        ],
        'email' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
        ],
        'submit' => [
            'type'      => 'submit',
            'callback'  => function() {

                $res = $this->di->dispatcher->forward([
                    'controller' => 'user',
                    'action'     => 'add',
                    'params'     => [$this->Value('acronym'), $this->Value('password'), $this->Value('email')]
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

    public function getAcronym() {
        return $this->Value('acronym');
    }
}