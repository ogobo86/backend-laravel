<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Testing\Fluent\Concerns\Interaction;

class LogUserRegistered implements ShouldQueue
{
    use InteractsWithQueue; 

    public $tries = 3; // Reintentos
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        
        // Linea que guarda en el log la creacion de un usuario. 
        //Log::info("Nuevo usuario registrado", ["id" => $event->user->id]);

        throw new Exception("Ocurrio un erro al registrar usuario: {$this->attempts()}");
        // Duracion entre reintentos. 
        //$this->release(5);
    }

    // Funcio para poder cachar un error. 
    public function failed(UserRegistered $event, $exception){

        Log::critical("El registro en el log del usuario {$event->user["id"]} definitivamente");
    }
}
