<?php

namespace iutnc\tucapp\control;

use Illuminate\Database\Capsule\Manager as DB;
use iutnc\mf\control\AbstractController;
use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Mots_Clefs;
use iutnc\tucapp\view\AjouterMotClefView;

class AjouterMotClefController extends AbstractController
{

  public function execute(): void
  {

    
    $httpRequest = new HttpRequest();
    if (!isset($httpRequest->get['idGalerie'])) {
      
      $galerie = Galeries::select()->where('id', '=', $httpRequest->get['id'])->first();
      
    } else {
      
      $galerie = Galeries::select()->where('id', '=', $httpRequest->get['idGalerie'])->first();
      
    }
    $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();
    
    if (TucAuthentification::connectedUser() and isset($acces_utilisateur)) {
      
      $datas = $httpRequest->get;
      
      unset($datas['action']);
      
      if ($httpRequest->method === 'GET') {

        $renderAjouterPhoto = new AjouterMotClefView($datas);
        $renderAjouterPhoto->setAppTitle('Ajouter mot clef');
        $renderAjouterPhoto::addStyleSheet('html/css/style.css');
        $renderAjouterPhoto->makePage();

      } elseif ($httpRequest->method === 'POST' && isset($httpRequest->get['id']) && isset($httpRequest->post['motClef'])) {

        $motclef = Mots_Clefs::select()->where('mot_clef', '=', $httpRequest->post['motClef'])->first();
        
        if (!isset($motclef->mot_clef))
        {
          
          $motclef = new Mots_Clefs();
          $motclef->mot_clef = $httpRequest->post['motClef'];
          $motclef->save();

        }

        if (!isset($httpRequest->get['idGalerie'])) {

          $id = $httpRequest->get['id'];

          DB::table('mots_clefs_galeries')->insert(['mot_clef' => "$motclef->mot_clef", 'id_galerie' => "$id"]);
          Router::executeRoute('galerie');

        } else {

          DB::table('mots_clefs_photos')->insert(['mot_clef' => "$motclef->mot_clef", 'id_photo' => "$$httpRequest->get['id']"]);
          Router::executeRoute('photo');

        }

      } else {
        echo "<script>alert(\"Une erreur est survenue\")</script>";
        Router::executeRoute('galerie');
      }
    } else {
      echo "<script>alert(\"Vous n'avez le droit d'ajouter des mots clefs à cet élément\")</script>";
      Router::executeRoute('accueil');
    }
  }
}


// if (isset($httpRequest->get['idPhoto'])) {
//   $photo = Photos::select()->where('id', '=', $httpRequest->get['idPhoto'])->first();
// }