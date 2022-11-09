<?php


namespace iutnc\tucapp\model;

class Galeries extends \Illuminate\Database\Eloquent\Model
{
  protected string $table = 'galeries';
  protected string $primaryKey = 'id';
  public bool $timestamps = false;

  public function mots_clefs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Mots_Clefs', 'mots_clefs_galeries', 'id_galerie', 'mot_clef');
  }

  public function utilisateurs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Galeries', 'utilisateurs_galeries', 'id_utilisateur', 'id_galerie');
  }

  public function photos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Photos', 'galeries_photos', 'id_galerie', 'id_photo');
  }
}