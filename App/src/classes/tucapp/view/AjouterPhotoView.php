<?php


namespace iutnc\tucapp\view;


class AjouterPhotoView extends TucView
{
  public function render(): string {
    $data = $this->data;
    return <<<EOT
    <div class="ajouter_photo">
      <form action="?action=ajouter_photo&id=$data" method="post" enctype="multipart/form-data">
          <input type="text" name="titre" id="titre" placeholder='Titre de la photo'>
          <input type="file" name="photo[]" id="photo" multiple="multiple" accept="image/png, image/jpg, image/jpeg, image/gif">
          <input type="submit" name="addPhoto" value="Ajouter"></input>
      </form>
    </div>
    EOT;
  }
}