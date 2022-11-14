<?php

namespace iutnc\tucapp\view;

class PhotoView extends TucView
{

  public function render(): string {
    $data = $this->data;
    $html = <<<EOT
    <div class="afficher_photo">
      <section id="photo">
        <a href="javascript:history.back()" class="material-symbols-outlined">arrow_back</a>
    EOT;
        if($data->format == "api"){
          $html.="<img src=\"https://picsum.photos/id/$data->id/$data->largeur/$data->hauteur/\" alt=\"$data->titre\">";
        }else{
          $html.="<img src=\"/AtelierTUC/App/src/classes/tucapp/photo/$data->id.$data->format\" alt=\"$data->titre\">";
        }
    $html.= <<<EOT
      </section>
      <section id="data-photo">
        <h2>$data->titre</h2>
        <p>Ajoutée le $data->date_ajout</p>
        <p>Format : $data->format</p>
        <p>Hauteur : $data->hauteur</p>
        <p>Largeur : $data->largeur</p>
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