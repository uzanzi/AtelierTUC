<?php


namespace iutnc\tucapp\view;


class AjouterPhotoView extends TucView
{
  public function render(): string {
    $data = $this->data;
    return <<<EOT
    <form action="?action=ajouter_photo&id=$data" method="post" enctype="multipart/form-data">
        <input type="text" name="titre" id="titre">
        <input type="file" name="photo[]" id="photo" multiple="multiple" accept="image/png, image/jpg, image/jpeg, image/gif">
        <button type="submit" name="addPhoto">Ajouter à la galerie</button>
    </form>
    EOT;
  }
}