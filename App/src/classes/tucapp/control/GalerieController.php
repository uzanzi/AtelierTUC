<?php

namespace iutnc\tucapp\control;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\view\GalerieView;
use iutnc\tucapp\model\Utilisateurs;
use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;

class GalerieController extends AbstractController
{
  public function execute() : void {
  
    $requeteHttp = new HttpRequest();
    $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
    if($galerie != NULL){
      if (isset($requeteHttp->get['page'])) {
        $page = $requeteHttp->get['page'];
      } else {
        $page = 1;
      }
  
      $nbItemParPage=25;
      
      $offset = $nbItemParPage * ($page-1);
  
      $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
      
      $photos = $galerie->photos()->offset($offset)->limit($nbItemParPage)->get();
  
      $galerie_utilisateur = $galerie->utilisateurs()->first();

      $acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->first();
  
      $acces_galerie = $galerie->acces;
  
      if($acces_galerie  == 1 || isset($acces_utilisateur->id)){
        AbstractView::setAppTitle("$galerie->nom");
        AbstractView::addStyleSheet('html/css/style.css');
    
        $render = new GalerieView([$galerie, $photos, $galerie_utilisateur]);
        $render->makePage();
      }else{
        echo "<script>alert(\"Vous n'avez pas accès à cette galerie\")</script>";
        Router::executeRoute('default');
      }
    }else{
      echo "<script>alert(\"La galerie n'existe pas\")</script>";
      Router::executeRoute('default');
    }



    
    



  }
}