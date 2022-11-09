<?php


namespace iutnc\tucapp\model;

class Photos extends \Illuminate\Database\Eloquent\Model
{
  protected string $table = 'photos';
  protected string $primaryKey = 'id';
  public bool $timestamps = false;

  public function galeries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Galeries', 'galeries_photos', 'id_photo', 'id_galerie');
  }

  public function mots_clefs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Mots_Clefs', 'mots_clefs_photos', 'id_photo', 'mot_clef');
  }
}