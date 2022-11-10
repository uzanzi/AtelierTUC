<?php


namespace iutnc\tucapp\view;


class AjouterPhotoView extends TucView
{
  public function render(): string {
    return <<<EOT
    <form action="?action=ajouter_photo" method="post">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <button type="submit" name="addPhoto">Ajouter à la galerie</button>
    </form>
    EOT;
  }
}