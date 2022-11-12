<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\tucapp\auth\TucAuthentification;

class AccueilView extends TucView
{
  public function render(): string {

    $galeriesPubliques=$this->data['galeriesPubliques'];

    $router = new Router;

    $urlGaleriesPrivees= $router->urlFor('lister_galeries', ['acces' => 'privees']);
    $urlGaleriesPartagees= $router->urlFor('lister_galeries', ['acces' => 'partagees']);
    $urlGaleriesPubliques= $router->urlFor('lister_galeries', ['acces' => 'publiques']);
    
    $html = "<div class=\"accueil\">";

    if (TucAuthentification::connectedUser()) {

    $galeriesPrivees=$this->data['galeriesPrivees'];
    $galeriesPartagees=$this->data['galeriesPartagees'];

      $html.= "

      <section id=\"ajouter_galeries\">
        <header>
          <h2><a href=\"/AtelierTUC/App/?action=ajouter_galerie\">Ajouter une galeries<span class=\"material-symbols-outlined\">chevron_right</span></a></h2>
        </header>
        <main>
        <article>
          $html.=\"<img src=\"image_app/plus.png\" alt=\"ajouter une galerie\">";";
        </main>*
      </section>";

      $html.= "
      <div class=\"presenter_galeries\">
        <section id=\"galeriesPrivees\">
          <header>
            <h2><a href=\"$urlGaleriesPrivees\">Vos galeries<span class=\"material-symbols-outlined\">chevron_right</span></a></h2>
          </header>
          <main>
          ";

          foreach ($galeriesPrivees as $galerie){
            
            $urlGalerie = $router->urlFor('afficher_galerie', ['id'=>$galerie->id]);

            $photo = $galerie->photos()->first();

            $html .= "
              <article>
                <a class=\"contenu_tweet\" href=\"$urlGalerie\">";

                if (isset($photo->id)) {
                  $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur\" alt=\"$galerie->nom\">";
                } else {
                  $html.="<img src=\"https://picsum.photos/id/1000/200/200\" alt=\"$galerie->nom\">";
                }
                  $html.="<h3>{$galerie->nom}</h3>
                </a>
              </article>";
          }
      $html .= "</main></section>";


      $html.= "
        <section id=\"galeriesPartagees\">
          <header>
            <h2><a href=\"$urlGaleriesPartagees\">Galeries partagées avec vous<span class=\"material-symbols-outlined\">chevron_right</span></a></h2>
          </header>
          <main>
          ";

          foreach ($galeriesPartagees as $galerie){
            
            $urlGalerie = $router->urlFor('afficher_galerie', ['id'=>$galerie->id]);

            $photo = $galerie->photos()->first();

            $html .= "
              <article>
                <a class=\"contenu_tweet\" href=\"$urlGalerie\">";

                if (isset($photo->id)) {
                  $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur\" alt=\"$galerie->nom\">";
                } else {
                  $html.="<img src=\"https://picsum.photos/id/1000/200/200\" alt=\"$galerie->nom\">";
                }
                  $html.="<h3>{$galerie->nom}</h3>
                </a>
              </article>";
          }
      $html .= "</main></section>";

    }


    $html.= "
    <section id=\"galeriesPubliques\">
      <header>
        <h2><a href=\"$urlGaleriesPubliques\">Galeries publiques<span class=\"material-symbols-outlined\">chevron_right</span></a></h2>
      </header>
      <main>
      ";

      foreach ($galeriesPubliques as $galerie){
        
        $urlGalerie = $router->urlFor('afficher_galerie', ['id'=>$galerie->id]);

        $photo = $galerie->photos()->first();

        $html .= "
          <article>
            <a class=\"contenu_tweet\" href=\"$urlGalerie\">";

            if (isset($photo->id)) {
              $html.="<img src=\"https://picsum.photos/id/$photo->id/$photo->largeur/$photo->hauteur\" alt=\"$galerie->nom\">";
            } else {
              $html.="<img src=\"https://picsum.photos/id/1000/200/200\" alt=\"$galerie->nom\">";
            }
              $html.="<h3>{$galerie->nom}</h3>
            </a>
          </article>";
      }
  $html .= "</main></section>";



      
      $html .= "</div>";

      return $html;
      
    } 
}