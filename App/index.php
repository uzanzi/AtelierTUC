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

$router->addRoute('accueil', 'presenter_galeries', '\iutnc\tweeterapp\control\AccueilController');
$router->addRoute('list_galerie', 'lister_galeries', '\iutnc\tweeterapp\control\ListeGaleriesController');
$router->addRoute('galerie', 'afficher_galerie', '\iutnc\tweeterapp\control\GalerieController');
$router->addRoute('ajout_galerie', 'ajouter_galerie', '\iutnc\tweeterapp\control\AjouterGalerieController');
$router->addRoute('suppression_galerie', 'supprimer_galerie', '\iutnc\tweeterapp\control\SupprimerGalerieController');
$router->addRoute('photo', 'afficher_photo', '\iutnc\tweeterapp\control\PhotoController');
$router->addRoute('ajout_photo', 'ajouter_photo', '\iutnc\tweeterapp\control\AjouterPhotoController');
$router->addRoute('suppression_photo', 'supprimer_photo', '\iutnc\tweeterapp\control\SupprimerPhotoController');
$router->addRoute('connexion', 'se_connecter', '\iutnc\tweeterapp\control\SeConnecterController');
$router->addRoute('inscription', 's_inscrire', '\iutnc\tweeterapp\control\SInscrireController');
$router->addRoute('deconnexion', 'se_deconnecter', '\iutnc\tweeterapp\control\SeDeconnecterController');
$router->addRoute('ajout_mot_clef_sur_photo', 'ajouter_mot_clef_sur_photo', '\iutnc\tweeterapp\control\AjouterMotClefSurGalerieController');
$router->addRoute('suppression_mot_clef_sur_photo', 'supprimer_mot_clef_sur_photo', '\iutnc\tweeterapp\control\AjouterMotClefSurPhotoController');
$router->addRoute('ajout_mot_clef_sur_galerie', 'ajouter_mot_clef_sur_galerie', '\iutnc\tweeterapp\control\SupprimerMotClefSurGalerieController');
$router->addRoute('suppression_mot_clef_sur_galerie', 'supprimer_mot_clef_sur_galerie', '\iutnc\tweeterapp\control\SupprimerMotClefSurPhotoController');



$router->setDefaultRoute('accueil');

$router->run();