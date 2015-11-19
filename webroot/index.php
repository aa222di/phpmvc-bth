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
    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('user')->execute();
 
    $app->db->createTable(
        'user',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'acronym' => ['varchar(20)', 'unique', 'not null'],
            'email' => ['varchar(80)'],
            'password' => ['varchar(255)'],
        ]
    )->execute();

    $app->db->insert(
        'user',
        ['acronym', 'email', 'password']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        'admin',
        'admin@dbwebb.se',
        password_hash('admin', PASSWORD_DEFAULT)
    ]);
 
    $app->db->execute([
        'doe',
        'doe@dbwebb.se',
        password_hash('doe', PASSWORD_DEFAULT)
    ]);
});

$app->router->add('setup-q', function() use ($app) {
    //$app->db->setVerbose();
 
    $app->db->dropTableIfExists('questions')->execute();
 
    $app->db->createTable(
        'questions',
        [
            'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
            'userId' => ['integer', 'not null'],
            'subject' => ['char(255)'],
            'text' => ['text'],
            'created' => ['datetime'],
            'updated' => ['datetime'],
            'deleted' => ['datetime'],
        ]
    )->execute();

    $app->db->insert(
        'questions',
        ['userId', 'subject', 'text', 'created']
    );
 
    $now = gmdate('Y-m-d H:i:s');
 
    $app->db->execute([
        '1',
        'Rubrik 1',
        'Test, fråga ett',
        $now
    ]);
 
    $app->db->execute([
        '1',
        'Rubrik 2',
        'test fråga två',
        $now
    ]);
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
