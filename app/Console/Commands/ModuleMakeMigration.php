<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleMakeMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-migration
        {module : Enter the name of the module for migration creation}
        {code : Insert code the model}
        {--migration= : Insert name custom the migration in laravel default}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration, seeder and factory';

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
        $helper = new HelperModule();
        $arguments = $this->arguments();
        $options = $this->options();

        if(!$helper->searchModulesJson($arguments['module'])){
            $this->error('O Módulo informado não existe ou sua escrita está incorreta');
            $this->info('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
            $this->info('Use o camando artisan module:make para criar um novo módulo.');
            return;
        }

        if($options['migration']){
            if(!$helper->searchModulesJson($arguments['module'], $arguments['code'])){
                $this->error('O código informado não existe ou sua escrita está incorreta');
                $this->info('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                $this->info('Use o camando artisan module:model para criar um novo modelo.');
                return;
            }

            Artisan::call('make:migration '.$options['migration'].' --path=database/migrations/'.$arguments['module'].'/'.$arguments['code']);
            $this->info('Migrate criada com sucesso!');
            return;
        }

        if($helper->searchModulesJson($arguments['module'], $arguments['code'])){
            $this->error('O código informado já existe, continuar com o processo substituirá os arquivos atuais por arquivos padrões.');
            if(!$this->confirm('Deseja continuar com o processo?')){
                return;
            }
        }

        $lowerModule = Str::lower($arguments['module']);
        $lowerModel = Str::lower($arguments['code']);
        $nameMigration = 'create_'. $lowerModel.'_'.$lowerModule .'_table';

        Artisan::call('make:migration '.$nameMigration.' --path=database/migrations/'.$arguments['module'].'/'.$arguments['code']);
        Artisan::call('make:seeder '.$arguments['module'].'/'.$arguments['code'].'Seeder');
        Artisan::call('make:factory '.$arguments['module'].'/'.$arguments['code'].'Factory');

        $this->info('Migrate, Seeder e Factory criados com sucesso!');
    }
}
