<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class ModuleMakeResourcesAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:make-resources-admin
        {module : Insert name the module}
        {code : Insert code the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all admin features';

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
            if(copy('defaults/Admin/archive/form.blade.php', $pathAdmin.$arguments['module'].'/'.$arguments['code'].'/form.blade.php')){
                $this->info('Resource created '.$pathAdmin.$arguments['module'].'/'.$arguments['code'].'/form.blade.php');
            }

        }catch(Exception $e) {
            dd($e->getMessage());
        }
    }
}
