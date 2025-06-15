<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // Con esta linea le damos el nombre correcto en la DB.
    protected $table = 'product';

    // Con esta linea solo se permite en que campos se llena informacion con ELOQUENT
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    // Relacion de pertenencia 1 a 1
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
