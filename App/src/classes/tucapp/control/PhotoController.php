<?php


namespace iutnc\tweeterapp\control;


use iutnc\mf\control\AbstractController;
use iutnc\tucapp\model\Photos;
use iutnc\tweeterapp\view\PhotoView;

class PhotoController extends AbstractController
{

  public function execute(): void
  {
    $idPhoto = $_GET['id'];
    if ($idPhoto !== 0){
      $photo = Photos::select()->where("id", "=", $idPhoto)->first();
      $photoView = new PhotoView($photo);
      $photoView->setAppTitle($photo->titre);
      $photoView->addStyleSheet('html/style.css');
      $photoView->makePage();
    }
  }
}