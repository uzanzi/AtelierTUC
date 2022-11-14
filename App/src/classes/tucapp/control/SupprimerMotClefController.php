<?php

namespace iutnc\tucapp\control;

use Illuminate\Database\Capsule\Manager as DB;
use iutnc\mf\control\AbstractController;
use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Photos;
use iutnc\tucapp\view\SupprimerMotClefView;

class SupprimerMotClefController extends AbstractController
{

  public function execute(): void
  {
    $httpRequest = new HttpRequest();
    if (isset($httpRequest->get['idGalerie'])){
      $galerie = Galeries::select()->where('id', '=', $httpRequest->get['idGalerie'])->first();
    }else{
      $galerie = Galeries::select()->where('id', '=', $httpRequest->get['id'])->first();
    }

    if ($galerie){
      $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();

      if (TucAuthentification::connectedUser() && isset($acces_utilisateur)) {

        $datas = $httpRequest->get;

        unset($datas['action']);

        if ($httpRequest->method === 'GET') {

          $renderAjouterPhoto = new SupprimerMotClefView($datas);
          $renderAjouterPhoto->setAppTitle('Supprimer mot clef');
          $renderAjouterPhoto::addStyleSheet('html/css/style.css');
          $renderAjouterPhoto->makePage();

        } elseif ($httpRequest->method === 'POST') {

          if (isset($datas['idGalerie'])){
              if (Photos::select()->where('id', '=', $datas['id'])->first()){
                DB::table('mots_clefs_photos')->where('id_photo', '=', $datas['id'])->where('mot_clef', '=', $datas['motClef'])->delete();
                Router::executeRoute('photo');
              }else{
                echo "<script>alert(\"La photo n'a pas été trouvé\")</script>";
                Router::executeRoute('accueil');
              }
            }else{
              DB::table('mots_clefs_galeries')->where('id_galerie', '=', $datas['id'])->where('mot_clef', '=', $datas['motClef'])->delete();
              Router::executeRoute('galerie');
            }
        } else {
          echo "<script>alert(\"Une erreur est survenue\")</script>";
          Router::executeRoute('galerie');
        }
      } else {
        echo "<script>alert(\"Vous n'avez pas le droit de supprimer des mots clefs car vous êtes pas connecté\")</script>";
        Router::executeRoute('accueil');
      }
    } else {
      echo "<script>alert(\"La galerie que vous recherchez n'existe pas\")</script>";
      Router::executeRoute('accueil');
    }
  }
}