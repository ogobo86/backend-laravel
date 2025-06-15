<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    // Con esta linea le damos el nombre correcto en la DB.
    protected $table = 'category';

    // Con esta linea solo se permite en que campos se llena informacion con ELOQUENT
    protected $fillable = ['name'];

    // Relacion de pertenencia 1 a Muchos
    public function products(){
        return $this->hasMany(Product::class);
    }
}
