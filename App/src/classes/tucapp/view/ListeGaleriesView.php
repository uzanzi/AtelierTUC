<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;

class ListeGaleriesView extends TucView {

  public function render(): string {

    $galeries = $this->data;
    $requeteHttp = new HttpRequest;
    $router = new Router;
    $html = "
    <div class=\"liste_galeries\">
      <header>
        <div><a href=\"javascript:history.back()\">
          <span class=\"material-symbols-outlined\">
            arrow_back
          </span>
        </a></div>
        <h2>";

        if (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='publique') {
        $html.="Galeries Publiques";
        } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='partagee') {
        $html.="Galeries Partagées avec vous";
        } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='privee') {
        $html.="Vos Galeries";
        }
        
        $html.="
        </h2>
      </header>
      <main>
    ";

    foreach ($galeries as $galerie){
      
      $urlGalerie = $router->urlFor('afficher_galerie', ['id'=>$galerie->id]);

      $photo = $galerie->photos()->first();

      $html .= "
      <article class=\"galerie\">
        <a class=\"contenu_tweet\" href=\"$urlGalerie\">
          <img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur\" alt=\"$galerie->nom\">
          <h3>{$galerie->nom}</h3>
        </a>
      </article>" ;
    }

    $html .= "</main></div>";

    return $html;
  } 
}
