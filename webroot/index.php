<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php';
$app->session();

// Set link style
$app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN);

$app->theme->configure(ANAX_APP_PATH . 'config/theme_aab.php');
$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_aab.php');



// Get pages
 
// Start page 
$app->router->add('', function() use ($app) {

	// Add extra assets to make the slideshow plugin work.
	$app->theme->addStylesheet('css/slideshow.css')
           	   ->addJavaScript('js/slideshow.js');

	// Prepare the page content
	$app->theme->setVariable('title', "Start")
			   ->setVariable('pageheader', "		    
			   	<div id='slideshow' class='slideshow' data-host='' data-path='img/all-about-burgers/' data-images='[\"veggieburger1.jpg\", \"veggieburger2.jpg\", \"veggieburger3.jpg\"]'>
       				<img src='img/all-about-burgers/veggieburger1.jpg' alt='Me'/>
    			</div>
    			")
	           ->setVariable('main', "
		    	<h1>Start</h1>
		    	<p>All about burgers</p>
				");
 
});

// TOP MENU PAGES

// Login page 
$app->router->add('login', function() use ($app) {
	
	// Prepare the page content
	$app->theme->setVariable('title', "Logga in")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Logga in</h1></div>")
	           ->setVariable('main', "
		    <h1>Logga in</h1>
		    <p>All about burgers</p>
		");
 
});


// Register page 
$app->router->add('register', function() use ($app) {
	

	    $form = $app->form->create([], [
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
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmit(): Form was submitted. Do stuff (save to database) and return true (success) or false (failed processing form)</i></p>");
                $form->AddOutput("<p><b>Name: " . $form->Value('acronym') . "</b></p>");
                $form->AddOutput("<p><b>Email: " . $form->Value('email') . "</b></p>");
                $form->saveInSession = true;
                return true;
            }
        ],
        'submit-fail' => [
            'type'      => 'submit',
            'callback'  => function ($form) {
                $form->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
                return false;
            }
        ],
    ]);

    // Check the status of the form
	$form->check(
	    function ($form) use ($app) {
	 
	        // What to do if the form was submitted?
	        $form->AddOUtput("<p><i>Form was submitted and the callback method returned true.</i></p>");
	        $app->redirectTo();
	 
	    },
	    function ($form) use ($app) {
	 
	        // What to do when form could not be processed?
	        $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
	        $app->redirectTo();
	 
	    }
	);

	// Prepare the page content
	$app->theme->setVariable('title', "Registrera ny användare")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Registrera ny användare</h1></div>")
	           ->setVariable('main', "
		    <h1>Register</h1>
		    <p>" . $form->getHTML() . "</p>
		");
 
});

// MAIN MENU PAGES

// Questions page 
$app->router->add('question', function() use ($app) {
	
	// Prepare the page content
	$app->theme->setVariable('title', "Frågor")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Frågor</h1></div>")
	           ->setVariable('main', "
		    <h1>Frågor</h1>
		    <p>All about burgers</p>
		");
 
});


// Tag page 
$app->router->add('tag', function() use ($app) {
	
	// Prepare the page content
	$app->theme->setVariable('title', "Taggar")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Taggar</h1></div>")
	           ->setVariable('main', "
		    <h1>Taggar</h1>
		    <p>All about burgers</p>
		");
 
});


// User page 
$app->router->add('user', function() use ($app) {
	
	// Prepare the page content
	$app->theme->setVariable('title', "Användare")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Användare</h1></div>")
	           ->setVariable('main', "
		    <h1>Användare</h1>
		    <p>All about burgers</p>
		");
 
});


// About page 
$app->router->add('about', function() use ($app) {
	
	// Prepare the page content
	$app->theme->setVariable('title', "Om oss på Allt-Om-Burgare")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Om oss</h1></div>")
	           ->setVariable('main', "
		    <h1>Om oss på Allt-Om-Burgare</h1>
		    <p>All about burgers</p>
		");
 
});





$app->router->handle();
// Render the response using theme engine.
$app->theme->render();
