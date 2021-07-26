<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

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
        $arguments = $this->arguments();
        $options = $this->options();

        try {
            // Create views cliente

            $pathClient = 'resources/views/Client/';
            if(!is_dir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'])) mkdir($pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'], 0777, true);

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
                if(copy($pathClient.'copy/show.blade.php', $pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/show.blade.php')){
                    $this->info('Resource created '.$pathClient.'pages/'.$arguments['module'].'/'.$arguments['code'].'/show.blade.php');
                }
            }

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
