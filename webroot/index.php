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


// Set up db
$app->router->add('setup', function() use ($app) { 
	$app->TagsController->dropTable();
    $app->UserController->setupAction();
    $app->QuestionsController->setupAction();
    $app->AnswersController->setupAction();
    $app->CommentsController->setupAction();
    $app->TagsController->setupAction();
    $app->QuestionsController->listAction();
});

// Get pages
 
// Start page 
$app->router->add('', function() use ($app) {

	// Add extra assets to make the slideshow plugin work.
	$app->theme->addStylesheet('css/slideshow.css')
           	   ->addJavaScript('js/slideshow.js');

    $latestQuestions = $app->QuestionsController->getLatestQuestions(3);
    $popularTags = $app->TagsController->getPopularTags(3);
    $activeUsers = $app->UserController->getMostActiveUsers(3);

	// Prepare the page content
		$app->views->add('questions/question', [
            'questions' => $latestQuestions,
        ]);
        $app->views->add('tags/popular', [
            'tags' => $popularTags,
            'title' => 'Populäraste taggarna'
        ], 'aside');
        $app->views->add('users/active', [
            'users' => $activeUsers,
            'title' => 'Mest aktiva användare'
        ], 'aside');
	

	$app->theme->setVariable('title', "Start")
			   ->setVariable('pageheader', "		    
			   	<div id='slideshow' class='slideshow' data-host='' data-path='img/all-about-burgers/' data-images='[\"veggieburger1.jpg\", \"veggieburger2.jpg\", \"veggieburger3.jpg\"]'>
       				<img src='img/all-about-burgers/veggieburger1.jpg' alt='Me'/>
    			</div>
    			")
	           ->setVariable('main', "
		    	<h1>Välkommen</h1>
		    	<p>Välkommen till allt om vegoburgare! Här finner du tips och trix för att lyckas att få till den bästa vegetariska burgaren i världen! Registrera dig för att kunna ställa frågor och skriva svar.</p>
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
// Most pages are handled by the automatic routing webroot/controller/param/param


// About page 
$app->router->add('about', function() use ($app) {
	
	 $content = $app->fileContent->get('about.md');
     $content = $app->textFilter->doFilter($content, 'shortcode, markdown');
	// Prepare the page content
	$app->theme->setVariable('title', "Om oss på Allt-Om-Burgare")
			   ->setVariable('pageheader', "<div class='pageheader'><h1>Om oss</h1></div>")
	           ->setVariable('main', $content);
 
});





$app->router->handle();
// Render the response using theme engine.
$app->theme->render();
