<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    protected $table = 'sale';

    // Especificamos que hara borrado logico
    use SoftDeletes;

    // Campos a llenar 
    protected $fillable = ['email', 'total', 'sale_date'];

    // Ocualtamos datos que no se muestran
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Mencionamos que se relaciona
    public function concepts(){
        return $this->hasMany(Concept::class);
    }
}
