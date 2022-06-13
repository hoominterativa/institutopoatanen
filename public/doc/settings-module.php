<?php include_once "_includes/header.php"; ?>
<div class="page-content">
    <div class="card ">
        <div class="card-body">
            <h1 class="mb-3 font-weight-bold">Configurando Modelos</h1>
            
            <div id="settingsModel">
                <div>
                    <p>
                       Após a criação do modelo devemos configura-lo para que seja possível a exibição do mesmo no site, essa configuração é feita atravéz do arquivo <code>config/modelsConfig.php</code>. 
                       Antes vamos entender como que funciona o arquivo de configuração dos modelos para exibição no site.
                    </p>
                    <p>
                        Existem três estruturas bases no arquivo de configuração, são elas: 
                        <a href="#InsertModelsCore" class="text-pink"><code>InsertModelsCore[]</code></a>, 
                        <a href="#InsertModelsMain" class="text-pink"><code>InsertModelsMain[]</code></a>, 
                        <a href="#Class" class="text-pink"><code>Class[]</code></a>
                    </p>

                    <h5 id="InsertModelsCore" class="mt-4"><b>Estrutura InsertModelsCore[]</b></h5>
                    <p>
                    A estrutura <code>InsertModelsCore[]</code> já tem um conteúdo pré definido e só deverá ser modificado substituindo o nome do modelo (Code) que será usado no site.
                    </p>
                    
                    <div class="docs_main bg-light p-2 mb-2">

<pre class="mb-0"><code class="language-php">&lt;?php
    'InsertModelsCore' => (object)[
        'Headers' => (object)[
            'Code' => 'HEAD01'
        ],
        'Footers' => (object)[
            'Code' => 'FOOT01'
        ]
    ]
?&gt;</code></pre>
                    </div>

                    <h5 id="InsertModelsMain" class="mt-4"><b>Estrutura InsertModelsMain[]</b></h5>
                    <p>
                        A estrutura <code>InsertModelsMain[]</code> é a estrutura principal para a montagem do site, um padrão deve ser seguido para que tudo funcione corretamente.
                        Você pode ver o conteúdo dessa estrutura no exemplo abaixo.
                    </p>
                    <div class="docs_main bg-light p-2 mb-2">

<pre class="mb-0"><code class="language-php">&lt;?php
    'InsertModelsMain' => (object) [
        'Module' => (object) [
            'Model' => (object)[
                'ViewHome' => 'Boolean',
                'ViewListMenu' => 'Boolean',
                'ViewListPanel' => 'Boolean',
                'IncludeCore' => 'Array',
                'config' => (object) [
                    'titleMenu' => 'string',
                    'anchor' =>  'Boolean',
                    'linkMenu' => 'route name',
                    'iconMenu' => 'string',
                    'titlePanel' => 'string',
                    'iconPanel' => 'string'
                ],
                'IncludeSections' => (object) [
                    'Module' => 'Model',
                    'Module' => 'Model',
                ]
            ],
        ],
    ]
