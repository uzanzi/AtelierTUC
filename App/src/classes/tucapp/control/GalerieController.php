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

      $acces_utilisateur = 0;

      $requete_acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->first();

      if (isset($requete_acces_utilisateur->id)) {

        $acces_utilisateur = 10;

      }

      $requete_acces_utilisateur = $galerie->utilisateurs()->where('id_utilisateur', '=', TucAuthentification::connectedUser())->where('niveauAcces', '=', 100)->first();

      if (isset($requete_acces_utilisateur->id)) {

        $acces_utilisateur = 100;

      }
  
      $acces_galerie = $galerie->acces;


      $mots_clefs = $galerie->mots_clefs()->get();
      $partages = $galerie->utilisateurs()->get();
  
      if($acces_galerie  == 1 || $acces_utilisateur>=10){
        AbstractView::setAppTitle("$galerie->nom");
        AbstractView::addStyleSheet('html/css/style.css');
    
        $render = new GalerieView([$galerie, $photos, $galerie_utilisateur, $acces_utilisateur, $mots_clefs, $partages]);
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