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
            mkdir($pathAdmin.$arguments['module'].'/'.$arguments['code'], 0777, true);
            if(copy($pathAdmin.'copy/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/create.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/create.blade.php');
            }
            if(copy($pathAdmin.'copy/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/edit.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/edit.blade.php');
            }
            if(copy($pathAdmin.'copy/create.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/index.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/index.blade.php');
            }

            // Create views cliente

            $pathClient = 'resources/views/Client/';
            mkdir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'], 0777, true);
            if($options['section']){
                if(copy($pathClient.'copy/section.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/section.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/section.blade.php');
                }
            }
            if($options['page']){
                if(copy($pathClient.'copy/page.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/page.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/page.blade.php');
                }
            }
            if($options['content']){
                if(copy($pathClient.'copy/content.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/content.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/content.blade.php');
                }
            }

        }catch(Exception $e) {
            dd($e->getMessage());
        }

        // Artisan::call('make:migration '.$migration);

        $this->info('Resources created successful!');
    }
}
