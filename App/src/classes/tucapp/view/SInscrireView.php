<?php

namespace iutnc\tucapp\view;

class SInscrireView extends TucView
{
  public function render(): string {

    $html = "
    <form action=\"?action=s_inscrire\" method=\"post\">
      <input type=\"text\" name=\"prenom\" placeholder=\"Votre prénom\" autocomplete=\"off\">
      <input type=\"text\" name=\"nom\" placeholder=\"Votre nom\" autocomplete=\"off\">
      <input type=\"text\" name=\"mail\" placeholder=\"votre@mail.com\" autocomplete=\"off\">
      <input type=\"password\" name=\"mot_de_passe\" placeholder=\"mot de passe\" autocomplete=\"off\">";

      if (isset($_SESSION['messagePageSeConnecter'])) {
        $html.="<p>{$_SESSION['messagePageSeConnecter']}</p>";
      }
      
      $html.="<input type=\"submit\" value=\"S'INSCRIRE\">
    </form>" ;

    return $html;
  } 
}