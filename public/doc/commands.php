<?php include_once "_includes/header.php"; ?>
<div class="page-content">
    <div class="card ">
        <div class="card-body">

            <h4 class="mt-0 mb-2 font-weight-bold">Comandos</h4>
            <p>Abaixo lista de commandos artisan e suas funcionalidades</p>

            <div class="alert alert-info" role="alert">
                <p class="mb-0">
                    <strong>Importante:</strong> A nomeclatura <code>{code}</code> refere-se ao modelo de um módulo, então para criar novos modelos de um módulo deverá informa sempre um nome de módulo e logo o código. <br> Para
                    todos os comandos existe uma opção <code>--h|help</code> que informa quais parametros e opções existem.
                </p>
            </div>

            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th style="width:30%"><i class="ti-file"></i> Comando</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>php artisan module:list</code></td>
                        <td>
                            Lista todos os módulos e modelos (code) criados no sistema, o parametro opcional <code>{module}</code> pode ser usado para listar os modelos (code) desse módulo.
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make</code></td>
                        <td>Registra do módulo no sistema de acordo com o parametro <code>{module}</code> inserido<br><b>IMPORTANTE:</b> Deve ser o primeiro comando rodado para criação de <b>módulos</b></td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:model</code></td>
                        <td>
                            Cria os recursos do módulo inserido, o parametro <code>{module}</code> deve ser preenchido com o nome do modulo já registrado anteriormente, o parametro <code>{code}</code> deve ser preenchido com o
                            código informado no layout. Esse comando disponibiliza 5 opções:<br>
                            <code>{--s|section}</code> informa se deseja criar os recursos de sessão no site<br>
                            <code>{--p|page}</code> informa se deseja criar os recursos de página no site<br>
                            <code>{--c|content}</code> informa se deseja criar os recursos de página interna no site<br>
                            <code>{--admin}</code> Deverá ser informado para a criação de recursos para a administração (painel)<br>
                            <code>{--client}</code> Deverá ser informado para a criação de recursos para o cliente (site)
                            <br> As opções <code>{--s|section} {--p|page} {--c|content}</code> só serão rodadas caso a opções de <code>{--client}</code> for informada.
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make-resources-admin</code></td>
                        <td>
                            <b>IMPORTANTE: </b> Os novos recursos poderam substituir os recursos atuais.
                            <br>Cria os recursos de view para administração (painel) do modelo inserido, o parametro <code>{module}</code> deve ser preenchido com o nome do modulo já registrado anteriormente, o parametro
                            <code>{code}</code> deve ser preenchido com o código (modelo) já registrado anteriormente<br>
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make-resources-client</code></td>
                        <td>
                            <b>IMPORTANTE: </b> Os novos recursos poderam substituir os recursos atuais.
                            <br>Cria os recursos de view para cliente (site) do modelo inserido, o parametro <code>{module}</code> deve ser preenchido com o nome do modulo já registrado anteriormente, o parametro
                            <code>{code}</code> deve ser preenchido com o nome do modulo já registrado anteriormente. Esse comando disponibiliza 3 opções:<br>
                            <code>{--s|section}</code> informar se deseja criar os recursos de view para sessão no site<br>
                            <code>{--p|page}</code> informar se deseja criar os recursos de view para página no site<br>
                            <code>{--c|content}</code> informar se deseja criar os recursos de view para página interna no site<br>
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make-model</code></td>
                        <td>
                            Cria um novo model para o modelo informado, esse comando é muito identico ao padão do laravel make:model, a diferença é que o parametro <code>{module}</code> deve ser preenchido com o nome do modulo
                            já registrado anteriormente, o parametro
                            <code>{code}</code> deve ser preenchido com um código já registrado anteriormente e o parametro <code>{model}</code> deve ser preenchido com o nome do model que deseja criar.
                            <br>Esse comando disponibiliza 3 opções:
                            <code>{--m|migration}</code> informar se deseja criar uma migration<br>
                            <code>{--c|controller}</code> informar se deseja criar um controller<br>
                            <code>{--r|resource}</code> informar se deseja que o controller seja do tipo resource<br>
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make-controller</code></td>
                        <td>
                            Cria um novo controlador para o modulo informado, o parametro <code>{module}</code> deve ser preenchido com o nome do modulo já registrado anteriormente, o parametro
                            <code>{code}</code> deve ser preenchido com um código já registrado anteriormente
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make-migration</code></td>
                        <td>
                            Cria uma nova migration para o modulo e modelo (code) informado, o parametro <code>{module}</code> deve ser preenchido com o nome do modulo já registrado anteriormente, o parametro
                            <code>{code}</code> deve ser preenchido com um código já registrado anteriormente
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:make-core</code></td>
                        <td>
                            Nesse comando os módulos <code>{module}</code> já estão registrados que são <code>Headers</code> e <code>Footers</code> e o parametro <code>{module}</code> deverá constar um desses dois módulos, já o
                            parametro <code>{code}</code> deverá ser informado o código do layout. Esse comando criar exatamento o que o módulos são, Header e Footer do site, claro que deverão ser criados separadamente.
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:migrate</code></td>
                        <td>
                            Caso ele seja rodado sem nenhuma opção, roda todas as migrations dos módulos e modelos informado no arquivo de configuração do sistema, se informar as opções <code>{module}</code> e <code>{code}</code> ele rodará as migrations do módulo e modelo informado.
                            <br>Esse comando disponibiliza 2 opções:<br>
                            <code>{--s|seed}</code> Roda as seeds existentes<br>
                            <code>{--f|fresh}</code> Roda o comando migrate:fresh que deleta todas as tabelas e as criam novamente<br>
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:delete</code></td>
                        <td>
                            Deleta o módulo e seus modelos ou somente um modelo de um módulo, para isso você deve informar obrigatoriamente o parametro <code>{module}</code> e opcionalmente o parametro <code>{code}</code>.
                            <br>Use a opção <code>{--c|core}</code> para deletar os modelos dos módulos <code>Headers</code> ou <code>Footers</code>
                            <br>Use a opção <code>{--relation=}</code> para deletar um modelo de relacionamento. <b>IMPORTANTE: </b>Essa opção só irá funcionar caso o <code>{code}</code> seja informado.
                            <br>Exemplo de uso da opção <code>{--relation=}</code>.
                            <br><code>php artisan module:delete Articles ART01 --relation=ArticleCategory</code>
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:publish-assets</code></td>
                        <td>
                            Publica todos os assets (css, scss, js) dos modelos, deve ser rodado sempre que criar um novo modelo caso contrário seus estilos e funções não funcionaram. Esse comando é voltado para criação do frontend dos modelos rodado em conjunto com o
                            <code>npm run dev</code>, <code>npm run watch</code> ou <code>npm run watch-poll</code>
                        </td>
                    </tr>
                    <tr>
                        <td><code>php artisan module:publish</code></td>
                        <td>
                            Esse é o comando que irá preparar os arquivos para a publicação online do site, antes de rodar o comando você deverá realizar os Commits e Pushs das alterações realizada no site.
                            <br> O comando criará uma nova branch, caso não exista, com nome de <b>Publishing</b>, já nessa branch ele irá limpar todos os arquivos do sistema para que somente o que foi usado para a contrução do
                            site prevaleça.
                            <br> <b>IMPORTANTE: </b> A branch <b>Publishing</b> só deverá ser usada para a publicação online, seja no servidor de teste ou no domínio do cliente, caso tenha alguma alteração/ajustes deverá ser feita
                            na branch onde fez as configurações do site e depois rodar novamente o comando para publicação.
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3">
                <div class="alert alert-info mt-5">Se você tiver alguma dúvida ou dificuldade durante a configuração, não hesite em nos contatar. Teremos o maior prazer em ajudá-lo.</div>
            </div>
        </div>
    </div>

</div>
<?php include_once "_includes/footer.php"; ?>
