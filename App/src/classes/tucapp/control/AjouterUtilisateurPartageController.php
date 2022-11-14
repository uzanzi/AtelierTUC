<?php

namespace iutnc\tucapp\control;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Utilisateurs;

use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use Illuminate\Database\Capsule\Manager as DB;
use iutnc\tucapp\view\AjouterUtilisateurPartageView;

class AjouterUtilisateurPartageController extends AbstractController
{
  public function execute(): void
  {

    $requeteHttp = new HttpRequest;
    $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
    $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();
    if (TucAuthentification::connectedUser() and isset($acces_utilisateur)) {

      if ($requeteHttp->method == 'GET' || isset($_SESSION['messageUtilisateurPartage'])) {

        $idGalerie = $requeteHttp->get['id'];
        AbstractView::setAppTitle("Ajouter Utilisateur Partager");
        AbstractView::addStyleSheet('html/css/style.css');
        $render = new AjouterUtilisateurPartageView($idGalerie);
        $render->makePage();
        unset($_SESSION['messageUtilisateurPartage']);

      } elseif ($requeteHttp->method == 'POST' and !empty($requeteHttp->post['Mail_utilisateur'])) {

        $idGalerie = $requeteHttp->get['id'];
        $utilisateur_mail = Utilisateurs::select()->where('mail', '=', $requeteHttp->post['Mail_utilisateur'])->first();

        
        if (isset($utilisateur_mail->id)) {
          DB::table('utilisateurs_galeries')->insert(['id_utilisateur' => "$utilisateur_mail->id", 'id_galerie' => "$idGalerie", 'niveauAcces' => "10"]);
          Router::executeRoute('galerie');
        } else {
          $_SESSION['messageUtilisateurPartage'] = "Vous n'avez pas ajouté un mail valide";
          Router::executeRoute('ajout_utilisateur_partage');
        }
        
      }
    } else {
      echo "<script>alert(\"Vous ne pouvez pas partager cette galerie à un autre utilisateur\")</script>";
      Router::executeRoute('galerie');
    }
  }
}
