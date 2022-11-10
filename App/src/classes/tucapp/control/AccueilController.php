<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\model\Utilisateurs;
use iutnc\tucapp\view\AccueilView;

class AccueilController extends AbstractController
{
  public function execute() : void {

    $requeteHttp = new HttpRequest();

    if (TucAuthentification::connectedUser()) {

      $utilisateur = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();

      $galeriesPrivees = $utilisateur->galeries()->where('niveauAcces', '=', 100)->get();
      $data['galeriesPrivees']=$galeriesPrivees;

      $galeriesPartagees = $utilisateur->galeries()->where('niveauAcces', '<', 100)->get();
      $data['galeriesPartagees']=$galeriesPartagees;

    }

    $galeriesPubliques = Galeries::select()->where('acces', '=', 1)->get();
    $data['galeriesPubliques']=$galeriesPubliques;

    $render = new AccueilView($data);
    $render->makePage();

  }
}