<?php


namespace iutnc\tucapp\control;


use iutnc\mf\router\Router;
use iutnc\tucapp\model\Photos;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\view\AjouterPhotoView;
use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use Illuminate\Database\Capsule\Manager as DB;

class AjouterPhotoController extends AbstractController
{
  public function execute(): void
  {
    $httpRequest = new HttpRequest();
    $galerie = Galeries::select()->where('id', '=', $httpRequest->get['id'])->first();
    $galerie_utilisateur = $galerie->utilisateurs()->first();

    if (TucAuthentification::connectedUser() AND TucAuthentification::connectedUser() == $galerie_utilisateur->id){
      
      $idGalerie = $httpRequest->get['id'];
      if ($httpRequest->method === 'GET') {
        $ajouterPhoto = new AjouterPhotoView($idGalerie); // récupère l'id de la galerie quand on clique sur une photo
        
        AbstractView::setAppTitle("Ajouter Photo");
        AbstractView::addStyleSheet('html/css/style.css');
        $ajouterPhoto->setAppTitle('Ajouter photo');
        $ajouterPhoto->makePage();



      } elseif ($httpRequest->method === 'POST'AND isset($_POST['titre']) AND isset($_FILES["photo"]["name"])) {
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
                Router::executeRoute('galerie');
              }
            }
          }
        }else{
            $erreur = $erreur + 1;
          }
      }else{
        echo "<script>alert(\"Vous n'avez pas renseigner de nom d'image ou vous n'avez pas ajouté d'image\")</script>";
        Router::executeRoute('galerie');
      }
    }else{
        echo "<script>alert(\"Vous n'avez le droit d'ajouter des images dans cette galerie\")</script>";
        Router::executeRoute('accueil');
    }
  }
}