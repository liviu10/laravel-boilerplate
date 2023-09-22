<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCrudResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-crud-resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a CRUD resource (create, reade, update, delete). The resources will contain the following: controller, request, service, interface and model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
