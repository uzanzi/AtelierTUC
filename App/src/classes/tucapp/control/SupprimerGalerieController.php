<?php

namespace iutnc\tucapp\control;
use Illuminate\Database\Capsule\Manager as DB;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;

use iutnc\tucapp\model\Galeries;

use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\view\SupprimerGalerieView;
use iutnc\mf\router\Router;


class SupprimerGalerieController extends AbstractController{




    

  public function execute() : void {

    if (TucAuthentification::connectedUser()){


    //   Router::executeRoute('default');
    $requeteHttp = new HttpRequest;
    $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
    $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();
        


    if (TucAuthentification::connectedUser() AND isset($acces_utilisateur)){
    
          
          $idGalerie = $requeteHttp->get['id'];
          $galerie = new Galeries();
          $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
          $nom = $galerie->nom;
          
          if ($requeteHttp->method == 'GET'){

            AbstractView::setAppTitle("Supprimer Galerie");
            AbstractView::addStyleSheet('html/css/style.css');
            
            
            $render = new SupprimerGalerieView([$nom,$idGalerie]) ;
            $render->makePage();
  
  
          }
          elseif ($requeteHttp->method == 'POST') {
            try {
              $requeteHttp = new HttpRequest ;
              $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
              $galerie_utilisateur = $galerie->utilisateurs()->first();

              
              $requeteHttp = new HttpRequest ;
              $idGalerie = $requeteHttp->get['id'];
          
              DB::table('galeries')->where('id',$idGalerie)->delete();
              DB::table('galeries_photos')->where('id_galerie',$idGalerie)->delete(); 

              Router::executeRoute('accueil');



  
              
            } catch (\Throwable $th) {
              echo( $th->getMessage());
            }
  
        }
        

        }else{
          echo "<script>alert(\"Vous n'avez pas les droits pour supprimer cette galerie\")</script>";
        Router::executeRoute('galerie');
        }


    }else{
      echo "<script>alert(\"Vous n'avez pas les droits pour supprimer cette galerie\")</script>";
      Router::executeRoute('galerie');
    }
  }          
}