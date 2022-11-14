<?php

namespace iutnc\tucapp\control;
use Illuminate\Database\Capsule\Manager as DB;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\model\Galeries;
use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\mf\router\Router;
use iutnc\tucapp\view\SupprimerPhotoView;


class SupprimerPhotoController extends AbstractController{


  public function execute() : void {

    if (TucAuthentification::connectedUser()){
    $requeteHttp = new HttpRequest;
    $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['idGalerie'])->first();
    if ($galerie){
      $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();
      if (TucAuthentification::connectedUser() == isset($acces_utilisateur)){
        $photo = DB::table('galeries_photos')->where('id_galerie', '=', $requeteHttp->get['idGalerie'])->where('id_photo', '=', $requeteHttp->get['idPhoto'])->first();
        if ($photo){
          $idGalerie = $galerie->id;
          $idPhoto = $photo->id;
          unset($_POST);
          if ($requeteHttp->method == 'GET'){
            $render = new SupprimerPhotoView([$idGalerie, $idPhoto]);
            $render::setAppTitle('Supprimer photo');
            $render::addStyleSheet('html/css/style.css');
            $render->makePage();
          }
          elseif ($requeteHttp->method == 'POST') {
            DB::table('galeries_photos')->where('id_galerie', "=", $idGalerie)->where('id_photo', '=', $idPhoto)->delete();
            if (count(DB::table('galeries_photos')->where('id_photo', '=', $idPhoto)->get()) === 0){
              DB::table('photos')->where('id',$requeteHttp->get['idPhoto'])->delete();
            }
            Router::executeRoute('afficher_galerie');
          }
        }else{
          echo "<script>alert(\"Un problème est survenue : la photo que vous voulez supprimer n'existe pas dans la galerie.\")</script>";
          Router::executeRoute('accueil');
        }
      }else{
        echo "<script>alert(\"Un problème est survenue : vous n'avez pas les droits pour supprimer cette galerie\")</script>";
        Router::executeRoute('accueil');
      }
    }else{
      echo "<script>alert(\"Un problème est survenue : la galerie n'existe pas.\")</script>";
      Router::executeRoute('accueil');
    }
    }else{
      echo "<script>alert(\"Un problème est survenue : vous devez être connecté pour réaliser une action comme celle-ci.\")</script>";
      Router::executeRoute('accueil');
    }
  }
}