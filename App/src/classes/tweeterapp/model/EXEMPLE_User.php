<?php

namespace iutnc\tweeterapp\model;

class User extends \Illuminate\Database\Eloquent\Model
{
  protected $table = 'user';
  protected $primaryKey = 'id';
  public $timestamps = false;

  public function tweets() {
    return $this->hasMany('iutnc\tweeterapp\model\Tweet', 'author');
  }

  public function liked() {
    return $this->belongsToMany('iutnc\tweeterapp\model\Tweet', 'like', 'user_id', 'tweet_id');

    /* 'Tweet'       : le nom de la classe du model lié */
    /* 'like '      : le nom de la table pivot */
    /* 'user_id'    : la clé étrangère de ce modèle dans la table pivot */
    /* 'tweet_id' : la clé étrangère du modèle lié dans la table pivot */
  }

  public function followedBy () {
    return $this->belongsToMany('iutnc\tweeterapp\model\User', 'follow', 'followee', 'follower');
    
    /* 'Tweet'       : le nom de la classe du model lié */
    /* 'like '      : le nom de la table pivot */
    /* 'user_id'    : la clé étrangère de ce modèle dans la table pivot */
    /* 'tweet_id' : la clé étrangère du modèle lié dans la table pivot */
  }
  
  public function follows() {
    return $this->belongsToMany('iutnc\tweeterapp\model\User', 'follow', 'follower', 'followee');

    /* 'Tweet'       : le nom de la classe du model lié */
    /* 'like '      : le nom de la table pivot */
    /* 'user_id'    : la clé étrangère de ce modèle dans la table pivot */
    /* 'tweet_id' : la clé étrangère du modèle lié dans la table pivot */
  }
}
