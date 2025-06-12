<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    private $names = [
        1 => ['name' => 'Ana', 'age' => 35 ],
        2 => ['name' => 'Pedro', 'age' => 25], 
        3 => ['name' => 'Francisque', 'age' => 18]
    ];

    public function getAll(){
        return response()->json($this->names);
    }

    public function get(int $id = 0){
        // Valida que el parametro si se encuentra en el array 
        if (isset($this->names[$id])){
            return response()->json($this->names[$id]);
        }
        // En caso de que el parametro no se encuentre manda el error. 
        return response()->json(['ERROR'=> 'Nombre no existente.'], Response::HTTP_NOT_FOUND);
    }

    public function create (Request $request){
        
        $person = [
            // suma en 1 el ID en el array. 
            'id' => count($this -> names) + 1,
            // Crea un input para obtener informacion
            'name' => $request -> input("name"),
            'age' => $request -> input ('age')
        ];
        // Agrega informacion en el array.
        $this -> names [$person['id']] = $person;
        // Regresamos un 201
        return response()->json(['Message' => 'Se agrego correctamente', 'person' => $person], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id){
        // Valida que el parametro si se encuentra en el array 
        if (isset($this->names[$id])){
            $this->names[$id]["name"] = $request -> input("name");
            $this->names[$id]["age"] = $request -> input("age");
            // Confirma el update (PUT) del id. 
            return response()->json(['Message' => 'Se actualizo de manera correcta', 'person'=> $this->names[$id]]);
        }
        // En caso de que el parametro no se encuentre manda el error. 
        return response()->json(['ERROR'=> 'Nombre no existente.'], Response::HTTP_NOT_FOUND);
    }

    public function delete(int $id){
        // Valida que el parametro si se encuentra en el array 
        if (isset($this->names[$id])){
            unset($this->names[$id]);
            //Confirma que se elmino
            return response()->json(['Message' => 'Id eliminado correctamente']);
        }
        // En caso de que el parametro no se encuentre manda el error. 
        return response()->json(['ERROR'=> 'Nombre no existente.'], Response::HTTP_NOT_FOUND);
    }
}
