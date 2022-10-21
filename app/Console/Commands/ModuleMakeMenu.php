<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class ModuleMakeMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-menu {name : insert code the model (Ex.: MENU01)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create menu resources';

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

        try {
            $pathMenu = 'resources/views/Client/Components/themeMenu/';

            if(is_dir($pathMenu.$arguments['name'])){
                $this->info('O Modelo informado já existe, tente inserir a proxima sequência numeral do modelo.');
                return;
            }

            if(!is_dir($pathMenu.$arguments['name'])) mkdir($pathMenu.$arguments['name'], 0777, true);
            if(!is_dir($pathMenu.$arguments['name'].'/src')) mkdir($pathMenu.$arguments['name'].'/src', 0777, true);

            if(copy('defaults/Client/archive/structure.blade.php', $pathMenu.$arguments['name'].'/structure.blade.php')){
                $this->info('Recurso criado '.$pathMenu.$arguments['name'].'/structure.blade.php');
            }
            if(copy('defaults/Client/src/_main.scss', $pathMenu.$arguments['name'].'/src/_main.scss')){
                $this->info('Recurso criado '.$pathMenu.$arguments['name'].'/src/_main.scss');
            }
            if(copy('defaults/Client/src/_variables.scss', $pathMenu.$arguments['name'].'/src/_variables.scss')){
                $this->info('Recurso criado '.$pathMenu.$arguments['name'].'/src/_variables.scss');
            }
            if(copy('defaults/Client/src/main.js', $pathMenu.$arguments['name'].'/src/main.js')){
                $this->info('Recurso criado '.$pathMenu.$arguments['name'].'/src/main.js');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
