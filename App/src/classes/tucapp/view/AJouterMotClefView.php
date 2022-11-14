<?php


namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;

class AjouterMotClefView extends TucView
{
  public function render(): string {
    $id=$this->data['id'];
    $requete= new HttpRequest;

    if (isset($requete->get['idGalerie'])) {
      return <<<EOT
      <div class="ajouter_mot_clef">
        <form action="?action=ajouter_mot_clef&id=$id&idGalerie={$requete->get['idGalerie']}" method="post" enctype="multipart/form-data">
            <input type="text" name="motClef" placeholder='Nouveau mot clef'>
            <input type="submit" value="Ajouter"></input>
        </form>
      </div>
      EOT;
    } else {
      return <<<EOT
      <div class="ajouter_mot_clef">
        <form action="?action=ajouter_mot_clef&id=$id" method="post" enctype="multipart/form-data">
            <input type="text" name="motClef" placeholder='Nouveau mot clef'>
            <input type="submit" value="Ajouter"></input>
        </form>
      </div>
      EOT;
    }
    

    $html = '';
    return $html;
  }
}