?&gt;</code></pre>
                    </div>
                    <p>
                       Para um melhor entendimento dos indice na estrutura, listaremos abaixo cada uma com suas respectivas funcionalidade
                    </p>
                    <table class="table table-bordered m-0">
                        <thead>
                            <tr>
                                <th style="width:30%"><i class="ti-file"></i> Índice</th>
                                <th>Funcionalidade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><code>Module (Índice primário)</code></td>
                                <td>
                                    O índice primário deve conter o nome do Módulo.<br>
                                    <b>Obs.:</b> Este índice não pode ser duplicado.
                                </td>
                            </tr>
                            <tr>
                                <td><code>Model (Índice secundário)</code></td>
                                <td>
                                    O índice secundário deve conter o nome do Modelo (Código) pertencente ao Módulo informado no índice primário, ele recebe os indices de configuração do modelo. O Índice secundário pode ser duplicado mudando o nome do modelo (código) e as configurações.<br>
                                    A orderm de exibição das seções, tanto no site quanto nos menus e painel gerenciado, será a mesma inseridas no arquivo de configuração.<br>
                                    <b>Obs.:</b> Não repita o índice secundário com o mesmo nome de um modelo já existente.
                                </td>
                            </tr>
                            <tr>
                                <td><code>ViewHome</code></td>
                                <td>
                                    É possível que alguns modelos só tenham uma seção dedicada a página principal do site e outras que támbem tenham uma sessão dedicada a página principal do site e esse índice informa se o modelo deve exibir a seção na home ou não 
                                    é só utilizar <code>true</code> ou <code>false</code> como valores para o índice.
                                </td>
                            </tr>
                            <tr>
                                <td><code>ViewListMenu</code></td>
                                <td>
                                    Com os valores <code>true</code> ou <code>false</code> você informa ao sistema se o modelo vai exibir o link para a página interna no menu do topo, rodapé e do sidebar do site.
                                    Esse índice só terá um valor verdadeiro se o modelo informado tiver uma página interna para exibir caso contrário exibirá uma página em branco ou um 404 (Not Found).
                                </td>
                            </tr>
                            <tr>
                                <td><code>ViewListPanel</code></td>
                                <td>
                                    Provavelmente será sempre definido como verdadeiro, esse índice indica ao sistema que o modelo irá exibir os links de navegação no painel gerenciado do site.
                                </td>
                            </tr>
                            <tr>
                                <td><code>IncludeCore</code></td>
                                <td>
                                    <span class="bg-danger text-white p-1">Ainda em Desemvolvimento</span><br><br>
                                    Deverá criar um link colapsable no menu topo, rodapé e no sidebar do site
                                </td>
                            </tr>
                            <tr>
                                <td><code>config</code></td>
                                <td>Comporta as demais configurações de exibição do modelo.</td>
                            </tr>
                            <tr>
                                <td><code>titleMenu</code></td>
                                <td>
                                    Define qual título será exibido no menu do topo, rodapé e do sidebar. Lembre-se que o ídice <code>ViewListMenu</code> deve está definido como true
                                </td>
                            </tr>
                            <tr>
                                <td><code>anchor</code></td>
                                <td>
                                    Indica ao sistema se o link exibido no menu topo, rodapé e no sidebar será uma âncora ou não, caso seja definido como verdadeiro o índice <code>linkMenu</code> deve ser definido com o id da seção do modelo pertencente. Ex.: '#ARTI01'.
                                    Lembre-se que o ídice <code>ViewListMenu</code> deve está definido como true
                                </td>
                            </tr>
                            <tr>
                                <td><code>iconMenu | iconPanel</code></td>
                                <td>
                                    Como a lista dos links no menu é montado dinâmicamente, existe a possibilidade de um modelo ser criado com alguns icones, assim existiu esses índices.
                                    Ele deve ser definido com o código do icone da biblioteca <i>Material Icon Design</i>. Para visualizar a listagem de icones você deve, no painel gerenciador, navegar até o menu de suporte e clicar em icones.
                                    <br>Lembre-se que os ídice <code>ViewListPanel</code> e/ou <code>ViewListMenu</code> devem está definidos como true
                                </td>
                            </tr>
                            <tr>
                                <td><code>titlePanel</code></td>
                                <td>
                                    Assim como o <code>titleMenu</code> esse índice define qual título será exibido nos links do painel gerenciador. Lembre-se que o ídice <code>ViewListPanel</code> deve está definido como true
                                </td>
                            </tr>
                            <tr>
                                <td><code>IncludeSections</code></td>
                                <td>
                                    Geralmente as páginas de um site não só exibe o registros do modelo, ele pode também exibir as seções como uma indexação para o conteúdo dessa página.
                                    Nesse índice você pode, informar quais seções será inseridas junto a esse modelo definindo o array com o nome do Módulo e modelo. A ordem de exibição será a mesma do array.
                                    Essa estrutura funciona em conjunto com o metodo <code>IncludeSectionsPage()</code> do controlador <code>IncludeSectionsController.php</code>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="mt-3">
                        Todas as configurações informadas nessa área deveram ser definidas no layout de desenvolvimento do site. Então recomendamos fazer uma reunião com o design responsável para que todas as duvidas sejam tiradas.
                    </p>

                    <h5 id="Class" class="mt-4"><b>Estrutura Class[]</b></h5>
                    <div class="docs_main bg-light p-2 mb-2">

<pre class="mb-0"><code class="language-php">&lt;?php
    'Class' => (object) [
        'Module' => (object)[
            'Model' => (object)[
                'controller' => 'class controller',
                'model' => 'class model'
            ],
        ],
    ]
?&gt;</code></pre>
                    </div>
                    <p>
                        A estrutura <code>Class[]</code> é definida com as classes de controller e model. Ele deve ser preenchido sempre que um modelo for criado. <br>
                        Essa estrutura é de suma importância para o sistema pois ela definirá as class dos modelos para que seja possível consultas e renderizações mais rápidas no sistemas.
                        O valor a ser inserido deve ser o namespace completo da classe. <br>
                        Segue exemplo abaixo:
                    </p>
