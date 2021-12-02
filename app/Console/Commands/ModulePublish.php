<?php

namespace App\Console\Commands;

use Exception;
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
        try {
            if(!$this->confirm('ATENÇÃO: Já realizou o commit e push das alterações realizadas?')){
                return;
            }

            $bar = $this->output->createProgressBar();

            $this->comment('Verificando se a branch Publishing existe');
            $verifyBranch = shell_exec('git rev-parse --verify Publishing');
            $bar->advance();

            if($verifyBranch){

                $this->comment('Migrando para a branch Publishing');
                shell_exec('git checkout Publishing');
                $bar->advance();

                $this->comment('Atualizando a branch Publishing a partir da Developer');
                shell_exec('git merge feature/developer');
                $bar->advance();

            }else{

                $this->comment('Criando e migrando a branch Publishing');
                shell_exec('git checkout -b Publishing');
                $bar->advance();

            }
            /**
             * Cleans all system files for online publication the website
            */

            $this->comment('Limpando Arquivos');
            $bar->advance();

            /**
             * End Clear
            */

            $this->comment('Adicionando as alterações para realização do commit');
            shell_exec('git add .');
            $bar->advance();

            $this->comment('Subindo as alterações');
            shell_exec('git commit -m "Site Publishing Branch"');
            $bar->advance();

            $this->comment('Publicando as alterações na branch Publishing');
            shell_exec('git push --set-upstream origin Publishing');
            $bar->advance();

            $bar->finish();

            $this->newLine();

            $this->info('Branch Publishing criada com sucesso, publique o site a partir da mesma');
            $this->warn('Antes de publicar o site solicite a alteração da branch padrão do seu projeto para a branch Publishing.');
            return;
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
