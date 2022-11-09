<?php
session_start();

ini_set('display_errors', '1');

error_reporting(E_ALL);

require_once 'vendor/autoload.php';

$config = parse_ini_file("conf/config.ini");

/* une instance de connexion  */
$db = new Illuminate\Database\Capsule\Manager();

$db->addConnection( $config ); /* configuration avec nos paramètres */
$db->setAsGlobal();            /* rendre la connexion visible dans tout le projet */
$db->bootEloquent();           /* établir la connexion */

// $router = new \iutnc\mf\router\Router();

// $router->addRoute('home', 'list_tweets', '\iutnc\tweeterapp\control\HomeController');
// $router->addRoute('view', 'view_tweet', '\iutnc\tweeterapp\control\TweetController');
// $router->addRoute('user', 'view_user_tweets', '\iutnc\tweeterapp\control\UserController');
// $router->addRoute('post', 'post_tweet', '\iutnc\tweeterapp\control\PostController', 100);
// $router->addRoute('signup', 'sign_up', '\iutnc\tweeterapp\control\SignupController');
// $router->addRoute('profil', 'view_profil', '\iutnc\tweeterapp\control\FollowingController', 100);
// $router->addRoute('login', 'log_in', '\iutnc\tweeterapp\control\LoginController');
// $router->addRoute('logout', 'log_out', '\iutnc\tweeterapp\control\LogoutController');

// $router->setDefaultRoute('list_tweets');

// $router->run();