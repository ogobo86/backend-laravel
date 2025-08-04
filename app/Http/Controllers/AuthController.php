<?php

namespace App\Http\Controllers;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // Registro
    public function register(UserRequest $request){
        // validar informacion
        $validatedData = $request->validated();

        // Registro en DB
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']) // bcrypt metodo que encripta
        ]);

        // En esta linea se ejecuta el evento. 
        event(new UserRegistered($user));

        // Retorno 
        return response()->json(['message' => 'Usuario registrado correctamente'], Response::HTTP_CREATED);
    }


    public function login(LoginRequest $request){
        // Validacion de informacion 
        $validatedData = $request -> validated();

        $credentials =['email'=> $validatedData['email'],
                       'password' => $validatedData['password']];
        try{
            if(!$token = JWTAuth::ATTEMPT($credentials)){
                return response()->json(['error'=>'Usuario o contrasenia invalida'], Response::HTTP_UNAUTHORIZED);
            }
        }catch(JWTException){
            return response()->json(['error'=> 'No se pudo generar el token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        //return response()->json(['token' => $token]);
        return $this->respondWithToken($token);
    }

    // Para saber quien esta conectado
    public function who(){
        
        $user = auth()->user();
        return response()->json($user);
    }

    // Cierre de sesion
    public function logout(){

        try {
            // Se obtiene el token 
            $token = JWTAuth::getToken();
            // Se invalida
            JWTAuth::invalidate($token);
            return response()->json(['message'=>'Sesion cerrada correctamente']);
        }catch (JWTException $e) {
            return response()->json(['error'=>'No se pudo cerrar la sesion, el token no es valido.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function refresh(){

        try {
            // Se obtiene el token 
            $token = JWTAuth::getToken();
            // Se genera el nuevo token
            $newToken = auth()->refresh();
            // Se invalida el toiken viejo
            JWTAuth::invalidate($token);
            return $this->respondWithToken($newToken);
        }catch (JWTException $e) {
            return response()->json(['error'=>'Error al refrescar el token.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Expiracion de token
    protected function respondWithToken($token){

        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}