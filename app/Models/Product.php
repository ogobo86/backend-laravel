<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Con esta linea le damos el nombre correcto en la DB.
    protected $table = 'product';

    // Con esta linea solo se permite en que campos se llena informacion con ELOQUENT
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    // Ocultar informacion desde el MODELO
    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    // Relacion de pertenencia 1 a 1
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
