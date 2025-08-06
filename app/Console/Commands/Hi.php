<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Hi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     * 
     * Argumento opcional genera de esta forma {--lastName=}
     * 
     *
     * Crear un flag 
     */
    protected $signature = 'app:hi {name : Nombre de la persona} 
                            {--lastName= : Apellido de la person}
                            {--uppercase : Indica si se desea el mensaje en mayusculas}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Muestra una descripcion';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument("name");
        // Argumento Opconal 
        $lastName  = $this->option("lastName");
        $uppercase = $this->option("uppercase");
        
        $message = "Hola {$name} {$lastName}";

        // Bloque de codigo para uppercase
        if ($uppercase){
            $message = strtoupper($message);
        }

        $this->info($message);
    }
}
