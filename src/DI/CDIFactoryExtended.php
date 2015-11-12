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

        // Add CForm to framework
        $this->set('form', '\Mos\HTMLForm\CForm');

        // Create extra navbar for top menu
        $this->setShared('topnav', function () {
        $navbar = new \Anax\Navigation\CNavbar();
        $navbar->setDI($this);
        $navbar->configure(ANAX_APP_PATH . 'config/topnav.php');
        return $navbar;
        });
    }

}