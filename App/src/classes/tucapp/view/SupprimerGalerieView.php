<?php

namespace iutnc\tucapp\view;

use iutnc\tucapp\view\TucView;

class SupprimerGalerieView extends TucView{

  public function render(): string {
    $galerie = $this->data[0];
    $id_Galerie = $this->data[1];

    
    $html = "
    <div class='supprimerGalerie'>
    
    <form action='?action=supprimer_galerie&id=$id_Galerie' method='post'>
    <h2> Voulez vous vraiment supprimer votre galerie $galerie ?</h2>
    <input type='submit' class='boutonConfimeSupprimerGalerie' value='Supprimer' name='submitSupprimerGalerie'>
    </form>
    </div>
    ";

    return $html; 

        
  }
    
} 




