<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Photos;
use iutnc\tucapp\view\PhotoView;
use Illuminate\Database\Capsule\Manager as DB;


class PhotoController extends AbstractController
{

  public function execute(): void
  {
    if (TucAuthentification::connectedUser()) {
      $requeteHttp = new HttpRequest();
      $idPhoto = $requeteHttp->get['idPhoto'];
      $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['idGalerie'])->first();
      if ($galerie) {
        $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();
        if (TucAuthentification::connectedUser() == isset($acces_utilisateur)) {
          if (DB::table('galeries_photos')->where('id_galerie', '=', $requeteHttp->get['idGalerie'])->where('id_photo', '=', $requeteHttp->get['idPhoto'])->first()) {
            $photo = Photos::select()->where("id", "=", $idPhoto)->first();
            $renderPhotoView = new PhotoView($photo);
            $renderPhotoView::setAppTitle("TUC • " . $photo->titre);
            $renderPhotoView::addStyleSheet('html/css/style.css');
            $renderPhotoView->makePage();
          }else {
            echo "<script>alert(\"La photo que vous voulez visualiser n'existe pas dans la galerie\")</script>";
            Router::executeRoute('accueil');
          }
        } else {
          echo "<script>alert(\"Vous n'avez pas les droits pour visualiser la photo\")</script>";
          Router::executeRoute('accueil');
        }
      } else {
        echo "<script>alert(\"La galerie n'existe pas\")</script>";
        Router::executeRoute('accueil');
      }
    } else {
      echo "<script>alert(\"Vous devez être connecté pour visualiser la photo\")</script>";
      Router::executeRoute('accueil');
    }
  }
}