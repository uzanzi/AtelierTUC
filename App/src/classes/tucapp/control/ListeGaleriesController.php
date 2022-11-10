<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Utilisateurs;
use iutnc\tucapp\view\ListeGaleriesView;

class ListeGaleriesController extends AbstractController
{
  public function execute() : void {

    $requeteHttp = new HttpRequest;

    if (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='publiques') {
      
      $galeries = Galeries::select()->where('acces', '=', 1)->get();
  
      AbstractView::setAppTitle('TUC Galeries');
      AbstractView::addStyleSheet('html/css/style.css');

      $render = new ListeGaleriesView($galeries);
      $render->makePage();

    } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='partagees') {

      if (TucAuthentification::connectedUser()) {

        $user = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
        $galeries = $user->galeries()->where('niveauAcces', '<', 100)->get();
  
        AbstractView::setAppTitle('TUC Galeries');
        AbstractView::addStyleSheet('html/css/style.css');
  
        $render = new ListeGaleriesView($galeries);
        $render->makePage();

      } else {
        Router::executeRoute('default');
      }
    } elseif (isset($requeteHttp->get['acces']) && $requeteHttp->get['acces']=='privees') {

      if (TucAuthentification::connectedUser()) {

        $user = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
        $galeries = $user->galeries()->where('niveauAcces', '=', 100)->get();
  
        AbstractView::setAppTitle('TUC Galeries');
        AbstractView::addStyleSheet('html/css/style.css');
  
        $render = new ListeGaleriesView($galeries);
        $render->makePage();

      } else {
        Router::executeRoute('default');
      }

      
      
      
    } else {
      Router::executeRoute('default');
    }

  }
}
