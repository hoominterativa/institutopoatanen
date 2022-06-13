<?php include_once "_includes/header.php"; ?>
<div class="page-content">
    <div class="card ">
        <div class="card-body">
            <h1 class="mb-3 font-weight-bold">Criando Módulos e Modelos</h1>
            <ul class="list-inline pl-4">
                <li>
                    <a href="#introduction" class="text-secondary"><b><i class="text-danger mr-1 font-18">#</i>Introdução</b></a>
                </li>
                <li>
                    <a href="#registerModule" class="text-secondary"><b><i class="text-danger mr-1 font-18">#</i>Registrando Módulo</b></a>
                </li>
                <li>
                    <a href="#creatingModels" class="text-secondary"><b><i class="text-danger mr-1 font-18">#</i>Criação de Modelos</b></a>
                    <ul class="my-2 list-inline pl-4">
                        <li><a href="#listModels" class="text-secondary"><i class="text-danger mr-1">#</i> Listando Modelo</a></li>
                        <li><a href="#creatingModel" class="text-secondary"><i class="text-danger mr-1">#</i> Criando Modelo</a></li>
                    </ul>
                </li>
            </ul>
            <div id="introduction">
                <h3 class="mt-4"><b><i class="text-danger mr-1">#</i> Introdução</b></h3>
                <div class="pl-3">
                    <p>
                        A construção de CRUDs se manteve a padrão do Láravel com algumas particularidades do sistemas. Para a criação dos módulo você deverá ter conhecimento dos <a href="commands.php"><b>comandos</b></a> explicados na página da mesma.
                        <br> Antes de começar a de fato contruir o Módulo/Modelo você deverá chamar para uma pequena reunião o design responsável pelo sistema para entender como que o módulo deve funcionar.
                        <br><br> A ordem de Backend e Frontend começarem a fazer o Módulo/Modelo não importa, o ideal é que os dois trabalhem simutaneamente pois se o modelo necessitar de adição de novas rotas se fará necessário o conhecimento das rotas do sistema.
                    </p>
                    <p>Nos exemplos abaixo usaremos como base o módulo <b>Articles</b></p>
                </div>
            </div>
            <div id="registerModule">
                <h3 class="mt-4"><b><i class="text-danger mr-1">#</i> Registrando Módulo</b></h3>
                <div class="pl-3">
                    <p>
                        Como passo principal na criação dos módulos e modelos, o registro do módulo inicia o trabalho no sistema.
                        <br> Depois de se informar com o design como que funciona o Módulo e seus modelos é hora de registrar o Módulo no sistema. Para fazer isso você pode rodar o comando artisan <code>module:make</code> inserindo o nome do módulo.
                        Caso seja necessário você poderá rodar o comando artisan <code>module:list</code> para se informar quais módulos já foram registrado no sistema.
                        <br><b>IMPORTANTE: </b> Todos os nomes de módulos deveram ser escritos em inglês e no plural. Ex.: Articles
                    </p>    
                </div>
            </div>
            <div id="creatingModels">
                <h3 class="mt-4"><b><i class="text-danger mr-1">#</i> Criação de Modelos</b></h3> 
            </div>
            <div id="listModels">
                <h4 class="mt-4"><b><i class="text-danger mr-1">#</i> Listando Modelo</b></h4>
                <div class="pl-3">
                    <p>O comando artisan <code>module:list</code> pode ser usado para listar os módulos e modelos registrados no sistema, mas para verificar os modelos de um módulo específico você deverá informar ao comando o nome do mesmo</p>
                    <div class="bg-light p-2 mb-2">
                        <code>php artisan module:list Articles</code>
                    </div>
                    <p>O comando acima irá nos retornar uma lista com os modelos existente no sistema</p>
                    <div class="bg-light p-2">
                        <i class="d-block mb-2">Retorno</i>
                        <b>Articles</b><br>
                        ARTI01,ART02,ARTI03
                    </div>
                </div>
            </div>
            <div id="creatingModel">
                <h4 class="mt-4"><b><i class="text-danger mr-1">#</i> Criando Modelos</b></h4>
                <div class="pl-3">
                    <p>
                        Para criar os modelos você deve utilizar o comando artisan <code>module:model</code> e informar o nome do Módulo e o Código do modelo.
                        <br> Para que o commando rode corretamento você deverá informar as opções, para mais detalhes do comando você poderá a qualquer momento informar a opção <code>-h</code>
                    </p>
                    <div class="bg-light p-2 mb-2">
                        <code>php artisan module:model Article ARTI01 -spc --admin --client</code><br>
                        <p class="mb-0 mt-2 font-14">Para mais detalhes consulte a página de <a href="commands.php">Comandos</a></p>
                    </div>
                    <p>
                        O comando acima criará os recursos necessários no sistema para que o modelo funcione.
                        <br> Os recursos criados são:
                    </p>
                    <div class="bg-light p-2 mb-2">
                        <ul>
                            <li class="mb-1">
                                <b>Controllers</b><br>
                                Articles/ART01Controller.php
                            </li>
                            <li class="mb-1">
                                <b>Models</b><br>
                                Articles/ART01Articles.php
                            </li>
                            <li class="mb-1">
                                <b>Factories</b><br>
                                ART01ArticlesFactory.php
                            </li>
                            <li class="mb-1">
                                <b>Migrations</b><br>
                                Articles/ART01/2021_12_01_151247_create_arti01_articles_table.php
                            </li>
                            <li class="mb-1">
                                <b>Seeders</b><br>
                                ART01ArticlesSeeder.php
                            </li>
                            <li class="mb-1">
                                <b>Resources Admin</b><br>
                                cruds/Articles/ARTI01/create.blade.php<br>
                                cruds/Articles/ARTI01/edit.blade.php<br>
                                cruds/Articles/ARTI01/form.blade.php<br>
                                cruds/Articles/ARTI01/index.blade.php<br>
                            </li>
                            <li class="mb-1">
                                <b>Resources Client</b><br>
                                pages/Articles/ARTI01/src (Assets)<br>
                                pages/Articles/ARTI01/page.blade.php<br>
                                pages/Articles/ARTI01/section.blade.php<br>
                                pages/Articles/ARTI01/show.blade.php<br>
                            </li>
                            <li class="mb-1">
                                <b>Routes</b><br>
                               Articles/ART01.php
                            </li>
                        </ul>
                    </div>
                    <p>As rotas pricipais são criadas dinâmicamente no arquivo <code>web.php</code> mas caso necessite criar alguma rota personalizada poderá cria-lás no arquivo de rotas dentro da pasta do modelo criado</p>
                    <p><b>IMPORTANTE: </b> É recomendado após a criação do modelo rodar o comando artisan <code>module:publish-assets</code></p>
                </div>
            </div>
   
            <div>
                <div class="alert alert-info mt-5">Se você tiver alguma dúvida ou dificuldade durante a configuração, não hesite em nos contatar. Teremos o maior prazer em ajudá-lo.</div>
            </div>
        </div>
    </div>

</div>
<?php include_once "_includes/footer.php"; ?>