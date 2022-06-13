<?php
$arrParam = explode('/', $_SERVER["REQUEST_URI"]);
$page = end($arrParam);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8" />
    <title>Hoom interativa - Sistema criador de site em modulos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Sistema para criação de site a partir de módulos pré prontos." name="description" />
    <meta content="Hoom Interativa" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png"> 

    <!-- App css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/prism.css" rel="stylesheet" type="text/css" />
</head>

<body>
   

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <a href="index.php" class="logo text-center d-none d-md-inline-block mr-2">
                        <span class="logo-lg">
                            <img src="assets/images/logo-light.svg" alt="" height="38">
                        </span>
                    </a>

                    <button type="button" class="btn btn-sm btn-dark d-inline-block d-lg-none button-menu-mobile">Menu</button>

                    <span class="badge badge-danger float-right">v1.0.0</span>
                </div>
                <!-- end Topbar -->

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="page-wrapper">
                        <div class="left-sidebar">
                            <div class="slimscroll-menu">
                                <div class="list-group list-group-transparent mb-0">

                                    <span class="list-group-item disabled">
                                        Começando
                                    </span>

                                    <a href="index.php" class="list-group-item list-group-item-action <?=$page=='index.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-flag-variant-outline"></i>
                                        </span>Apresentação
                                    </a>

                                    <a href="setup.php" class="list-group-item list-group-item-action <?=$page=='setup.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-download"></i>
                                        </span>Instalação
                                    </a>

                                    <a href="commands.php" class="list-group-item list-group-item-action <?=$page=='commands.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-apple-keyboard-command"></i>
                                        </span>Comandos
                                    </a>

                                    <span class="list-group-item disabled">
                                        Criando módulos e modelos
                                    </span>

                                    <a href="starting-module.php" class="list-group-item list-group-item-action <?=$page=='starting-module.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-source-commit-start"></i>
                                        </span>Iniciando
                                    </a>
                                    <a href="settings-module.php" class="list-group-item list-group-item-action <?=$page=='settings-module.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-wrench"></i>
                                        </span>Configurando
                                    </a>

                                    <span class="list-group-item disabled">
                                        Personalização
                                    </span>

                                    <a href="patterns-styles.php" class="list-group-item list-group-item-action <?=$page=='patterns-styles.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-border-style"></i>
                                        </span>Padrões de Estilos
                                    </a>
                                    <a href="customization.php" class="list-group-item list-group-item-action <?=$page=='customization1.php'?'active':''?>">
                                        <span class="mr-2">
                                            <i class="mdi mdi-square-edit-outline"></i>
                                        </span>Customização
                                    </a>

                                    <span class="list-group-item disabled">
                                        Outros
                                    </span>

                                    <a href="plugins-uses.php" class="list-group-item list-group-item-action ">
                                        <span class="mr-2">
                                            <i class="mdi mdi-widgets"></i>
                                        </span>Como usar plugins
                                    </a>

                                    <a href="changelog.php" class="list-group-item list-group-item-action ">
                                        <span class="mr-2">
                                            <i class="mdi mdi-book-open-page-variant"></i>
                                        </span>Changelog
                                    </a>

                                </div>
                            </div>
                        </div>
                        <!-- end left-sidebar-->