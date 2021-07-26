<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ModuleMake extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make {module : Insert name the module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arguments = $this->arguments();

        try {
            $pathAdmin = 'resources/views/Admin/'.$arguments['module'];
            $pathClient = 'resources/views/Client/pages/'.$arguments['module'];

            if(!is_dir($pathAdmin)) mkdir($pathAdmin, 0777, true);
            if(!is_dir($pathClient)) mkdir($pathClient, 0777, true);

            $this->info('Folder created '.$pathAdmin);
            $this->info('Folder created '.$pathClient);

            Artisan::call('make:model '.$arguments['module']);
            $migration = "create_".strtolower($arguments['module'])."_table";
            Artisan::call('make:migration '.$migration);
            $this->info('Migration created '.$migration);
            Artisan::call('make:seeder '.$arguments['module'].'Seeder');
            $this->info('Seeder created '.$arguments['module'].'Seeder');

            $this->info('Module Created successful!');
        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
