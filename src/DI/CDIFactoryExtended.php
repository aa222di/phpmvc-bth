<?php

namespace Anax\DI;

/**
 * Anax base class implementing Dependency Injection / Service Locator 
 * of the services used by the framework, using lazy loading.
 *
 */
class CDIFactoryExtended extends CDIFactoryDefault
{
    /**
     * Construct.
     *
     */
    public function __construct()
    {
        parent::__construct();

        // Add CDatabase to framework
        $this->setShared('db', function() {
            $db = new \Mos\Database\CDatabaseBasic();
                // LOCALp
            $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql.php');
                // BTH
            // $db->setOptions(require ANAX_APP_PATH . 'config/config_mysql_bth.php');
            
            $db->connect();
            return $db;
        });

        // Add CForm to framework
        $this->set('form', '\Mos\HTMLForm\CForm');

        // Create extra navbar for top menu
        $this->setShared('topnav', function () {
            $navbar = new \Anax\Navigation\CNavbar();
            $navbar->setDI($this);
            $navbar->configure(ANAX_APP_PATH . 'config/topnav.php');
            return $navbar;
        });

        // Add UserController to framework
        $this->set('UserController', function() {
            $controller = new \Anax\User\UserController();
            $controller->setDI($this);
            return $controller;
        });

        // Add QuestionsController to framework
        $this->set('QuestionsController', function() {
            $controller = new \Anax\Questions\QuestionsController();
            $controller->setDI($this);
            $controller->setup();
            return $controller;
        });

        // Add AnswersController to framework
        $this->set('AnswersController', function() {
            $controller = new \Anax\Answers\AnswersController();
            $controller->setDI($this);
            $controller->setup();
            return $controller;
        });


        // Add TagsController to framework
        $this->set('TagsController', function() {
            $controller = new \Anax\Tags\TagsController();
            $controller->setDI($this);
            $controller->setup();
            return $controller;
        });
    }

}