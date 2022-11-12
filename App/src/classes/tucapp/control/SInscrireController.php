<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\view\SInscrireView;

class SInscrireController extends AbstractController
{
  public function execute() : void {

    $requeteHttp = new HttpRequest();

    if ($requeteHttp->method == 'GET' || isset($_SESSION['messagePageSeConnecter'])) {

      AbstractView::setAppTitle('TUC Galeries');
      AbstractView::addStyleSheet('html/css/style.css');
  
      $render = new SInscrireView();
      $render->makePage();

      unset($_SESSION['messagePageSeConnecter']);

    } elseif ($requeteHttp->method == 'POST') {
      
      try {

        TucAuthentification::register($requeteHttp->post['prenom'], $requeteHttp->post['nom'], $requeteHttp->post['mail'], $requeteHttp->post['mot_de_passe']);

        Router::executeRoute('accueil');

      } catch (\Throwable $th) {
        $_SESSION['messagePageSeConnecter'] = $th->getMessage();
        Router::executeRoute('inscription');
      }

    }

  }
}
