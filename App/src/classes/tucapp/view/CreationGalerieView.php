<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\tucapp\model\Tweet;
use iutnc\tucapp\view\TucView;

class CreationGalerieView extends TucView{

  public function render(): string {


      $html = "
      <div class ='titreCreationGalerie'><h1>Création d’une galerie</h1></div>
      <div class='contenaireCreationGalerie'>
          <form action='' method='post'>
              <input type='text' name='Titre' id=''>
              <input type='text' name='Description' id=''>
              <input type='submit' value='submit' >

            <input type='radio' name='Acces' value='0' checked>
            <label for='Acces'> Public </label>


            <input type='radio' name='Acces' value='1'>
            <label for='Acces'> Priver </label>

              
          </form>
      </div>
    ";

    return $html; 

        
    }
    
} 