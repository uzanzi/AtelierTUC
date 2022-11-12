<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;

class GalerieView extends TucView
{
  public function render(): string {

    $router = new Router;

    $galerie = $this->data[0];
    $photos = $this->data[1];

    $requeteHttp = new HttpRequest();
    
    if (isset($requeteHttp->get['page'])) {
      $page = $requeteHttp->get['page'];
    } else {
      $page = 1;
    }

    $nbItemParPage=25;
    
    $offset = $nbItemParPage * $page + 1;

    $suiteImage = $galerie->photos()->offset($offset)->limit($nbItemParPage)->first();
  



   






    $html = "<div class='galerie'>";
    
    $html .= "
      <h2> Galerie : $galerie->nom </h2>
      
    ";
    $html .= "<div class='photos'>";

    foreach($photos as $photo){
    
      $html .= "
        <article class=\"article\">
            <a class=\"contenu_tweet\" href=\"index.php?action=afficher_photo&id=$photo->id\">";
    
            if (isset($photo->id)) {
              $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur\" alt=\"$photo->titre\">";
            
            } else {
              $html.="<img src=\"https://picsum.photos/id/1000/200/200\" alt=\"$photo->titre\">";
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