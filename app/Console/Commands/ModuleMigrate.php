<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ModuleMigrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:migrate
        {module? : Insert model name}
        {code? : Insert model code}
        {--f|fresh : run the command with :fresh}
        {--s|seed : run the command with --seed}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Perform one or all migrations';

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
        $InsertModelsMain = config('modelsConfig.InsertModelsMain');
        $relations = config('modelsConfig.Relations');

        try {

            if($arguments['module']){
                if($arguments['code']){
                    Artisan::call('migrate --path=database/migrations/'.$arguments['module'].'/'.$arguments['code']);
                    $this->info('Migrado com sucesso');
                    return;
                }else{
                    $this->info('O código do modelo não deve ser vazio');
                    return;
                }
            }

            if($options['fresh']){
                Artisan::call('migrate:fresh');
            }else{
                Artisan::call('migrate');
            }

            $bar = $this->output->createProgressBar(count(get_object_vars($InsertModelsMain)));
            $bar->start();

            foreach ($InsertModelsMain as $module => $model) {
                foreach ($model as $code => $config) {

                    if(isset($relations->$module[$code])){
                        $relation = $relations->$module[$code];
                        foreach ($relation->before as $moduleRelationBefore => $modelRelationBefore) {
                            Artisan::call('migrate --path=database/migrations/'.$moduleRelationBefore.'/'.$modelRelationBefore);
                        }
                    }

                    Artisan::call('migrate --path=database/migrations/'.$module.'/'.$code);

                    if(isset($relations->$module[$code])){
                        foreach ($relation->after as $moduleRelationAfter => $modelRelationAfter) {
                            Artisan::call('migrate --path=database/migrations/'.$moduleRelationAfter.'/'.$modelRelationAfter);
                        }
                    }
                }
            }

            $bar->finish();

            if($options['seed']){
                Artisan::call('migrate --seed');
            }
            $this->newLine();
            $this->info('Todas as migrations necessárias foram migradas com sucesso');

        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
