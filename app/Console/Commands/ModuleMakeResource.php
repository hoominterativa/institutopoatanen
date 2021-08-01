<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ModuleMakeResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-resources {module : Enter the name of the module for resource creation}
        {code : Insert code the model}
        {--s|section : Create a section view in model}
        {--p|page : Create a page view in model}
        {--c|content : Create a content view in model}
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
        $arguments = $this->arguments();
        $options = $this->options();

        try {
            // Create views Admin

            $pathAdmin = 'resources/views/Admin/';
            if(!is_dir($pathAdmin.$arguments['module'].'/'.$arguments['code'])) mkdir($pathAdmin.$arguments['module'].'/'.$arguments['code'], 0777, true);

            if(copy('defaults/Admin/archive/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/create.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/create.blade.php');
            }
            if(copy('defaults/Admin/archive/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/edit.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/edit.blade.php');
            }
            if(copy('defaults/Admin/archive/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/index.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/index.blade.php');
            }

            // Create routes
            if(!is_dir('routes/'.$arguments['module'])) mkdir('routes/'.$arguments['module'], 0777, true);
            if(copy('defaults/Routes/web.php', 'routes/'.$arguments['module'].'/'.$arguments['code'].'.php')){
                $this->info('Routes created routes/'.$arguments['module'].'/'.$arguments['code'].'.php');
            }

            // Create views client

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

            // Create assets
            if(!is_dir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/src')) mkdir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/src', 0777, true);

            if(copy('defaults/Client/src/_main.scss', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss')){
                $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/src/_main.scss');
            }
            if(copy('defaults/Client/src/main.js', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/src/main.js')){
                $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/src/main.js');
            }

            Artisan::call('make:controller '.$arguments['module'].'/'.$arguments['code'].'Controller');
            $this->info('Resources created successful!');

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
