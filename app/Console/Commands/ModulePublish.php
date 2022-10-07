<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class ModulePublish extends Command
{
    protected $signature = 'module:publish';
    protected $pathsDirectories = [
        'clientPages' => 'resources/views/Client/pages/',
        'adminCruds' => 'resources/views/Admin/cruds/',
        'controllers' => 'app/Http/Controllers/',
        'migrations' => 'database/migrations/',
        'models' => 'app/Models/',
        'routes' => 'routes/',
    ];
    protected $pathsFiles = [
        'factories' => 'database/factories/',
    ];
    protected $pathsCore = [
        'resources/views/Client/Core/Footers',
        'resources/views/Client/Core/Headers'
    ];
    protected $rootDirectory = ['stubs', 'defaults', 'app/Console/Commands', 'modules.json'];
    protected $exception = [
        'contactForm',
        'contactLead',
        'generalSetting',
        'Optimization',
        'OptimizePage',
        'User',
        'Helpers',
        'UserFactory.php',
        'ContactFormSeeder.php',
        'GeneralSettingSeeder.php',
        'OptimizationSeeder.php',
        'SettingThemeSeeder.php',
        'DatabaseSeeder.php',
    ];

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create branch to publishing';

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
        $InsertModelsCore = config('modelsConfig.InsertModelsCore');
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $ModelsForm = config('modelsConfig.ModelsForm');
        $arrayModelsMain = get_object_vars($InsertModelsMain);
        $arrayModelsCore = get_object_vars($InsertModelsCore);
        $arrayModelsForm = get_object_vars($ModelsForm);

        try {
            if(!$this->confirm('ATENÇÃO: Já realizou o commit e push das alterações realizadas?')){
                return;
            }

            $this->comment('Verificando se a branch Publishing existe');
            $verifyBranch = shell_exec('git rev-parse --verify Publishing');

            if($verifyBranch){

                $this->comment('Branch Publishing encontrada');
                $this->newLine();
                $this->comment('Migrando para a branch Publishing');
                shell_exec('git checkout Publishing');

                $this->comment('Atualizando a branch Publishing à partir da Developer');
                shell_exec('git merge feature/developer');

            }else{
                $this->comment('Branch Publishing não encontrada');
                $this->newLine();
                $this->comment('Criando e migrando a branch Publishing');
                shell_exec('git checkout -b Publishing');

            }

            /**
             * Cleans all system files for online publication the website
            */

            $this->comment('Limpando Arquivos');
            $totalProcess = (count($this->rootDirectory) + count($this->pathsCore) + count($this->pathsFiles) + count($this->pathsDirectories));
            $bar = $this->output->createProgressBar($totalProcess);

            $bar->start();
            $this->newLine();

            // Exclude directories and files the modules
            foreach ($this->pathsCore as $pathCore) {
                $directories = array_diff(scandir($pathCore), array('..', '.'));
                $Module = explode('/', $pathCore);
                foreach ($directories as $dir) {
                    if(!array_search($dir, get_object_vars($arrayModelsCore[end($Module)]))){
                        if(is_dir($pathCore.'/'.$dir) && !array_keys($this->exception, $dir)){
                            rmdir($pathCore.'/'.$dir);
                            $this->info($pathCore.'/'.$dir);
                        }
                    }
                }
                $bar->advance();
            }

            foreach ($this->pathsDirectories as $pathDir) {

                $directories = array_diff(scandir($pathDir), array('..', '.'));

                foreach ($directories as $dir) {
                    if(!array_key_exists($dir, $arrayModelsForm)){
                        if(!array_key_exists($dir, $arrayModelsMain)){
                            if(is_dir($pathDir.$dir) && !array_keys($this->exception, $dir)){
                                rmdir($pathDir.$dir);
                                $this->info($pathDir.$dir);
                            }
                        }
                    }
                }

                foreach ($InsertModelsMain as $module => $models) {
                    if(is_dir($pathDir.$module)){
                        $directories = array_diff(scandir($pathDir.$module), array('..', '.'));
                        foreach ($directories as $dir) {
                            if(!array_key_exists($dir, get_object_vars($arrayModelsForm[$module]))){
                                if(!array_key_exists($dir, get_object_vars($models))){
                                    if(is_dir($pathDir.$module.'/'.$dir)){
                                        rmdir($pathDir.$dir);
                                        $this->info($pathDir.$dir);
                                    }else{
                                        foreach ($directories as $file) {
                                            if(!is_dir($pathDir.$module.'/'.$file) && !array_keys($this->exception, $file)){
                                                foreach ($models as $code => $config) {
                                                    if(strstr($file, $code)){
                                                        $index = array_search($file ,$directories);
                                                        unset($directories[$index]);
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        foreach ($directories as $file) {
                                            if(!is_dir($pathDir.$module.'/'.$file) && !array_keys($this->exception, $file)){
                                                unlink($pathDir.$module.'/'.$file);
                                                $this->info($pathDir.$module.'/'.$file);
                                            }
                                        }
                                        break;
                                    }
                                }
                            }
                        }
                    }
                }
                $bar->advance();
            }

            // Exclude files from unused modules
            foreach ($this->pathsFiles as $pathFile) {
                $folders = array_diff(scandir($pathFile), array('..', '.'));
                foreach ($folders as $folder) {
                    $files = array_diff(scandir($pathFile.$folder), array('..', '.'));
                    foreach ($files as $file) {
                        if(!is_dir($pathFile.$folder.'/'.$file) && !array_keys($this->exception, $file)){
                            foreach ($InsertModelsMain as $module => $models) {
                                if(strstr($file, $module)){
                                    $index = array_search($file ,$files);
                                    unset($files[$index]);
                                    break;
                                }
                            }
                        }
                    }

                    foreach ($files as $file) {
                        if(!is_dir($pathFile.$folder.'/'.$file) && !array_keys($this->exception, $file)){
                            unlink($pathFile.$folder.'/'.$file);
                            $this->info($pathFile.$folder.'/'.$file);
                        }
                    }

                    $bar->advance();
                }
            }

            foreach ($this->rootDirectory as $dir) {
                if(!is_dir($dir)){
                    unlink($dir);
                }else{
                    rmdir($dir);
                }
                $this->info($dir);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();

            /**
             * End Clear
            */

            // $this->comment('Adicionando as alterações para realização do commit');
            // shell_exec('git add .');

            // $this->comment('Subindo as alterações');
            // shell_exec('git commit -m "Site Publishing Branch"');

            // $this->comment('Publicando as alterações na branch Publishing');
            // shell_exec('git push --set-upstream origin Publishing');

            // $this->newLine();

            // $this->comment('Branch Publishing criada com sucesso, publique o site a partir da mesma');
            // $this->comment('Antes de publicar o site solicite a alteração da branch padrão do seu projeto para a branch Publishing.');
            return;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
