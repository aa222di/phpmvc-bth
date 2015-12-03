<?php
namespace Anax\User;

class CEditForm extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;
    /**
     * Constructor
     *
     */
    public function __construct(User $user)
    {
        parent::__construct([], [
        'acronym' => [
            'type'        => 'text',
            'label'       => 'Användarnamn',
            'required'    => true,
            'validation'  => ['not_empty'],
            'value'       => $user->acronym,  
        ],
        'text' => [
            'type'        => 'textarea',
            'label'       => 'Presentation',
            'value'       => $user->text,
        ],
        'email' => [
            'type'        => 'text',
            'required'    => true,
            'validation'  => ['not_empty', 'email_adress'],
            'value'       => $user->email,
        ],
        'id' => [
            'type'        => 'hidden',
            'value'       => $user->id,
        ],
        'submit' => [
            'type'      => 'submit',
            'value'     => 'Spara ändringar',
            'callback'  => function() {

                $res = $this->di->dispatcher->forward([
                    'controller' => 'user',
                    'action'     => 'update',
                    'params'     => [ $this->Value('id'), $this->Value('acronym'), $this->Value('email'), $this->Value('text')]
                ]);

                $this->saveInSession = true;
                return $res;
            }
        ],
    ]);
    }

}