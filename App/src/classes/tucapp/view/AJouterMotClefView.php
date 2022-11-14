<?php


namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;

class AjouterMotClefView extends TucView
{
  public function render(): string {
    $id=$this->data['id'];
    return <<<EOT
    <div class="ajouter_mot_clef">
      <form action="?action=ajouter_mot_clef&id=$id" method="post" enctype="multipart/form-data">
          <input type="text" name="motClef" placeholder='Nouveau mot clef'>
          <input type="submit" value="Ajouter"></input>
      </form>
    </div>
    EOT;

    $html = '';
    return $html;
  }
}