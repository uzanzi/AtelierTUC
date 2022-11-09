<?php


namespace iutnc\tucapp\model;

class Utilisateurs extends \Illuminate\Database\Eloquent\Model
{
  protected string $table = 'utilisateurs';
  protected string $primaryKey = 'id';
  public bool $timestamps = false;

  public function galeries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Galeries', 'utilisateurs_galeries', 'id_utilisateur', 'id_galerie');
  }
}