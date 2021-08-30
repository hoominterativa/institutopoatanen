<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\HelperModule;
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
        $helper = new HelperModule();

        try {
            if($helper->searchModulesJson($arguments['module'])){
                $this->error('O módulo informado já existe.');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                return;
            }

            if(!$helper->refreshModulesJson($arguments['module'])){
                $this->error('Erro ao atualizar o arquivo modules.json');
                $this->info('Ignorar esse erro resultará no má funcionamento do sistema');
                return;
            }

            $this->info('Módulo registrado com sucesso!');

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
