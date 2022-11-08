<?php

namespace iutnc\tweeterapp\view;

use iutnc\mf\router\Router;
use iutnc\tweeterapp\model\Tweet;

class UserView extends TweeterView {

  public function render(): string {

    $user = $this->data;
    $router = new Router;

    $html = "
    <div>
      <header>
        <div><a href=\"javascript:history.back()\">
          <span class=\"material-symbols-outlined\">
            arrow_back
          </span>
        </a></div>
        <h2><span>{$user->fullname}</span> • {$user->username}</h2>
        <aside>Followers : {$user->followers}</aside>
      </header>
      <ul>
      ";

    $requete_tweets = Tweet::select()->where('author', '=', $user->id);
    $tweets = $requete_tweets->get(); 

    foreach ($tweets as $tweet){
      
      $urlTweet = $router->urlFor('view_tweet', ['id'=>$tweet->id]);

      $html .= "
      <li class=\"tweet\">
        <header>
          <p class=\"user\"><span>{$tweet->author()->first()->fullname}</span> • {$tweet->author()->first()->username}</p>
        </header>
        <main>
          <a class=\"contenu_tweet\" href=\"$urlTweet\">
            <p>{$tweet->text}</p>
            <aside>{$tweet->created_at}</aside>
          </a>
        </main>
      </li>" ;
    }

    $html .= "</ul></div>";

    return $html;
  } 
}
