<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\view\AbstractView;
use iutnc\tucapp\model\Photos;
use iutnc\tucapp\view\PhotoView;

class PhotoController extends AbstractController
{

  public function execute(): void
  {
    $idPhoto = $_GET['id'];
    if ($idPhoto !== 0){
      $photo = Photos::select()->where("id", "=", $idPhoto)->first();

      AbstractView::setAppTitle("TUC • ".$photo->titre);
      AbstractView::addStyleSheet('html/css/style.css');
      $photoView = new PhotoView($photo);
      $photoView->makePage();
    }
  }
}