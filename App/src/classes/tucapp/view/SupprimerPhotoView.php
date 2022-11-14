<?php

namespace iutnc\tucapp\view;


class SupprimerPhotoView extends TucView{

  public function render(): string {
    $id_Galerie = $this->data[0];
    $id_Photo = $this->data[1];


    $html = "
    <div class='supprimerPhoto'>
    
    <form action='?action=supprimer_photo&idGalerie=$id_Galerie&idPhoto=$id_Photo' method='post'>
    <h2> Voulez-vous vraiment supprimer la photo ?</h2>
    <input type='submit' class='boutonConfirmeSupprimerPhoto' value='Supprimer' name='submitSupprimerPhoto'>
    </form>
    </div>
    ";

    return $html;

        
  }
    
} 



