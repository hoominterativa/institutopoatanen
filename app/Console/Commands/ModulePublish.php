<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ModulePublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        shell_exec('git checkout -b Publishing');
        shell_exec('git commit -m "Site Publishing Branch"');
        shell_exec('git push --set-upstream origin Publishing');

        $this->newLine();

        $this->info('Branch Publishing criada com sucesso, publique o site a partir da mesma');
        $this->warn('Antes de publicar o site solicite a alteração da branch padrão do seu projeto para a branch Publishing.');
        return;
    }
}
