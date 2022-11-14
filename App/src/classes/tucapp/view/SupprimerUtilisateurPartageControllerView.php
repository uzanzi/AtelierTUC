<?php

namespace iutnc\tucapp\view;

use iutnc\tucapp\view\TucView;

class SupprimerUtilisateurPartageControllerView extends TucView{

  public function render(): string {
    $idGalerie = $this->data[0];
    $idUtilisateur  = $this->data[1];

    
    $html = "
    <div class='supprimerGalerie'>
    
    <form action='?action=supprimer_utilisateur_partage&idUtilisateur=$idUtilisateur&id=$idGalerie' method='post'>
    <h2> Voulez vous vraiment supprimer les droits de l'utilisateur ?</h2>
    <input type='submit' class='boutonConfimeSupprimerGalerie' value='Supprimer' name='submitSupprimerGalerie'>
    </form>
    </div>
    ";

    return $html; 

        
  }
    
} 