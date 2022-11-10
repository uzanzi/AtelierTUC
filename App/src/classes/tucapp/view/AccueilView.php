<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\tucapp\auth\TucAuthentification;

class AccueilView extends TucView
{
  public function render(): string {

    $galeriesPubliques=$this->data['galeriesPubliques'];

    $router = new Router;
    
    $html = "<div class=\"accueil\">";

    if (TucAuthentification::connectedUser()) {

    $galeriesPrivees=$this->data['galeriesPrivees'];
    $galeriesPartagees=$this->data['galeriesPartagees'];

      $html.= "
        <section id=\"galeriesPrivees\">
          <header>
            <h2>Vos galeries</h2>
          </header>
          <main>
          ";

          foreach ($galeriesPrivees as $galerie){
            
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
              </article>
            </section>";
          }
      $html .= "</main>";


      $html.= "
        <section id=\"galeriesPartagees\">
          <header>
            <h2>Galeries partagées avec vous</h2>
          </header>
          <main>
          ";

          foreach ($galeriesPartagees as $galerie){
            
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
              </article>
            </section>";
          }
      $html .= "</main>";

    }


    $html.= "
    <section id=\"galeriesPubliques\">
      <header>
        <h2>Galeries publiques</h2>
      </header>
      <main>
      ";

      foreach ($galeriesPubliques as $galerie){
        
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
          </article>
        </section>";
      }
  $html .= "</main>";



      
      $html .= "</div>";

      return $html;
      
    } 
}