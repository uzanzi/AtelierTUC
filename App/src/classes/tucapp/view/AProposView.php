<?php

namespace iutnc\tucapp\view;


class AProposView extends TucView
{
  public function render(): string
  {
    return <<<EOT
      <div class="\"a_propos"\">
        <p>L'application TUC App a été crée par Cyprien Cautinaut, Teddy Clements Dels et Ugo Zanzi</p><br>
        <a href="https://github.com/uzanzi/AtelierTUC" target="_blank">Dépôt gitHub</a><br><br>
        <a href="renduConception.pdf" target="_blank">Rendu conception</a><br><br>
        <p>Les utilisateurs n'ont pas de rôles particuliers, leurs identifiants et leurs mots de passe sont disponibles dans l'archive ARCHE comme demandé.</p><br>
      </div>
EOT;
  }
}