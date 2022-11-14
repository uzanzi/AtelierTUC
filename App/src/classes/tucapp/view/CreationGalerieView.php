<?php

namespace iutnc\tucapp\view;

use iutnc\tucapp\view\TucView;

class CreationGalerieView extends TucView{

  public function render(): string {


    $html = "
      <div class='ajouter_galerie'>
        <form action='?action=ajouter_galerie' method='post'>

          <h1>Création d’une galerie</h1>
          <input type='text' name='Titre' placeholder='Nom de votre Galerie' id='' required>
          <input type='text' name='Description' placeholder='Description' id='' required>

          <fieldset>
              
            <legend>Choisir l'acces à votre galerie : </legend>
            <div class='creation_galerie_radio'>

              <input type='radio' name='Acces' value='0'checked>
              <label for='Acces'> Privée </label>
              <input type='radio' name='Acces' value='1'>
              <label for='Acces'> Publique </label>

            </div>

          </fieldset>

          <input type='submit' value='Enregistrer'>

        </form>
      </div>
    ";

    return $html; 

        
  }
    
} 