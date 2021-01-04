# SITE MODULAR
Sistema para contrução de sites pré-moldados com possibilidade de criação de módulos novos e seus modelos

  - Montagem dinâmica de site a partir de um arquivo de configuração
  - Configuração independente para módulos
  - Códigos limpos e comentados.

### DOCUMENTAÇÃO

Leia toda a documentação antes de começar. Abaixo você encontrará as respostas para todas as possíveis perguntas.
**Importante:** a nomeclatura *Módulo* representa a estrutura principal, *Ex: Módulo -> Slide*, e os modelos representa todos os modelos, sinalizados com seus respectivos códigos, desenvolvido para aquele Módulo, *Ex: Módulo -> Slide | Modelo -> SD001, SD002, SD003*

##### Instalação
#
Clonar o Repositório **[painelHoom](https://github.com/hoominterativa/painelHoom)** na sua máquina, após finalizar, rodar os comandos na ordem listada abaixo.
```sh 
$ composer install
$ npm install
$ composer run post-autoload-dump
$ composer run post-root-package-install
$ composer run post-create-project-cmd
```

#### Instalar novos módulos
Para criar um novo módulo será necessários rodar o comando:
```sh 
$ php artisan module:make Products
```
Após rodar o comando uma pasta com nome de *Modules* será criada na raiz (Caso não existe), dentro uma nova pasta com o nome do *Módulo* que acabou de criar. O nome do módulo será obrigatório sempre que rodar algum dos comando do tipo *module*
**Obs.: Os módulos deveram ser nomeados sempre no plural e em Inglês**

Para deletar um módulo é só rodar o comando:
```sh 
$ php artisan module:delete Products
```

Para mais detalhes sobre o pacote de Módulos acessar [nwidart/laravel-modules](https://nwidart.com/laravel-modules/v6/introduction)

##### Views
#
Após criar um novo módulo alguns padrões deverão ser seguidos para que todo o sistema reconheça de forma automática o novo módulo criado, são elas:
**A estrutura das suas views, dentro do módulo criado, deverão seguir o padrão mostrado abaixo**

```shell
├───PD001
│   ├───Admin
│   │   └───Core
│   │   │   └───layout.blade.php
│   │   └───create.blade.php
│   │   └───edit.blade.php
│   │   └───index.blade.php
│   └───Client
│   │   └───section.blade.php
```
Os arquivos listados acima são obrigatórios, caso tenha que criar alguma view para renderização ajax criar a pasta **model** e dentro da mesma inserir os arquivos. Na pasta de *Cliente* poderá fazer o mesmo para requisições ajax, recomendamos usar o código do modelo como nome em todos os arquivos arquivos que for criado dentro do módulo *Ex: PD001ProductAjax.blade.php*

##### Controllers
#

Rodar o comando abaixo para criar um novo controlador em seu módulo.
```sh 
$ php artisan module:make-controller PD001Controller Products
```
Na mesma linha de raciocínio das vews os módulos deveram ter em seus nomes primeiramente o código do modelo, *Ex: PD001Controller.php | PD001CategoryController.php | PD001SubategoryController.php*. 
Os controladores deverão ser usados de acordo com suas Views, Módulo e Migration nomeando-as com o código respectivo também.

##### Migrations
#

Rodar o comando abaixo para criar uma nova migration em seu módulo.
```sh 
$ php artisan module:make-migration create_PD001_table Products
```
Migrations deveram ter em seus nomes primeiramente o código do modelo, *Ex: create_PD001_table.php | create_PD001Category_table.php | create_PD001Subcategory_table.php*. 

##### Models (Class)
#

Rodar o comando abaixo para criar uma nova Model (Class) em seu módulo.
```sh 
$ php artisan module:make-model PD001 Products
```
Migrations deveram ter em seus nomes primeiramente o código do modelo, *Ex: create_PD001_table.php | create_PD001Category_table.php | create_PD001Subcategory_table.php*. 

##### Rotas (Routes)
#
Existe uma estrutura padrão para ser posto no arquivo de rota do seu *Módulo*, o arquivo de rota (web.php) deverá ser único para cada *Módulo* e cada *Módulo* deverá ter o seu. O arquivo de Rotas se encronta dentro do seu módulo na pasta Routes.
Após criar seu *Módulo*, será criado no arquivo *Routes/web.php* uma estrutura padrão. a mesma deverá ser substituida pelo código abaixo.
```php
<?php

/*
    Abaixo será necessário listar as rotas do lado do "CLIENT" manualmente
    Editar Somente os "NAMES" das Rotas substituindo "NAME" pelo módulo atual
    Editar tbm o prefixo para o nome do módulo atual
*/

Route::prefix('NAME')->group(function()
{
    $InsertModelsMain = config('modelsConfig.InsertModelsMain')->NAME;

    $codeModel = $InsertModelsMain->Code;
    $ControllerResource = $codeModel.'Controller';

    Route::get('/', $ControllerResource.'@list')->name('admin.NAME.list');

    if($InsertModelsMain->Category){
        Route::get('/{category}', $ControllerResource.'@category')->name('admin.NAME.category');
        if($InsertModelsMain->Subategory){
            Route::get('/{category}/{subcategory}', $ControllerResource.'@subcategory')->name('admin.NAME.subcategory');
            Route::get('/{category}/{subcategory}/{NAME}', $ControllerResource.'@show')->name('admin.NAME');
        }else{
            Route::get('/{category}/{NAME}', $ControllerResource.'@show')->name('admin.NAME');
        }
    }else{
        /* Manter esse else se caso haja uma página interna (Ex.: página interna de produto) */
        Route::get('/{product}', $ControllerResource.'@show')->name('admin.NAME');
    }

});

/*
Montagem das Rotas do lado do "ADMIN", Editar Somente os "NAMES" das Rotas substituindo "NAME" pelo módulo atual
Obs.: Usuar a primeira letra em maiúsculo somente para a chamada do objeto no config() o restante será tudo minusculo.
Ex.: config('modelsConfig.InsertModelsMain')->Products;
*/

Route::prefix('painel')->group(function()
{

    $InsertModelsMain = config('modelsConfig.InsertModelsMain')->NAMES;

    $codeModel = $InsertModelsMain->Code;
    $ControllerResource = $codeModel.'Controller';

    Route::resource('/NAMES', $ControllerResource)->names('admin.NAMES')->parameters(['NAME' => 'NAME']);

    if($InsertModelsMain->Category){
        $ControllerCategoryResource = $codeModel.'CategoryController';
        Route::resource('/NAMES/categoria', $ControllerCategoryResource)->names('admin.NAMES.category')->parameters(['categoria' => 'category']);
        if($InsertModelsMain->Subategory){
            $ControllerSubategoryResource = $codeModel.'SubategoryController';
            Route::resource('/NAMES/subcategoria', $ControllerSubategoryResource)->names('admin.NAMES.subcategory')->parameters(['subcategoria' => 'subcategory']);
        }
    }

});
```
