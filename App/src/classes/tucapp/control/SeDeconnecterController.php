<?php

namespace iutnc\tucapp\control;

use iutnc\mf\control\AbstractController;
use iutnc\mf\router\Router;
use iutnc\tucapp\auth\TucAuthentification;

class SeDeconnecterController extends AbstractController
{
  public function execute() : void {
    TucAuthentification::logout();

    Router::executeRoute('default');
  }
}
