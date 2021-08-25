<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleMakeResourcesClient extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-resources-client
        {module : Insert name the module}
        {code : Insert code the model}
        {--s|section : Create a section view in model}
        {--p|page : Create a page view in model}
        {--c|content : Create a content view in model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all client features';

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
                $this->error('O código informado já existe, continuar com o processo substituirá os arquivos atuais por arquivos padrões');
                if(!$this->confirm('Deseja continuar com o processo?')){
                    return;
                }
            }

            // Create views cliente

            $pathClient = 'resources/views/Client/';
            if(!is_dir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'])) mkdir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'], 0777, true);

            if($options['section']){
                if(copy('defaults/Client/archive/section.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/section.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/section.blade.php');
                }
            }
            if($options['page']){
                if(copy('defaults/Client/archive/page.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/page.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/page.blade.php');
                }
            }
            if($options['content']){
                if(copy('defaults/Client/archive/show.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/show.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/show.blade.php');
                }
            }

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
