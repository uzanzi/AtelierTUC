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

$router = new \iutnc\mf\router\Router();

$router->addRoute('accueil', 'presenter_galeries', '\iutnc\tucapp\control\AccueilController');
$router->addRoute('list_galerie', 'lister_galeries', '\iutnc\tucapp\control\ListeGaleriesController');
$router->addRoute('galerie', 'afficher_galerie', '\iutnc\tucapp\control\GalerieController');
$router->addRoute('ajout_galerie', 'ajouter_galerie', '\iutnc\tucapp\control\AjouterGalerieController');
$router->addRoute('suppression_galerie', 'supprimer_galerie', '\iutnc\tucapp\control\SupprimerGalerieController');
$router->addRoute('photo', 'afficher_photo', '\iutnc\tucapp\control\PhotoController');
$router->addRoute('ajout_photo', 'ajouter_photo', '\iutnc\tucapp\control\AjouterPhotoController');
$router->addRoute('suppression_photo', 'supprimer_photo', '\iutnc\tucapp\control\SupprimerPhotoController');
$router->addRoute('connexion', 'se_connecter', '\iutnc\tucapp\control\SeConnecterController');
$router->addRoute('inscription', 's_inscrire', '\iutnc\tucapp\control\SInscrireController');
$router->addRoute('deconnexion', 'se_deconnecter', '\iutnc\tucapp\control\SeDeconnecterController');
$router->addRoute('ajout_mot_clef', 'ajouter_mot_clef', '\iutnc\tucapp\control\AjouterMotClefController');
$router->addRoute('suppression_mot_clef', 'supprimer_mot_clef', '\iutnc\tucapp\control\SupprimerMotClefController');
$router->addRoute('ajout_utilisateur_partage', 'ajouter_utilisateur_partage', '\iutnc\tucapp\control\AjouterUtilisateurPartage');

$router->setDefaultRoute('presenter_galeries');


$router->run();


