<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleModelRelation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:model-relation
        {module : Insert module the father the model relational}
        {code : Insert code the father the model relational}
        {--relation= : Insert name the model relational}

    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert model relational in module specified';

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
        $codeRelation = $arguments['code'].$options['relation'];

        try{
            if(!$options['relation']){
                $this->error('"--relation=" Inexistente');
                $this->error('É necessário inserir o nome do modelo de relacionamento');
                return;
            }

            if($helper->searchModulesJson($arguments['module'], $codeRelation)){
                $this->error('O código relacional informado já existe');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                return;
            }

            if(!$helper->refreshModulesJson($arguments['module'], $codeRelation)){
                $this->error('Erro ao atualizar o arquivo modules.json');
                $this->info('Ignorar esse erro resultará no má funcionamento do sistema');
                return;
            }

            // Create views Admin
            $pathAdmin = 'resources/views/Admin/cruds/'.$arguments['module'].'/'.$arguments['code'].'/';

            if(!is_dir($pathAdmin.$options['relation'])) mkdir($pathAdmin.$options['relation'], 0777, true);

            if(copy('defaults/Admin/archive/create.blade.php', $pathAdmin.$options['relation'].'/create.blade.php')){
                $this->info('Recurso criado '.$pathAdmin.$options['relation'].'/create.blade.php');
            }
            if(copy('defaults/Admin/archive/edit.blade.php', $pathAdmin.$options['relation'].'/edit.blade.php')){
                $this->info('Recurso criado '.$pathAdmin.$options['relation'].'/edit.blade.php');
            }
            if(copy('defaults/Admin/archive/index.blade.php', $pathAdmin.$options['relation'].'/index.blade.php')){
                $this->info('Recurso criado '.$pathAdmin.$options['relation'].'/index.blade.php');
            }
            if(copy('defaults/Admin/archive/form.blade.php', $pathAdmin.$options['relation'].'/form.blade.php')){
                $this->info('Recurso criado '.$pathAdmin.$options['relation'].'/form.blade.php');
            }

            $lowerModule = Str::lower($arguments['module']);
            $lowerModel = Str::lower($arguments['code']);
            $lowerRelation = Str::lower($options['relation']);
            $nameMigration = 'create_'. $lowerModel.'_'.$lowerModule .'_'.$lowerRelation.'_table';

            Artisan::call('make:model '.$arguments['module'].'/'.$arguments['code'].$arguments['module'].$options['relation']);
            Artisan::call('make:migration '.$nameMigration.' --path=database/migrations/'.$arguments['module'].'/'.$arguments['code']);
            Artisan::call('make:seeder '.$arguments['code'].$arguments['module'].$options['relation'].'Seeder');
            Artisan::call('make:factory '.$arguments['code'].$arguments['module'].$options['relation'].'Factory --model='.$arguments['code'].$arguments['module'].$options['relation']);
            Artisan::call('make:controller --model='.$arguments['module'].'/'.$arguments['code'].$arguments['module'].$options['relation'].' '.$arguments['module'].'/'.$arguments['code'].$options['relation'].'Controller');

            $this->info('Todos os recursos criados com sucesso!');

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
