<?php

return [

    /*
    Configura quais módulos do Headers e Footers serão impressos na sua página
    Informar apenas o código do módulo.
    */
    'InsertModelsLayout' => (object) [
        'Header' => 'HD001',
        'Footer' => 'FT005',
    ],

    /*
    Configurar quais módulos serão usados para o site/sistema no geral, exceto Header e Footer.

    Ex.:
        'Name Modulo' => [
            'Code' => 'Código do Modulo',
            'ViewHome' => true,
            'ListMenu' => 'Nome na listagem do menu',
            'IncludeSections' => array de Códigos do modulo
        ],

    Para cadada indice do array algumas opções estão disponíveis sendo elas:
        Code => (String) Código do módulo, informado tbm no layout
        ViewHome => (Boolean) "True" para exibir uma seção na home e "False" para não
        ListMenu => (String) Título a ser exibido no menu do site e Vazio para não listar no menu do site
        IncludeSections => (Array) Insere Sessões nas páginas internas do módulo, essa opção só valerá para módulos que possuem páginas internas.
                           Caso não exista seções impressas nas internas deixar o array vazio. Ex.: 'IncludeSections' => []
                           Obs.: Digitar Nome e código do modulo Ex.: ['Slide' => 'SD001', 'Topic' => 'TP002', 'News' => 'NE003']

    OBS.: Módulos não poderão se repetir no array. No módulo já está incluso todas as dependencias para que funcione corretamente,
    aqui deverá apenas informar as configurações do mesmo.
    */

    'InsertModelsMain' => (object) [
        'Slide' => (object) [
            'Code' => 'SD001',
            'ViewHome' => true,
            'ListMenu' => '',
            'IncludeSections' => (object)[
                'Slide' => 'SD002'
            ]
        ],
    ],

    'Models' => (object) [
        'Slides' => (object)[
            'SD001' => Modules\Slides\Http\Controllers\SD001Controller::class,
            'SD002' => Modules\Slides\Http\Controllers\SD002Controller::class
        ],
    ]
];
