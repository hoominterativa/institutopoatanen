<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class ChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change Password developer user';

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
        $user = User::where('email', 'LIKE', '%developer@hoom.com.br%')->first();

        if(!$user) {
            $this->info('O Usuário de desenvolvedor não foi encontrado.');
            return;
        }

        $url = $this->ask('Insira a url do site. Ex: https://hoom.com.br');

        $password = self::generatePassword();
        $user->password = Hash::make($password);
        $user->save();

        $appName = config('app.name');

        $request = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJ0aWQiOjM0MzA4NjM4MCwiYWFpIjoxMSwidWlkIjoyMTg0MzIzMSwiaWFkIjoiMjAyNC0wNC0wNVQxNzo0ODoyOC4wNzJaIiwicGVyIjoibWU6d3JpdGUiLCJhY3RpZCI6ODc1MzYwNiwicmduIjoidXNlMSJ9.-mp87zX-QQhF-lZWkae-tj2jynn6OBS3mCtfwZylTVA')
        ->post('https://api.monday.com/v2', [
            'query' => '
                mutation {
                    create_item (
                        board_id: 6400389389,
                        group_id: "topics",
                        item_name: "'.$appName.'",
                        column_values: "{\"link_site2\":\"'.$url.'\",\"texto4\":\"developer@hoom.com.br\",\"texto\":\"'.$password.'\"}",
                    ) {
                        id
                    }
                }
            '
        ]);

        $this->info('Senha gerada e inserida no monday no quadro de --Acessos Painel--. A nova senha é: '.$password);
    }

    /**
     * Generates a random password of a specified length.
     *
     * @param int $tamanho The length of the password to generate (default: 9)
     * @return string The randomly generated password
     */
    public function generatePassword($tamanho=9)
    {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()-_=+';
        $senha = '';
        $len = strlen($caracteres);
        for ($i = 0; $i < $tamanho; $i++) {
            $senha .= $caracteres[rand(0, $len - 1)];
        }
        return $senha;
    }
}
