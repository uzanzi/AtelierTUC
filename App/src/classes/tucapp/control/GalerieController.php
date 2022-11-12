<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\utils\HttpRequest;
use iutnc\tucapp\model\Galeries;
use iutnc\tucapp\view\GalerieView;
use iutnc\mf\view\AbstractView;


class GalerieController extends AbstractController
{
  public function execute() : void {

    $requeteHttp = new HttpRequest();

    if (isset($requeteHttp->get['page'])) {
      $page = $requeteHttp->get['page'];
    } else {
      $page = 1;
    }

    $nbItemParPage=6;
    
    $offset = $nbItemParPage * ($page-1);

    $galerie = Galeries::select()->where('id', '=', $requeteHttp->get['id'])->first();
    $photos = $galerie->photos()->offset($offset)->limit($nbItemParPage)->get();
    

    AbstractView::setAppTitle("$galerie->nom");
    AbstractView::addStyleSheet('html/css/style.css');

    $render = new GalerieView([$galerie, $photos]);
    $render->makePage();

  }
}