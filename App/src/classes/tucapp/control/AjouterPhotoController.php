<?php


namespace iutnc\tucapp\control;


use Illuminate\Database\Capsule\Manager as DB;
use iutnc\mf\control\AbstractController;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Photos;
use iutnc\tucapp\view\AjouterPhotoView;

class AjouterPhotoController extends AbstractController
{
  public function execute(): void
  {
    if (TucAuthentification::connectedUser()) {
      $httpRequest = new HttpRequest();
      $idGalerie = $httpRequest->get['id'];
      if ($httpRequest->method === 'GET') {
        $ajouterPhoto = new AjouterPhotoView($idGalerie); // récupère l'id de la galerie quand on clique sur une photo
        $ajouterPhoto->setAppTitle('Ajouter photo');
        $ajouterPhoto->makePage();
      } elseif ($httpRequest->method === 'POST') {
          $galerie = Galeries::select()->where("id", "=", $idGalerie)->first();
          $erreur = 0;
          if ($galerie){
            $nbPhotos = count($_FILES['photo']['name']);
            for ($i = 0; $i < $nbPhotos; $i++){
            $statement = DB::select("show table status like 'photos'");
            $idPhoto = $statement[0]->Auto_increment;
            $dossier = "src/classes/tucapp/photo/";
            $nomPhoto = $_FILES["photo"]["name"][$i];
            $extension = strtolower(pathinfo($nomPhoto, PATHINFO_EXTENSION));
            $_FILES["photo"]["name"][$i] = "$idPhoto" . "." . $extension;
            $chemin = $dossier . basename($_FILES["photo"]["name"][$i]);
            if ($_FILES["photo"]["size"][$i] > 500000 || $extension != "jpg" && $extension != "png" && $extension != "jpeg" && $extension != "gif") {
              $erreur = $erreur + 1;
            } else {
              $donneesPhoto = getimagesize($_FILES['photo']['tmp_name'][$i]);
              if (move_uploaded_file($_FILES["photo"]["tmp_name"][$i], $chemin)) {
                $photo = new Photos();
                $photo->titre = $httpRequest->post['titre'];
                $photo->format = $extension;
                $photo->hauteur = $donneesPhoto[0];
                $photo->largeur = $donneesPhoto[1];
                $photo->save();
                DB::table('galeries_photos')->insert(['id_galerie' => "$idGalerie", 'id_photo' => "$idPhoto"]);
              }
            }
          }
        }else{
            $erreur = $erreur + 1;
          }
      }
    }
  }
}