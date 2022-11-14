<?php

namespace iutnc\tucapp\view;


class AProposView extends TucView
{
  public function render(): string
  {
    return <<<EOT
      <div class="\"a_propos"\">
        <p>L'application TUC App a été crée par Cyprien Cautinaut, Teddy Clements Dels et Ugo Zanzi</p>
        <a href="https://github.com/uzanzi/AtelierTUC" target="_blank">Dépôt gitHub</a>
        <a href="../../../../renduConception.pdf" target="_blank">Rendu conception</a>
      </div>
EOT;
  }
}