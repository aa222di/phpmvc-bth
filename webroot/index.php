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

if($app->session->has(\Anax\User\User::$loginSession)) {
	$app->topnav->configure(ANAX_APP_PATH . 'config/topnav_logout.php');
}

//echo $app->session->get('');
//echo \Anax\User\User::$loginSession;
//var_dump($_SESSION);

// Set up db
$app->router->add('setup-u', function() use ($app) { 
    $app->UserController->setupAction();
    $app->UserController->listAction();
});

$app->router->add('setup-q', function() use ($app) {
    $app->QuestionsController->setupAction();
    $app->QuestionsController->listAction();
});

$app->router->add('setup-t', function() use ($app) {
    $app->TagsController->setupAction();
    $app->TagsController->listAction();
});

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
	
	$form = $app->UserController->loginAction();
	// Prepare the page content
	$app->theme->setVariable('title', "Logga in")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Logga in</h1></div>")
	           ->setVariable('main', "
		    <h1>Logga in</h1>
		    <p>" . $form . "</p>
		"); 
});

// Logout page 
$app->router->add('logout', function() use ($app) {
	
	$app->UserController->logoutAction();
	$form = $app->UserController->loginAction();
	// Prepare the page content
	$app->theme->setVariable('title', "Utloggad")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Utloggad</h1></div>")
	           ->setVariable('main', "
		    <h1>Logga in</h1>
		    <p>" . $form . "</p>
		"); 
});


// Register page 
$app->router->add('register', function() use ($app) {
	
	$form = $app->UserController->registerAction();

	// Prepare the page content
	$app->theme->setVariable('title', "Registrera ny användare")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Registrera ny användare</h1></div>")
	           ->setVariable('main', "
		    <h1>Register</h1>
		    <p>" . $form . "</p>
		");
 
});

// MAIN MENU PAGES

// Questions page 
$app->router->add('question', function() use ($app) {
	
	$app->QuestionsController->listAction();
 
});


// Tag page 
$app->router->add('tag', function() use ($app) {
	
	$app->TagsController->listAction();
 
});


// User page 
$app->router->add('user', function() use ($app) {
	
	$app->UserController->listAction();
 
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
