<?php


namespace iutnc\tucapp\model;

class Utilisateurs extends \Illuminate\Database\Eloquent\Model
{
  protected $table = 'utilisateurs';
  protected $primaryKey = 'id';
  public $timestamps = false;

  public function galeries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Galeries', 'utilisateurs_galeries', 'id_utilisateur', 'id_galerie');
  }
}