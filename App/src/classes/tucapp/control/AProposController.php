<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\tucapp\view\AProposView;


class AProposController extends AbstractController
{
  public function execute() : void {
    $render = new AProposView();
    $render::setAppTitle("TUC a propos");
    $render::addStyleSheet('html/css/style.css');
    $render->makePage();
  }
}