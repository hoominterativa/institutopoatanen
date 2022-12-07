<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleMakeCore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-core {module : Insert name the module} {code : Insert model code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all core resources in the module';

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
        try {
            $pathCore = 'resources/views/Client/Core/';

            if(!$helper->searchModulesJson($arguments['module'])){
                $this->info('O Módulo informado não existe ou sua escrita está incorreta');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                return;
            }

            if($helper->searchModulesJson($arguments['module'], $arguments['code'])){
                $this->error('O código informado já existe');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                return;
            }

            if(!$helper->refreshModulesJson($arguments['module'], $arguments['code'])){
                $this->error('Erro ao atualizar o arquivo modules.json');
                $this->info('Ignorar esse erro resultará no má funcionamento do sistema');
                return;
            }

            $moduleBlade = Str::slug($arguments['module']);

            if(!is_dir($pathCore.$arguments['module'].'/'.$arguments['code'])) mkdir($pathCore.$arguments['module'].'/'.$arguments['code'], 0777, true);
            if(!is_dir($pathCore.$arguments['module'].'/'.$arguments['code'].'/src')) mkdir($pathCore.$arguments['module'].'/'.$arguments['code'].'/src', 0777, true);

            if(copy('defaults/Client/archive/app.'.$moduleBlade.'.blade.php', $pathCore.$arguments['module'].'/'.$arguments['code'].'/app.blade.php')){
                $this->info('Recurso criado '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/app.blade.php');
            }
            if(copy('defaults/Client/src/_main.scss', $pathCore.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss')){
                $this->info('Recurso criado '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss');
            }
            if(copy('defaults/Client/src/_variables.scss', $pathCore.$arguments['module'].'/'.$arguments['code'].'/src/_variables.scss')){
                $this->info('Recurso criado '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/src/_variables.scss');
            }
            if(copy('defaults/Client/src/main.js', $pathCore.$arguments['module'].'/'.$arguments['code'].'/src/main.js')){
                $this->info('Recurso criado '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/src/main.js');
            }
        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
