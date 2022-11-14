<?php

namespace iutnc\tucapp\view;

use iutnc\tucapp\view\TucView;

class AjouterUtilisateurPartageView extends TucView{

  public function render(): string {
    $data = $this->data;

    $html = "
      <div class='ajouter_galerie'>
        <form action='?action=ajouter_utilisateur_partage&id=$data' method='post'>

          <h1>Ajouter un utilisateur à la galerie</h1>
          <input type='text' name='Mail_utilisateur' placeholder=\"Mail de l'utilisateur\"  required>

          <input type='submit' value='Enregistrer'>
        </form>
      </div>
    ";

    return $html; 

        
  }
    
} 