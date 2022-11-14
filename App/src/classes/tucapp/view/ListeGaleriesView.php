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

    $nbItemParPage=24;
    
    $offset = $nbItemParPage * $page + 1;

    $urlHome = $router->urlFor('accueil');


    if (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='publiques') {
      
      $suiteGalerie = Galeries::select()->where('acces', '=', 1)->offset($offset)->first();

    } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='partagees') {

      $user = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
      $suiteGalerie = $user->galeries()->where('niveauAcces', '<', 100)->offset($offset)->first();

    } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='privees') {

      $user = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
      $suiteGalerie = $user->galeries()->where('niveauAcces', '=', 100)->offset($offset)->first();

    }

    $galeries = $this->data;
    $requeteHttp = new HttpRequest;
    $router = new Router;
    $html = "
    <div class=\"lister_galeries\">
      <header>
        <h2>
          <a href=\"$urlHome\" class=\"material-symbols-outlined retour\">
            arrow_back
          </a>";

        if (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='publiques') {

          $html.="Galeries Publiques";

        } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='partagees') {

          $html.="Galeries Partagées avec vous";

        } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='privees') {

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
      <article>
        <a class=\"contenu_tweet\" href=\"$urlGalerie\">";
        if (isset($photo->id)) {
          if($photo->format == "api"){
            $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur/\" alt=\"$galerie->nom\">";
          }else{
            $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.$photo->format\" alt=\"$galerie->nom\">";
          }
        } else {
          $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/no-photo.png\" alt=\"$galerie->nom\">";
        }
        
          $html.="<h3>{$galerie->nom}</h3>
        </a>
      </article>" ;
    }

    $html .= "</main><footer class=\"pagination\">";

    if ($page>1) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page-1;
      $url = $router->urlFor('lister_galeries', $params);
      $html.="<a href=\"$url\" class=\"material-symbols-outlined\">chevron_left</a>";
    }

    if (isset($suiteGalerie->id)) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page+1;
      $url = $router->urlFor('lister_galeries', $params);
      $html.="<a href=\"$url\" class=\"material-symbols-outlined\">chevron_right</a>";
    }

    $html .= "</footer></div>";

    return $html;
  } 
}
