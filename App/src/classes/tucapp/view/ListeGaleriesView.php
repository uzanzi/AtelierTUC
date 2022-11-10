<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Utilisateurs;

class ListeGaleriesView extends TucView {

  public function render(): string {

    $requeteHttp = new HttpRequest;
    $router = new Router;

    if (isset($requeteHttp->get['page'])) {
      $page = $requeteHttp->get['page'];
    } else {
      $page = 1;
    }

    $nbItemParPage=36;
    
    $offset = $nbItemParPage * $page + 1;

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

        if (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='publiques') {
      
          $suiteGalerie = Galeries::select()->where('acces', '=', 1)->offset($offset)->first();

          $html.="Galeries Publiques";

        } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='partagees') {

          $user = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
          $suiteGalerie = $user->galeries()->where('niveauAcces', '<', 100)->offset($offset)->first();

          $html.="Galeries Partagées avec vous";

        } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='privees') {

          $user = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
          $suiteGalerie = $user->galeries()->where('niveauAcces', '=', 100)->offset($offset)->first();

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
        <a class=\"contenu_tweet\" href=\"$urlGalerie\">";
        if (isset($photo->id)) {
          $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur\" alt=\"$galerie->nom\">";
        } else {
          $html.="<img src=\"https://picsum.photos/id/1000/200/200\" alt=\"$galerie->nom\">";
        }
        
          $html.="<h3>{$galerie->nom}</h3>
        </a>
      </article>" ;
    }

    $html .= "</main><footer>";

    if ($page>1) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page-1;
      $url = $router->urlFor('lister_galeries', $params);
      $html.="<div><a href=\"$url\"><</a></div>";
    }

    if (isset($suiteGalerie->id)) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page+1;
      $url = $router->urlFor('lister_galeries', $params);
      $html.="<div><a href=\"$url\">></a></div>";
    }

    $html .= "</footer></div>";

    return $html;
  } 
}
