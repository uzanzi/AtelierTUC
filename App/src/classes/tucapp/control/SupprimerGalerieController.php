<?php
namespace iutnc\tucapp\control;

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

        
        $requeteHttp = new HttpRequest ;

        $galerie = new Galeries();
        $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
        $nom = $galerie->nom;
        
        unset($_POST);
        $requeteHttp = new HttpRequest;
        if ($requeteHttp->method == 'GET'){

          AbstractView::setAppTitle("Supprimer Galerie");
          AbstractView::addStyleSheet('html/css/formulaireCreationGalerie.css');
          
          
          $render = new SupprimerGalerieView([$nom]) ;
          $render->makePage();
          echo(TucAuthentification::connectedUser());


        }
        elseif ($requeteHttp->method == 'POST') {
          try {
            

                if(isset($_POST['submitSupprimerGalerie'])){
                    echo(TucAuthentification::connectedUser());
                }

            
          } catch (\Throwable $th) {
            echo( $th->getMessage());
          }


        }


    }else{
        Router::executeRoute('default');
    }
  }          
}