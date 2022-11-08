<?php

namespace iutnc\tweeterapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\tweeterapp\model\User;
use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;
use iutnc\tweeterapp\view\UserView;

class UserController extends AbstractController
{
  public function execute() : void {

    $requeteHttp = new HttpRequest;

    if (!isset($requeteHttp->get['id']) || $requeteHttp->get['id']=='') {
      Router::executeRoute('default');
    } elseif (intval($requeteHttp->get['id'])!=$requeteHttp->get['id']) {
      Router::executeRoute('default');
    } else {

      $requete_user = User::select()->where('id', '=', $requeteHttp->get['id']);
      $user = $requete_user->first(); 


      if (!isset($user->id)) {
        Router::executeRoute('default');
      } else {

        AbstractView::setAppTitle($user->fullname);
        AbstractView::addStyleSheet('html/css/style.css');

        $render = new UserView($user);
        $render->makePage();
      }


    }

  }
}
