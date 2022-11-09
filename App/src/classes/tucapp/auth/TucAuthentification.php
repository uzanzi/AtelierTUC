<?php

namespace iutnc\tucapp\auth;

use Exception;
use iutnc\mf\auth\AbstractAuthentification;
use iutnc\tweeterapp\model\User;

class TucAuthentification extends AbstractAuthentification
{
  const ACCESS_LEVEL_USER = 100;
  const ACCESS_LEVEL_ADMIN = 100;


  public static function register(string $prenom,
                                  string $nom,
                                  string $mail,
                                  string $mot_de_passe): void {


  /* La méthode register
    *
    *    Permet la création d'un nouvel utilisateur de l'application
    *
    * Paramètres :
    *
    *    $username : le nom d'utilisateur choisi
    *    $pass : le mot de passe choisi
    *    $fullname : le nom complet
    *    $level : le niveaux d'accès (par défaut ACCESS_LEVEL_USER)
    *
    * Algorithme :
    *
    *    - Si un utilisateur avec le même nom d'utilisateur existe déjà en BD
    *        - soulever une exception
    *    - Sinon
    *        - créer un nouveau modèle ``User`` avec les valeurs en paramètre
    *           ATTENTION : utiliser self::makePassword (cf. ``AbstractAuthentification``)
    *
    */

    if(User::select()->where('mail', '=', $mail)->first()){
      throw new Exception("Un compte est déjà associé à cette adresse mail", 1);
    } else {
      $newUser = new User;
      $newUser->nom=$nom;
      $newUser->prenom=$prenom;
      $newUser->mail=$mail;
      $newUser->mot_de_passe= self::makePassword($mot_de_passe);
      $newUser->save();
    }
  }


  public static function login(string $mail, string $mot_de_passe): void {

    /* La méthode login
     *
     *     Permet de connecter un utilisateur qui a fourni son nom d'utilisateur
     *     et son mot de passe (depuis un formulaire de connexion)
     *
     * Paramètres :
     *
     *    $username : le nom d'utilisateur
     *    $password : le mot de passe tapé sur le formulaire
     *
     * Algorithme :
     *
     *    - Récupérer l'utilisateur avec l'identifiant $username depuis la BD
     *    - Si aucun de trouvé
     *         - soulever une exception
     *    - Sinon
     *         - réaliser l'authentification et le chargement du profil
     *            ATTENTION : utiliser self::checkPassword (cf. ``AbstractAuthentification``)
     *
     */

     $user = User::select()->where('mail', '=', $mail)->first();

        if ($user) {
          AbstractAuthentification::checkPassword($mot_de_passe, $user->mot_de_passe, $user->id);
        } else {
          throw new Exception("Identifiant ou mot de passe incorrect", 1);
        }

  }


}
