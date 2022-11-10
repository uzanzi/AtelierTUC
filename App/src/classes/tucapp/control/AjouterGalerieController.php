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

class AjouterGalerieController extends AbstractController{




    

  public function execute() : void {




    //   Router::executeRoute('default');

    
        AbstractView::setAppTitle("Création Galerie");
        AbstractView::addStyleSheet('html/css/style.css');
        $render = new CreationGalerieView ;
        $render->makePage();

        $requeteHttp = new HttpRequest;

        $galerie = new Galeries();
        $galerie->nom = $requeteHttp->post['Titre'];
        $galerie->description = $requeteHttp->post['Description'];
        $galerie->access = 1;
        $galerie->save();


      
  }
}