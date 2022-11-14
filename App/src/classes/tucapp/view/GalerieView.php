<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;

class GalerieView extends TucView
{
  public function render(): string {

    $router = new Router;
    

    $galerie = $this->data[0];
    $photos = $this->data[1];
    $galerie_utilisateur= $this->data[2];

    $requeteHttp = new HttpRequest();
    
    if (isset($requeteHttp->get['page'])) {
      $page = $requeteHttp->get['page'];
    } else {
      $page = 1;
    }





    $nbItemParPage=25;
    
    $offset = $nbItemParPage * $page + 1;

    $suiteImage = $galerie->photos()->offset($offset)->limit($nbItemParPage)->first();

    $urlSupprimerGalerie = $router->urlFor('supprimer_galerie', ['id'=>$requeteHttp->get['id']]);
    $urlAjouterGalerie = $router->urlFor('ajouter_photo', ['id'=>$requeteHttp->get['id']]);
    $html = "<div class='galerie'>";
    
    $html .= "
      <div class='topGalerie'>
      <h3> Description : $galerie->description </h3>
      <h2> Galerie : $galerie->nom </h2>";
      if (TucAuthentification::connectedUser() ){

        if (TucAuthentification::connectedUser()  === $galerie_utilisateur->id){
          
    $html .="
      <form class='test' action=\"$urlSupprimerGalerie\" method='post'>
        <input type='submit' class='boutonSupprimerGalerie' value='' name='test'>
      </form>
      <form class='test1' action=\"$urlAjouterGalerie\" method='post'>
      <input type='submit' class='boutonAjouterGalerie' value='' name='test'>
      </form>";
      }
    }
    $html .= "</div>";
    $html .= "<div class='photos'>";
    ;
    foreach($photos as $photo){
    
      $html .= "
      <article class=\"article\">
        <a class=\"contenu_tweet\" href=\"index.php?action=afficher_photo&id=$photo->id\">";
            
            if($photo->format == "api"){
              $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur/\" alt=\"$photo->titre\">";
            }else{
              $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.$photo->format\" alt=\"$photo->titre\">";
            }
            $html.="
        </a>
        </article>
      
    ";
    }
  


    $html .= "</div>";
    $html .= "</div>";
    if ($page>1) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page-1;
      $url = $router->urlFor('afficher_galerie', $params);
      $html .="<div><a href=\"$url\"><</a></div>";
    }
    if (isset($suiteImage->id)) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page+1;
      $url = $router->urlFor('afficher_galerie', $params);
      $html.="<div><a href=\"$url\">></a></div>";
    }


      return $html; 
  } 
}