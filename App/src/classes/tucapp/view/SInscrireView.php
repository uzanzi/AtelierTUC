<?php

namespace iutnc\tucapp\view;

class SInscrireView extends TucView
{
  public function render(): string {

    $html = "
    <div class=\"s_inscrire\">
      <form action=\"?action=s_inscrire\" method=\"post\">
        <h2>Inscription</h2>
        <input type=\"text\" name=\"prenom\" placeholder=\"Votre prénom\" autocomplete=\"off\" required>
        <input type=\"text\" name=\"nom\" placeholder=\"Votre nom\" autocomplete=\"off\" required>
        <input type=\"text\" name=\"mail\" placeholder=\"votre@mail.com\" autocomplete=\"off\" required>
        <input type=\"password\" name=\"mot_de_passe\" placeholder=\"mot de passe\" autocomplete=\"off\" required>";

        if (isset($_SESSION['messagePageSeConnecter'])) {
          $html.="<p>{$_SESSION['messagePageSeConnecter']}</p>";
        }
        
        $html.="<input type=\"submit\" value=\"S'INSCRIRE\">
      </form>
    </div>" ;

    return $html;
  } 
}