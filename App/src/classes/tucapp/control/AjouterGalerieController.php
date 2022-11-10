<?php
namespace iutnc\tucapp\control;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\view\UserView;
use iutnc\tucapp\model\Galeries;
use Illuminate\Support\Facades\Request;
use iutnc\mf\control\AbstractController;
use iutnc\tucapp\view\CreationGalerieView ;
use PhpParser\Node\Stmt\TryCatch;

class AjouterGalerieController extends AbstractController{




    

  public function execute() : void {




    //   Router::executeRoute('default');

    


        $requeteHttp = new HttpRequest;
        if ($requeteHttp->method == 'GET'){

          AbstractView::setAppTitle("Création Galerie");
          AbstractView::addStyleSheet('html/css/style.css');
          $render = new CreationGalerieView ;
          $render->makePage();

        }
        elseif ($requeteHttp->method == 'POST') {
          try {

              $galerie = new Galeries();
              $galerie->nom = $requeteHttp->post['Titre'];
              $galerie->description = $requeteHttp->post['Description'];
              $galerie->acces = $requeteHttp->post['Acces'];
              $galerie->save();
            
          } catch (\Throwable $th) {
            echo( $th->getMessage());
          }


        }


      
  }
}