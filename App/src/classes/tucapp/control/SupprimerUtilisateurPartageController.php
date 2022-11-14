<?php

namespace iutnc\tucapp\control;

use iutnc\mf\router\Router;
use iutnc\mf\utils\HttpRequest;
use iutnc\mf\view\AbstractView;

use iutnc\tucapp\model\Galeries;

use iutnc\mf\control\AbstractController;
use iutnc\tucapp\auth\TucAuthentification;
use iutnc\tucapp\view\SupprimerGalerieView;
use Illuminate\Database\Capsule\Manager as DB;
use iutnc\tucapp\model\Utilisateurs;
use iutnc\tucapp\view\SupprimerUtilisateurPartageControllerView;


class SupprimerUtilisateurPartageController extends AbstractController
{






    public function execute(): void
    {

        if (TucAuthentification::connectedUser()) {
            $requeteHttp = new HttpRequest;
            $idGalerie = $requeteHttp->get['id'];
            $idUtilisateur = $requeteHttp->get['idUtilisateur'];

            $utilisateur = Utilisateurs::select()->where('id', '=', $idUtilisateur)->first();
            $galerieUtilisateur = $utilisateur->galeries()->where('id_galerie', '=', $idGalerie)->first();
            //   Router::executeRoute('default');
            if (isset($galerieUtilisateur->id)) {


                $utilisateur = Utilisateurs::select()->where('id', '=', TucAuthentification::connectedUser())->first();
                $galerieUtilisateur = $utilisateur->galeries()->where('id_galerie', '=', $idGalerie)->where('niveauAcces', '=', 100)->first();


                if (isset($galerieUtilisateur->id)) {

                    if ($requeteHttp->method == 'GET') {

                        AbstractView::setAppTitle("Supprimer Utilisateur Galerie");
                        AbstractView::addStyleSheet('html/css/style.css');


                        $render = new SupprimerUtilisateurPartageControllerView([$idGalerie, $idUtilisateur]);
                        $render->makePage();
                    } elseif ($requeteHttp->method == 'POST') {
                        try {

                            $requeteHttp = new HttpRequest;
                            $idGalerie = $requeteHttp->get['id'];
                            $idUtilisateur = $requeteHttp->get['idUtilisateur'];

                            DB::table('utilisateurs_galeries')->where('id_galerie', $idGalerie)->where('id_utilisateur', $idUtilisateur)->delete();

                            Router::executeRoute('accueil');
                        } catch (\Throwable $th) {
                            echo ($th->getMessage());
                        }
                    }
                } else {
                    echo "<script>alert(\"Vous n'êtes pas le propriétaire de cette galerie\")</script>";
                    Router::executeRoute('galerie');
                }
            } else {
                echo "<script>alert(\"L'utilisateur selectionné n'as pas cette galerie\")</script>";
                Router::executeRoute('galerie');
            }
        } else {
            echo "<script>alert(\"Vous n'êtes pas connecté\")</script>";
            Router::executeRoute('galerie');
        }
    }
}
