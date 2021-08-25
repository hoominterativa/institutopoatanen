<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Helpers\HelperModule;

class ModuleList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:list
    {module? : [optional] Enter the module name to list your models}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all or a module and its codes';

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
        $helper = new HelperModule();

        $listModules = $helper->listModules($arguments['module']);

        if(!is_array($listModules)){
            $this->error($listModules);
            return;
        }

        if(count($listModules)<=0) $this->info("Nenhum módulo encontrado.");

        foreach ($listModules as $key => $value) {
            $this->newLine();
            $this->comment($key);
            $this->line(implode(',',$value));
        }
    }
}
