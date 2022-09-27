<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleMakeModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-model {module : Enter the name of the model}
        {code : Insert code the model}
        {model : Insert model name}
        {--m|migration : Create migration in the model}
        {--c|controller : Create controller in the model}
        {--r|resource : Create the resource type controller in the model}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create model in module code';

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

        try {

            if(!$helper->searchModulesJson($arguments['module'])){
                $this->error('O Módulo informado não existe ou sua escrita está incorreta');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                $this->comment('Use o camando artisan module:make para criar um novo módulo.');
                return;
            }

            if(!$helper->searchModulesJson($arguments['module'], $arguments['code'])){
                $this->error('O código informado não existe ou sua escrita está incorreta');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                return;
            }

            Artisan::call('make:model '.$arguments['module'].'/'.$arguments['code'].$arguments['module'].$arguments['model']);

            if($options['migration']){

                $lowerCode = Str::lower($arguments['code']);
                $lowerModel = Str::plural(Str::lower($arguments['model']));
                $lowerModule = Str::lower($arguments['module']);
                $nameMigration = 'create_'.$lowerCode.'_'.$lowerModule.'_'.$lowerModel.'_table';

                Artisan::call('make:migration '.$nameMigration.' --path=database/migrations/'.$arguments['module'].'/'.$arguments['code']);
                Artisan::call('make:seeder '.$arguments['module'].'/'.$arguments['code'].$arguments['model'].'Seeder');
                Artisan::call('make:factory '.$arguments['module'].'/'.$arguments['code'].$arguments['model'].'Factory');

                $this->info('Migration criada com sucesso!');

            }

            if($options['controller'] && !$options['resource']){
                Artisan::call('make:controller '.$arguments['module'].'/'.$arguments['code'].$arguments['model'].'Controller');
                $this->info('Controller criado com sucesso!');
            }else if($options['controller'] && $options['resource']){
                Artisan::call('make:controller --model='.$arguments['module'].'/'.$arguments['code'].$arguments['module'].$arguments['model'].' '.$arguments['module'].'/'.$arguments['code'].$arguments['model'].'Controller');
                $this->info('Controller criado com sucesso!');
            }

            $this->info('Modelo criado com sucesso!');

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
