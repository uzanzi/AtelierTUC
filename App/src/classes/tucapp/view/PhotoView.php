<?php

namespace iutnc\tucapp\view;

class PhotoView extends TucView
{

  public function render(): string {
    $data = $this->data;
    return <<<EOT
    <div id="photo"><img src="https://picsum.photos/id/237/500/500" alt="photo" class="afficherPhoto"></div>
      <div id="data-photo">
        <p>Titre : $data->id</p>
        <p>Date d'ajout : $data->date_ajout</p>
        <p>Format : $data->format</p>
        <p>Hauteur : $data->hauteur</p>
        <p>Largeur : $data->largeur</p>
     </div>
    EOT;
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