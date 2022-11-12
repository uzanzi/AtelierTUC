<?php

namespace iutnc\tucapp\view;

class SeConnecterView extends TucView
{
  public function render(): string {

    $html = "
    <div class=\"se_connecter\">
      <form action=\"?action=se_connecter\" method=\"post\">
      <h2>Connexion</h2>
        <input type=\"text\" name=\"mail\" placeholder=\"votre@mail.com\" autocomplete=\"off\" required>
        <input type=\"password\" name=\"mot_de_passe\" placeholder=\"mot de passe\" autocomplete=\"off\" required>";


        if (isset($_SESSION['messagePageSeConnecter'])) {
          $html.="<p>{$_SESSION['messagePageSeConnecter']}</p>";
        }
        
        $html.="<input type=\"submit\" value=\"SE CONNECTER\">
      </form>
    </div>" ;

    return $html;
  } 
}