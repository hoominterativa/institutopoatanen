<?php include_once "_includes/header.php"; ?>
<div class="page-content">
    <div class="card ">
        <div class="card-body">

            <h4 class="mt-0 mb-2 font-weight-bold">Configurando</h4>

            <div class="alert alert-info" role="alert">
                <p class="mb-0">
                    <strong>Obs.:</strong> Todos os requisitos citados nessa documentação é de extrema importância para o bom funcionamento do sistema. Siga e tudo que fizer dará certo :D.
                </p>
            </div>

            <h4 class="mt-4">Pré requisitos</h4>

            <p>Siga as etapas abaixo para instalar e configurar todos os pré-requisitos:</p>

            <ul>
                <li>
                    <h5>Composer</h5>
                    <p class="mb-2">Para intalar todas as dependências do sistema é necessário ter o composer instalado na sua máquina. Se você ainda não tem o Composer instalado, pode obtê-lo baixando o instalador no site oficial</p>
                    <a href="https://getcomposer.org/download/" target="_blank">Baixe o Composer</a>
                </li>
                <li>
                    <h5>Node.js</h5>
                    <p class="mb-2">Para usar as ferramentas de construção, você precisará baixar e instalar o Node.js. Se você ainda não tem o Node.js instalado, pode obtê-lo baixando o instalador do pacote no site oficial. Baixe a versão estável
                        do Node.js (LTS).</p>
                    <a href="https://nodejs.org/" target="_blank">Baixe o Node.js</a>
                </li>
                <li>
                    <h5>Git Desktop</h5>
                    <p>Certifique-se de ter o
                        <a href="https://desktop.github.com/" target="_blank"></a>Git Desktop</a> instalado e funcionando em seu computador. Se você já instalou o git desktop em seu computador, pode pular esta etapa</p>
                </li>
                <li>
                    <h5>Apache, phpmyadmin (Mysql) e PHP 7.4^</h5>
                    <p>Para gerenciamento do banco de dados se faz necessário um ambiente com apache, você pode usar quaisquer programa que tenha esses ambientes (Xampp, Wampp etc)</p>
                </li>
            </ul>
            <h4 class="mt-4">Instalação</h4>
            <p>Certifique-se de que o repositório esteja compartilhado com você, caso sim, deverá clonar o mesmo em uma pasta de sua escolha, caso contrário, deverá fazer a solicitação ao supervisor do TI.</p>
            <p class="mt-1">Após fazer o clone do repositório na pasta de sua escolha, abra um terminal na pasta onde você clonou o repositório e rode os comando na ordem abaixo:</p>
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th style="width:40%"><i class="ti-file"></i> Command</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>composer install</code></td>
                        <td>Instala todas a dependências backend do seu projeto</td>
                    </tr>

                    <tr>
                        <td><code>npm install</code></td>
                        <td>Instala todas a dependências frontend do seu projeto</td>
                    </tr>

                    <tr>
                        <td><code>composer run post-root-package-install</code></td>
                        <td>Cria o arquivo <code>.env</code></td>
                    </tr>

                    <tr>
                        <td><code>composer run post-create-project-cmd</code></td>
                        <td>Gera a key para o projeto laravel</td>
                    </tr>

                    <tr>
                        <td><code>php artisan storage:link</code></td>
                        <td>Cria um link simbolico para a pasta public do storage onde se encontra os arquivos upados pelo gerenciador</td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3">
                <p class="mb-1">Pronto, se tudo deu certo o sistema está pronto para ser usado. Seguiremos para a próxima etapa.</p>
                <div class="alert alert-info mt-5">Se você tiver alguma dúvida ou dificuldade durante a configuração, não hesite em nos contatar. Teremos o maior prazer em ajudá-lo.</div>
            </div>
        </div>
    </div>
</div>
<?php include_once "_includes/footer.php"; ?>