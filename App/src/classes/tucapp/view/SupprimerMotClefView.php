<?php

namespace iutnc\tucapp\view;


class SupprimerMotClefView extends TucView{

  public function render(): string {
    if (isset($this->data["idGalerie"])){
      $id_Photo = $this->data["id"];
      $id_Galerie = $this->data["idGalerie"];
      return "
    <div class='supprimerMotClef'>
    <form action='?action=supprimer_mot_clef&idGalerie=$id_Galerie&id=$id_Photo&motClef={$this->data['motClef']}' method='post'>
    <h2> Voulez-vous vraiment supprimer le mot clef ?</h2>
    <input type='submit' class='boutonConfirmeSupprimerMotClef' value='Supprimer' name='submitSupprimerMotClef'>
    </form>
    </div>
    ";
    }
    else{
      $id_Galerie = $this->data["id"];
      return "
    <div class='supprimerMotClef'>
    <form action='?action=supprimer_mot_clef&id=$id_Galerie&motClef={$this->data['motClef']}' method='post'>
    <h2> Voulez-vous vraiment supprimer le mot clef ?</h2>
    <input type='submit' class='boutonConfirmeSupprimerMotClef' value='Supprimer' name='submitSupprimerMotClef'>
    </form>
    </div>
    ";
    }

  }
}