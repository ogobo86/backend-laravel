<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
    // Linea para poner en singular la tabla
    //protected $table = 'concept';

    // Campos a llenar 
    protected $fillable = ['quantity', 'price', 'product_id', 'sale_id'];

    // Se especifica la relacion con la tabla SALE
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
}
