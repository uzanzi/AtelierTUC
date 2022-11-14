<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;

class PhotoView extends TucView
{

  public function render(): string {
    $data = $this->data;
    $router = new Router;
    $requete=new HttpRequest;
    $html = <<<EOT
    <div class="afficher_photo">
      <section id="photo">
        <a href="javascript:history.back()" class="material-symbols-outlined">arrow_back</a>
    EOT;
        if($data[0]->format == "api"){
          $html.="<img src=\"https://picsum.photos/id/{$data[0]->id}/{$data[0]->largeur}/{$data[0]->hauteur}/\" alt=\"{$data[0]->titre}\">";
        }else{
          $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/{$data[0]->id}.{$data[0]->format}\" alt=\"{$data[0]->titre}\">";
        }

        $urlPhoto = $router->urlFor('supprimer_photo', ['idPhoto' => $requete->get['id'], 'idGalerie' => $requete->get['idGalerie']]);

    $html.= <<<EOT
    <div>
      <section id="data-photo">
        <h2>
          <span>{$data[0]->titre}</span>
          <a href="$urlPhoto" class="material-symbols-outlined">
            delete
          </a>
        </h2>
        <p>Ajoutée le {$data[0]->date_ajout}</p>
        <p>Format : {$data[0]->format}</p>
        <p>Hauteur : {$data[0]->hauteur}</p>
        <p>Largeur : {$data[0]->largeur}</p>
        <p>Mots clefs :  </p>
        <ul>
 EOT;
          foreach ($data[1] as $mot_clef){
            $html.= "<li>$mot_clef->mot_clef</li>";
          }
          $html.= <<<EOT
        </ul>
      </section>
    </div>
    EOT;

    return $html;
  }

  protected function makeBody(): string
  {
    $body = <<<EOT
    <main>
      {$this->render()}
    </main>
    EOT;

    return($body);
  }
}