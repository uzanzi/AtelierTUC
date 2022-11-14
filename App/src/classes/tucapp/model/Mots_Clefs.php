<?php


namespace iutnc\tucapp\model;

class Mots_Clefs extends \Illuminate\Database\Eloquent\Model
{
  protected $table = 'mots_clefs';
  protected $primaryKey = 'mot_clef';
  public $incrementing = false;
  public $timestamps = false;

  public function photos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Photos', 'mots_clefs_photos', 'photo_id', 'mot_clef');
  }

  public function galeries(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany('\iutnc\tucapp\model\Galeries', 'mots_clefs_galeries', 'galerie_id', 'mot_clef');
  }
}