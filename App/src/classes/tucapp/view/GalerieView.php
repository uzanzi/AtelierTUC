<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;

class GalerieView extends TucView
{
  public function render(): string
  {

    $router = new Router;


    $galerie = $this->data[0];
    $photos = $this->data[1];
    $galerie_utilisateur = $this->data[2];

    $requeteHttp = new HttpRequest();

    if (isset($requeteHttp->get['page'])) {
      $page = $requeteHttp->get['page'];
    } else {
      $page = 1;
    }





    $nbItemParPage = 25;

    $offset = $nbItemParPage * $page + 1;

    $suiteImage = $galerie->photos()->offset($offset)->limit($nbItemParPage)->first();

    $urlSupprimerGalerie = $router->urlFor('supprimer_galerie', ['id' => $requeteHttp->get['id']]);
    $urlAjouterGalerie = $router->urlFor('ajouter_photo', ['id' => $requeteHttp->get['id']]);
    $urlPartageGalerie = $router->urlFor('ajouter_utilisateur_partage', ['id' => $requeteHttp->get['id']]);
    $urlHome = $router->urlFor('accueil');




    $html = "<div class=\"galerie\">
    <header class=\"topGalerie\">
      <h2>
        <a href=\"$urlHome\" class=\"material-symbols-outlined retour\">
          arrow_back
        </a>
        <span>$galerie->nom</span>";

    if (TucAuthentification::connectedUser()) {

      if (TucAuthentification::connectedUser()  === $galerie_utilisateur->id) {

        $html .= "<a href=\"$urlAjouterGalerie\" class=\"material-symbols-outlined retour\">
          add_photo_alternate
        </a>
        <a href=\"$urlPartageGalerie\" class=\"material-symbols-outlined retour\">
          person_add
        </a>
        <a href=\"$urlSupprimerGalerie\" class=\"material-symbols-outlined retour\">
          delete
        </a>";
      }
    }
    $html .= "</h2>
    <p> Description : $galerie->description </p>
    </header>";

    $html .= "<div class='photos'>";;
    foreach ($photos as $photo) {

      $urlPhoto = $router->urlFor('afficher_photo', ['id' => $photo->id, 'idGalerie' => $galerie->id]);

      $html .= "
      <article class=\"article\">
        <a class=\"contenu_tweet\" href=\"$urlPhoto\">";

      if ($photo->format == "api") {
        $html .= "<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur/\" alt=\"$photo->titre\">";
      } else {
        $html .= "<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.$photo->format\" alt=\"$photo->titre\">";
      }
      $html .= "
        </a>
        </article>
      
    ";
    }



    $html .= "</div>";

    $html .= "<footer class=\"pagination\">";

    if ($page>1) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page-1;
      $url = $router->urlFor('afficher_galerie', $params);
      $html.="<a href=\"$url\" class=\"material-symbols-outlined\">chevron_left</a>";
    }

    if (isset($suiteImage->id)) {
      $params = $requeteHttp->get;
      unset($params['action']);
      $params['page']=$page+1;
      $url = $router->urlFor('afficher_galerie', $params);
      $html.="<a href=\"$url\" class=\"material-symbols-outlined\">chevron_right</a>";
    }

    $html .= "</footer></div>";


    return $html;
  }
}