<pre><code class="lang-php">'Articles' => (object)[
    'ARTI01' => (object)[
        'controller' => App\Http\Controllers\Articles\ARTI01Controller::class,
        'model' => App\Models\Articles\ARTI01Services::class
    ],
],</code></pre>
                    
                </div>
            </div>
            <h5 id="InsertModelsMain" class="mt-4"><b>Exemplo Completo do arquivo <code>modelsConfig.php</code></b></h5>
            <div class="docs_main bg-light p-2 mb-2">

<pre class="mb-0"><code class="language-php">&lt;?php
    return [
        'InsertModelsCore' => (object)[
            'Headers' => (object)[
                'Code' => 'HEAD01'
            ],
            'Footers' => (object)[
                'Code' => 'FOOT01'
            ]
        ],

        'InsertModelsMain' => (object) [
            'Articles' => (object) [
                'ARTI01' => (object)[
                    'ViewHome' => true,
                    'ViewListMenu' => true,
                    'ViewListPanel' => true,
                    'IncludeCore' => [],
                    'config' => (object) [
                        'titleMenu' => 'Artigos',
                        'anchor' =>  false,
                        'linkMenu' => 'arti01.page',
                        'iconMenu' => '',
                        'titlePanel' => 'Artigos',
                        'iconPanel' => 'mdi-article-circle'
                    ],
                    'IncludeSections' => (object) [
                        'Topics' => 'TOPI01',
                        'Socials' => 'SOCI03',
                    ]
                ],
            ],
            'Topics' => (object) [
                'TOPI01' => (object)[
                    'ViewHome' => true,
                    'ViewListMenu' => false,
                    'ViewListPanel' => true,
                    'IncludeCore' => [],
                    'config' => (object) [
                        'titleMenu' => '',
                        'anchor' =>  false,
                        'linkMenu' => '',
                        'iconMenu' => '',
                        'titlePanel' => 'Tópicos',
                        'iconPanel' => 'mdi-topic-circle'
                    ],
                    'IncludeSections' => (object) []
                ],
            ],
            'Socials' => (object) [
                'SOCI01' => (object)[
                    'ViewHome' => true,
                    'ViewListMenu' => false,
                    'ViewListPanel' => true,
                    'IncludeCore' => [],
                    'config' => (object) [
                        'titleMenu' => '',
                        'anchor' =>  false,
                        'linkMenu' => '',
                        'iconMenu' => '',
                        'titlePanel' => 'Redes Sociais',
                        'iconPanel' => 'mdi-network'
                    ],
                    'IncludeSections' => (object) []
                ],
            ],
        ],

        'Class' => (object) [
            'Articles' => (object)[
                'ARTI01' => (object)[
                    'controller' => App\Http\Controllers\Articles\ARTI01Controller::class,
                    'model' => App\Models\Articles\ARTI01Services::class
                ],
                'ARTI01' => (object)[
                    'controller' => App\Http\Controllers\Articles\ARTI02Controller::class,
                    'model' => App\Models\Articles\ARTI02Services::class
                ],
            ],
            'Topics' => (object)[
                'TOPI01' => (object)[
                    'controller' => App\Http\Controllers\Topics\TOPI01Controller::class,
                    'model' => App\Models\Topics\TOPI01Services::class
                ],
            ],
            'Socials' => (object)[
                'SOCI01' => (object)[
                    'controller' => App\Http\Controllers\Socials\SOCI01Controller::class,
                    'model' => App\Models\Socials\SOCI01Services::class
                ],
                'SOCI02' => (object)[
                    'controller' => App\Http\Controllers\Socials\SOCI02Controller::class,
                    'model' => App\Models\Socials\SOCI02Services::class
                ],
                'SOCI03' => (object)[
                    'controller' => App\Http\Controllers\Socials\SOCI03Controller::class,
                    'model' => App\Models\Socials\SOCI03Services::class
                ],
            ],
        ]
    ]
?&gt;</code></pre>
                    </div>
            <div>
                <div class="alert alert-info mt-3">Se você tiver alguma dúvida ou dificuldade durante a configuração, não hesite em nos contatar. Teremos o maior prazer em ajudá-lo.</div>
            </div>
        </div>
    </div>

</div>
<?php include_once "_includes/footer.php"; ?>