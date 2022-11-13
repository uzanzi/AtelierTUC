<?php

namespace iutnc\tucapp\view;

use iutnc\mf\router\Router;
use iutnc\mf\view\AbstractView;
use iutnc\mf\view\Renderer;
use iutnc\tucapp\auth\TucAuthentification;

class TucView extends AbstractView implements Renderer{

  public function render(): string {
    return '';
  } 

  protected function makeBody(): string {

    $body = <<<EOT
    {$this->renderTopMenu()}
    <main>
      {$this->render()}
    </main>
      {$this->renderBottomMenu()}
    EOT;

    return($body);
  }

  protected function renderBottomMenu(): string {

    $footer = <<<EOT
      <footer>
        <p><a href="/a-propos.html">À Propos</a></p>
        <p><a href="/utilisateurs.html">Comptes utilisateurs</a></p>
        <p>Application créée par le groupe TUC en LP CIASIE • 2022</p>
      </footer>
    EOT;

    return $footer;

  }

  protected function renderTopMenu(): string{

    $router = new Router;

    if (TucAuthentification::connectedUser()) {
      $reponse = <<<EOT
      <header>
      <h1><a href="{$router->urlFor('presenter_galeries')}">TUC Galeries</a></h1>
      <nav>
        <a href="{$router->urlFor('se_deconnecter')}" class="material-symbols-outlined">
          logout
        </a>
      </nav>
    </header>
    EOT;
    } else {
      $reponse = <<<EOT
      <header>
      <h1><a href="{$router->urlFor('presenter_galeries')}">TUC Galeries</a></h1>
      <nav>
        <a href="{$router->urlFor('s_inscrire')}" class="material-symbols-outlined">
          person_add
        </a>
        <a href="{$router->urlFor('se_connecter')}" class="material-symbols-outlined">
          login
        </a>
      </nav>
    </header>
    EOT;
    }

    return $reponse;
  }
}
