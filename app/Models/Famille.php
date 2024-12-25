<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Famille extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'description', 'sous_category_id'];

    public function sousCategory(){
        return $this->belongsTo(Sous_category::class, 'sous_category_id','id');
    }

    public function produits(){
        return $this->hasMany(produits::class, 'famille_id','id');
    }
  
    public function productCount()
    {
        return $this->produits()->count();
    }
}
