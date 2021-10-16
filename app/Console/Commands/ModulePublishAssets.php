<?php

namespace App\Console\Commands;

use App\Http\Controllers\Helpers\HelperPublishing;
use Illuminate\Console\Command;

class ModulePublishAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:publish-assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes all module assets';

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
        $helperPublishing = new HelperPublishing();
        $return = $helperPublishing->createScssApp();
        if($return === true){
            $this->info("Assets published successful");
            return;
        }
        $this->error($return);
    }
}
