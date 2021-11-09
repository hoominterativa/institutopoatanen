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
    protected $signature = 'module:make-model {module : Enter the name of the module for resource creation}
        {code : Insert code the model}
        {--s|section : Create a section view in model}
        {--p|page : Create a page view in model}
        {--c|content : Create a content view in model}
        {--admin : Create administrator resources the model}
        {--client : Create client resources the model}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all module features according to template code';

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

            // Create views Admin
            if($options['admin']){
                $pathAdmin = 'resources/views/Admin/cruds/';
                if(!is_dir($pathAdmin.$arguments['module'].'/'.$arguments['code'])) mkdir($pathAdmin.$arguments['module'].'/'.$arguments['code'], 0777, true);

                if(copy('defaults/Admin/archive/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/create.blade.php')){
                    $this->info('Recurso criado '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/create.blade.php');
                }
                if(copy('defaults/Admin/archive/edit.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/edit.blade.php')){
                    $this->info('Recurso criado '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/edit.blade.php');
                }
                if(copy('defaults/Admin/archive/index.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/index.blade.php')){
                    $this->info('Recurso criado '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/index.blade.php');
                }
                if(copy('defaults/Admin/archive/form.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/form.blade.php')){
                    $this->info('Recurso criado '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/form.blade.php');
                }
            }

            // Create routes
            if(!is_dir('routes/'.$arguments['module'])) mkdir('routes/'.$arguments['module'], 0777, true);
            if(copy('defaults/Routes/web.php', 'routes/'.$arguments['module'].'/'.$arguments['code'].'.php')){
                $this->info('Routes created routes/'.$arguments['module'].'/'.$arguments['code'].'.php');
            }

            // Create views client
            if($options['client']){
                $pathClient = 'resources/views/Client/pages/';

                if(!is_dir($pathClient.$arguments['module'].'/'.$arguments['code'])) mkdir($pathClient.$arguments['module'].'/'.$arguments['code'], 0777, true);

                if($options['section']){
                    if(copy('defaults/Client/archive/section.blade.php', $pathClient.$arguments['module'].'/'.$arguments['code'].'/section.blade.php')){
                        $this->info('Recurso criado '.$pathClient.$arguments['module'].'/'.$arguments['code'].'/section.blade.php');
                    }
                }
                if($options['page']){
                    if(copy('defaults/Client/archive/page.blade.php', $pathClient.$arguments['module'].'/'.$arguments['code'].'/page.blade.php')){
                        $this->info('Recurso criado '.$pathClient.$arguments['module'].'/'.$arguments['code'].'/page.blade.php');
                    }
                }
                if($options['content']){
                    if(copy('defaults/Client/archive/show.blade.php', $pathClient.$arguments['module'].'/'.$arguments['code'].'/show.blade.php')){
                        $this->info('Recurso criado '.$pathClient.$arguments['module'].'/'.$arguments['code'].'/show.blade.php');
                    }
                }
            }

            // Create assets
            if(!is_dir($pathClient.$arguments['module'].'/'.$arguments['code'].'/src')) mkdir($pathClient.$arguments['module'].'/'.$arguments['code'].'/src', 0777, true);

            if(copy('defaults/Client/src/_variables.scss', $pathClient.$arguments['module'].'/'.$arguments['code'].'/src/_variables.scss')){
                $this->info('Recurso criado '.$pathClient.$arguments['module'].'/'.$arguments['code'].'/src/_variables.scss');
            }
            if(copy('defaults/Client/src/_main.scss', $pathClient.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss')){
                $this->info('Recurso criado '.$pathClient.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss');
            }
            if(copy('defaults/Client/src/main.js', $pathClient.$arguments['module'].'/'.$arguments['code'].'/src/main.js')){
                $this->info('Recurso criado '.$pathClient.$arguments['module'].'/'.$arguments['code'].'/src/main.js');
            }

            $lowerModule = Str::lower($arguments['module']);
            $lowerModel = Str::lower($arguments['code']);
            $nameMigration = 'create_'. $lowerModel.'_'.$lowerModule .'_table';

            if($options['admin']){
                Artisan::call('make:model '.$arguments['module'].'/'.$arguments['code'].$arguments['module']);
                Artisan::call('make:migration '.$nameMigration.' --path=database/migrations/'.$arguments['module'].'/'.$arguments['code']);
                Artisan::call('make:seeder '.$arguments['module'].'/'.$arguments['code'].'Seeder');
                Artisan::call('make:factory '.$arguments['module'].'/'.$arguments['code'].'Factory');
            }

            if(!$options['admin'] && $options['client']){
                Artisan::call('make:controller '.$arguments['module'].'/'.$arguments['code'].'Controller');
            }else{
                Artisan::call('make:controller --model='.$arguments['module'].'/'.$arguments['code'].$arguments['module'].' '.$arguments['module'].'/'.$arguments['code'].'Controller');
            }

            $this->info('Todos os recursos criados com sucesso!');

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
