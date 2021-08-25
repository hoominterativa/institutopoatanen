<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\HelperModule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ModuleMakeController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-controller
        {module : Insert name the module}
        {code : Insert code the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the controller code in module';

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

        if(!$helper->searchModulesJson($arguments['module'])){
            $this->error('O Módulo informado não existe ou sua escrita está incorreta');
            $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
            return;
        }

        if($helper->searchModulesJson($arguments['module'], $arguments['code'])){
            $this->error('O código informado já existe, continuar com o processo substituirá o controller atual pelo controller padrões.');
            if(!$this->confirm('Deseja continuar com o processo?')){
                return;
            }
        }

        Artisan::call('make:controller '.$arguments['module'].'/'.$arguments['code'].'Controller');
        $this->info('Controller criado em '.$arguments['module'].'/'.$arguments['code'].'Controller');
    }
}
