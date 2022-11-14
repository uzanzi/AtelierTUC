<?php

namespace iutnc\tucapp\control;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\view\UserView;
use iutnc\tucapp\model\Galeries;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Request;
use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\view\CreationGalerieView;
use Illuminate\Database\Capsule\Manager as DB;

class AjouterGalerieController extends AbstractController
{






  public function execute(): void
  {




    //   Router::executeRoute('default');


    if (TucAuthentification::connectedUser()) {


      $requeteHttp = new HttpRequest;
      if ($requeteHttp->method == 'GET' || isset($_SESSION['messageAjouterGalerie'])) {

        AbstractView::setAppTitle("Création Galerie");
        AbstractView::addStyleSheet('html/css/style.css');
        $render = new CreationGalerieView;
        $render->makePage();
        unset($_SESSION['messageAjouterGalerie']);

      } elseif ($requeteHttp->method == 'POST' and !empty($requeteHttp->post['Titre'])and !empty($requeteHttp->post['Description'])) {


          $galerie = new Galeries();
          $galerie->nom = $requeteHttp->post['Titre'];
          $galerie->description = $requeteHttp->post['Description'];
          $galerie->acces = $requeteHttp->post['Acces'];
          $galerie->save();

          $idUtilisateur = TucAuthentification::connectedUser();
          $galerie = Galeries::select()->orderBy("id", "desc")->first();
          DB::table('utilisateurs_galeries')->insert(['id_utilisateur' => "$idUtilisateur", 'id_galerie' => "$galerie->id", 'niveauAcces' => "100"]);
          Router::executeRoute('default');
        
        }
    }else {
      echo "<script>alert(\"Vous ne pouvez pas ajouter de galerie en étant déconnecté\")</script>";
      Router::executeRoute('accueil');
    }
  }
}
