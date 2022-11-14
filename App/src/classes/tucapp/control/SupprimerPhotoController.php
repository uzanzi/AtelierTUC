<?php

namespace iutnc\tucapp\control;
use Illuminate\Database\Capsule\Manager as DB;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;

use iutnc\tucapp\model\Galeries;

use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Photos;
use iutnc\mf\router\Router;
use iutnc\tucapp\view\SupprimerPhotoView;


class SupprimerPhotoController extends AbstractController{


  public function execute() : void {

    if (TucAuthentification::connectedUser()){

    $requeteHttp = new HttpRequest;
    $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['idGalerie'])->first();
    $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();
    if (TucAuthentification::connectedUser() == isset($acces_utilisateur)){
        unset($_POST);
        if ($requeteHttp->method == 'GET'){
          $idGalerie = $galerie->id;
          $photo = Photos::select()->where('id', '=', $requeteHttp->get['idPhoto'])->first();
          $idPhoto = $photo->id;
          $render = new SupprimerPhotoView([$idGalerie, $idPhoto]);
          $render::setAppTitle('Supprimer photo');
          $render::addStyleSheet('html/css/style.css');
          $render->makePage();
        }
        elseif ($requeteHttp->method == 'POST') {
          DB::table('photos')->where('id',$requeteHttp->get['idPhoto'])->delete();
          DB::table('galeries_photos')->where('id_galerie', $requeteHttp->get['idGalerie'])->where('id_photo', $requeteHttp->get['idPhoto'])->delete();
          Router::executeRoute('accueil');
        }
      }else{
        echo "<script>alert(\"Vous n'avez pas les droits pour supprimer cette galerie\")</script>";
      Router::executeRoute('accueil');
      }
    }else{
      echo "<script>alert(\"Vous n'avez pas les droits pour supprimer cette galerie\")</script>";
      Router::executeRoute('accueil');
    }
  }
}