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
          <form action='?action=presenter_galeries' method='post'>
              <input type='text' name='Titre' id=''>
              <input type='text' name='Description' id=''>
              <input type='submit' value='submit' >
          </form>
      </div>
    ";

    return $html; 

        
    }
    
} 