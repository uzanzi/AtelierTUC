<?php

namespace iutnc\mf\router;


use iutnc\mf\utils\HttpRequest;
use iutnc\mf\auth\AbstractAuthentification;

class Router extends AbstractRouter
{
  public function addRoute(string $name, string $action, string $ctrl, int $nvAcces = AbstractAuthentification::ACCESS_LEVEL_NONE): void{
    self::$routes[$action]['ctrl']=$ctrl;
    self::$routes[$action]['nvAccess']=$nvAcces;
    self::$aliases[$name]=$action;
  }

  public function setDefaultRoute(string $action):void{
    self::$aliases['default']=$action;
  }

  public function run() : void{

    if (!isset($this->request->get['action'])) {
        $ctrl = self::$routes[self::$aliases['default']]['ctrl'];
        $temp = new $ctrl();
        $temp->execute();

    } else {

      $action = $this->request->get['action'];

      if (isset(self::$routes[$action])) {

        $userAccessLevel=0;

        if (isset($_SESSION['user_profile']['access_level'])) {
          $userAccessLevel=$_SESSION['user_profile']['access_level'];
        }

        if ($userAccessLevel >= self::$routes[$action]['nvAccess']) {
          $temp = new self::$routes[$action]['ctrl']();
          $temp->execute();
        } else {
          $temp = new self::$routes[self::$aliases['login']]['ctrl']();
          $temp->execute();
        }
        


      } else {

        $temp = new self::$routes[self::$aliases['default']]['ctrl']();
        $temp->execute();

      }

    }

  }

  static function executeRoute($alias){
    $temp = new self::$routes[self::$aliases[$alias]]['ctrl']();
    $temp->execute();
  }

  public function urlFor(string $name, array $params=[]): string{

    $url="{$this->request->root}?action={$name}";

    foreach ($params as $key => $value) {
      $url.="&$key=$value";
    }
    
    return $url;
  }

}
