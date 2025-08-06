<?php

namespace App\Console\Commands;

use App\ExternalService\ApiService;
use Illuminate\Console\Command;

class ApiInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:api-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consulta el API tercera';


    public function __construct(protected ApiService $apiService)
    {
        // Se llama el contructor del padre.
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Deserialización del Json a mostran en consola
        $jsonString = json_encode($this->apiService->getData());
        // Mostrar en consola
        $this->info($jsonString);

    }
}
