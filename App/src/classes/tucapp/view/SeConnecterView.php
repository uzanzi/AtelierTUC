<?php

namespace iutnc\tucapp\view;

class SeConnecterView extends TucView
{
  public function render(): string {

    $html = "
    <form action=\"?action=se_connecter\" method=\"post\">
      <input type=\"text\" name=\"mail\" placeholder=\"votre@mail.com\" autocomplete=\"off\">
      <input type=\"password\" name=\"mot_de_passe\" placeholder=\"mot de passe\" autocomplete=\"off\">";


      if (isset($_SESSION['messagePageSeConnecter'])) {
        $html.="<p>{$_SESSION['messagePageSeConnecter']}</p>";
      }
      
      $html.="<input type=\"submit\" value=\"SE CONNECTER\">
    </form>" ;

    return $html;
  } 
}