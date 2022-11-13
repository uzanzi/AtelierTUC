<?php

namespace iutnc\tucapp\view;

use iutnc\tucapp\view\TucView;

class SupprimerGalerieView extends TucView{

  public function render(): string {
    $galerie = $this->data[0];

    
    $html = "
    <div class='supprimerGalerie'>
    
    <form action='?action=presenter_galeries' method='post'>
    <h2> Voulez vous vraiment supprimer votre galerie $galerie ?</h2>
    <input type='submit' class='boutonConfimeSupprimerGalerie' value='Supprimer' name='submitSupprimerGalerie'>
    </form>
    </div>
    ";

    return $html; 

        
  }
    
} 




