<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

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
        $arguments = $this->arguments();

        try {
            $pathCore = 'resources/views/Client/Core/';
            if(!is_dir($pathCore.$arguments['module'].'/'.$arguments['code'])) mkdir($pathCore.$arguments['module'].'/'.$arguments['code'], 0777, true);
            if(!is_dir($pathCore.$arguments['module'].'/'.$arguments['code'].'/src')) mkdir($pathCore.$arguments['module'].'/'.$arguments['code'].'/src', 0777, true);

            if(copy('defaults/Client/archive/app.blade.php', $pathCore.$arguments['module'].'/'.$arguments['code'].'/app.blade.php')){
                $this->info('Resource created '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/app.blade.php');
            }
            if(copy('defaults/Client/src/_main.scss', $pathCore.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss')){
                $this->info('Resource created '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss');
            }
            if(copy('defaults/Client/src/main.js', $pathCore.$arguments['module'].'/'.$arguments['code'].'/src/main.js')){
                $this->info('Resource created '.$pathCore.$arguments['module'].'/'.$arguments['code'].'/src/main.js');
            }
        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
