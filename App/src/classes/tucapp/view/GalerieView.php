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

      $html .=" 
      </div>
    ";
    $html .= "<div class='photos'>
    <article class=\"article\">
    <a class=\"contenu_tweet\" href=\"index.php?action=afficher_photo&id=5402\">"
    ;
    foreach($photos as $photo){
    
      $html .= "
      <article class=\"article\">
      <a class=\"contenu_tweet\" href=\"index.php?action=afficher_photo&id=$photo->id\">";
        
            $image_jpg = "http://univ.tedbest.fr/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.jpg";
            $image_png = "http://univ.tedbest.fr/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.png";
            $image_jpeg = "http://univ.tedbest.fr/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.jpeg";
            $image_gif = "http://univ.tedbest.fr/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.gif";

            $test_image_jpg  = @get_headers($image_jpg );
            if($test_image_jpg[0] == 'HTTP/1.1 404 Not Found') {
                $exists_jpg = false;
            }
            else {
                $exists_jpg = true;
            }

            $test_image_png = @get_headers($image_png);
            if($test_image_png[0] == 'HTTP/1.1 404 Not Found') {
                $exists_png = false;
            }
            else {
                $exists_png = true;
            }

            $test_image_jpeg = @get_headers($image_jpeg);
            if($test_image_jpeg[0] == 'HTTP/1.1 404 Not Found') {
                $exists_jpeg = false;
            }
            else {
                $exists_jpeg = true;
            }

            $test_image_gif = @get_headers($image_gif);
            if($test_image_gif[0] == 'HTTP/1.1 404 Not Found') {
                $exists_gif = false;
            }
            else {
                $exists_gif = true;
            }
            if (isset($photo->id) AND $exists_jpg == true) {
              $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.jpg\" alt=\"$photo->titre\">";

            }elseif(isset($photo->id) AND $exists_png == true){
              $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.png\" alt=\"$photo->titre\">";

            }elseif(isset($photo->id) AND $exists_jpeg == true){
              $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.jpeg\" alt=\"$photo->titre\">";

            }elseif(isset($photo->id) AND $exists_gif == true){
              $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$photo->id.gif\" alt=\"$photo->titre\">";

            }else {
              $html.="<img src=\"https://picsum.photos/id/$photo->id/200/200\" alt=\"$photo->titre\">";
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