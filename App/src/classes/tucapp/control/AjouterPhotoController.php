<?php


namespace iutnc\tucapp\control;


use iutnc\mf\control\AbstractController;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\view\AjouterPhotoView;

class AjouterPhotoController extends AbstractController
{

  public function execute(): void
  {
    $httpRequest = new HttpRequest();
    if ($httpRequest->method === 'GET'){
      $ajouterPhoto = new AjouterPhotoView();
      $ajouterPhoto->setAppTitle('Ajouter photo');
      $ajouterPhoto->makePage();
    }elseif ($httpRequest->method === 'POST'){
      var_dump('toto');
    }
  }
}