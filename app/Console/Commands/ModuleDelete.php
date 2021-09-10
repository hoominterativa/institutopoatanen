<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleDelete extends Command
{
    protected array $path = [
        "controller" => "app/Http/Controllers/",
        "models" => "app/Models/",
        "factories" => "database/factories/",
        "seeders" => "database/seeders/",
        "migrations" => "database/migrations/",
        "admin" => "resources/views/Admin/",
        "client" => "resources/views/Client/pages/",
        "core" => "resources/views/Client/Core/",
        "routes" => "routes/",
    ];


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:delete
        {module : Insert name the module}
        {code? : Insert code the model}
        {--c|core : if the module to be deleted is a footer or a header}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete module or model';

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
            $arrayModule = $helper->listModules();

            if(!$this->confirm('Esta ação não poderá ser desfeita, deseja continuar?')){
                return;
            }

            if(!$helper->searchModulesJson($arguments['module'])){
                $this->error('O Módulo informado não existe ou sua escrita está incorreta');
                $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                return;
            }

            if($arguments['code']){
                if(!$helper->searchModulesJson($arguments['module'], $arguments['code'])){
                    $this->error('O Modelo informado não existe ou sua escrita está incorreta');
                    $this->comment('Use o camando artisan module:list para visualizar os módulos e códigos existentes.');
                    return;
                }
            }

            if($arguments['code']){
                $indexRemove = array_search($arguments['code'] ,$arrayModule[$arguments['module']]);
                unset($arrayModule[$arguments['module']][$indexRemove]);
            }else{
                unset($arrayModule[$arguments['module']]);
            }

            $newJson = json_encode($arrayModule, JSON_PRETTY_PRINT);
            $file = fopen('modules.json','w');
            $written = fwrite($file, $newJson);
            fclose($file);

            if(!$written){
                $this->error('Erro ao atualizar o arquivo modules.json');
                return;
            }

            // If code true, delete a model else delete module
            if($arguments['code']){
                // Delete Core (Headers/Footers)
                if($options['core']){
                    if(is_dir($this->path['core'].$arguments['module'].'/'.$arguments['code'])) shell_exec('rm -r '.$this->path['core'].$arguments['module'].'/'.$arguments['code']);
                    $this->info($arguments['module'].'/'.$arguments['code'].' deletado com sucesso');
                    return;
                }

                // Delete Folders
                if(is_dir($this->path['migrations'].$arguments['module'].'/'.$arguments['code'])) shell_exec('rm -r '.$this->path['migrations'].$arguments['module'].'/'.$arguments['code']);
                if(is_dir($this->path['admin'].$arguments['module'].'/'.$arguments['code'])) shell_exec('rm -r '.$this->path['admin'].$arguments['module'].'/'.$arguments['code']);
                if(is_dir($this->path['client'].$arguments['module'].'/'.$arguments['code'])) shell_exec('rm -r '.$this->path['client'].$arguments['module'].'/'.$arguments['code']);

                // Delete archives
                if(file_exists($this->path['models'].$arguments['module'].'/'.$arguments['code'].$arguments['module'].'.php')) unlink($this->path['models'].$arguments['module'].'/'.$arguments['code'].$arguments['module'].'.php');
                if(file_exists($this->path['controller'].$arguments['module'].'/'.$arguments['code'].'Controller.php')) unlink($this->path['controller'].$arguments['module'].'/'.$arguments['code'].'Controller.php');
                if(file_exists($this->path['routes'].$arguments['module'].'/'.$arguments['code'].'.php')) unlink($this->path['routes'].$arguments['module'].'/'.$arguments['code'].'.php');
                if(file_exists($this->path['factories'].$arguments['module'].'/'.$arguments['code'].'Factory.php')) unlink($this->path['factories'].$arguments['module'].'/'.$arguments['code'].'Factory.php');
                if(file_exists($this->path['seeders'].$arguments['module'].'/'.$arguments['code'].'Seeder.php')) unlink($this->path['seeders'].$arguments['module'].'/'.$arguments['code'].'Seeder.php');


                $this->info($arguments['module'].'/'.$arguments['code'].' deletado com sucesso');
                $this->info('A tabela no banco de dados deverá ser deletada manualmente.');
                return;

            }else{

                // Delete Folders
                if(is_dir($this->path['admin'].$arguments['module'])) shell_exec('rm -r '.$this->path['admin'].$arguments['module']);
                if(is_dir($this->path['client'].$arguments['module'])) shell_exec('rm -r '.$this->path['client'].$arguments['module']);
                if(is_dir($this->path['routes'].$arguments['module'])) shell_exec('rm -r '.$this->path['routes'].$arguments['module']);
                if(is_dir($this->path['controller'].$arguments['module'])) shell_exec('rm -r '.$this->path['controller'].$arguments['module']);
                if(is_dir($this->path['models'].$arguments['module'])) shell_exec('rm -r '.$this->path['models'].$arguments['module']);
                if(is_dir($this->path['factories'].$arguments['module'])) shell_exec('rm -r '.$this->path['factories'].$arguments['module']);
                if(is_dir($this->path['seeders'].$arguments['module'])) shell_exec('rm -r '.$this->path['seeders'].$arguments['module']);
                if(is_dir($this->path['migrations'].$arguments['module'])) shell_exec('rm -r '.$this->path['migrations'].$arguments['module']);

                $this->info($arguments['module'].' deletado com sucesso');
                $this->info('As tabelas no banco de dados deverão ser deletadas manualmente.');
                return;
            }

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
