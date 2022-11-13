<?php

namespace iutnc\tucapp\view;

class PhotoView extends TucView
{

  public function render(): string {
    $data = $this->data;
    return <<<EOT
    <div class="afficher_photo">
      <section id="photo">
        <a href="javascript:history.back()" class="material-symbols-outlined">arrow_back</a>
        <img src="https://picsum.photos/id/$data->id/2000/2000" alt="photo" class="afficherPhoto">
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