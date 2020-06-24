<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo SITE_TITLE; ?> |  Painel</title>

        <link href="<?php echo BASE; ?>/assets/theme/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo BASE; ?>/assets/theme/font-awesome/css/font-awesome.css" rel="stylesheet">

        <!-- Toastr style -->
        <link href="<?php echo BASE; ?>/assets/theme/css/plugins/toastr/toastr.min.css" rel="stylesheet">

        <link href="<?php echo BASE; ?>/assets/theme/css/plugins/iCheck/custom.css" rel="stylesheet">

        <link href="<?php echo BASE; ?>/assets/theme/css/animate.css" rel="stylesheet">
        <link href="<?php echo BASE; ?>/assets/theme/css/style.css" rel="stylesheet">

        <link href="<?php echo BASE; ?>/assets/theme/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
        
        <link href="<?php echo BASE; ?>/assets/theme/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">

        <link href="<?php echo BASE; ?>/assets/specs/css/style.css" rel="stylesheet">
    
        <link rel="shortcut icon" href="<?php echo BASE; ?>/assets/specs/img/favicon.png" />
    </head>

    <body>        
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> 
                                        <span class="block m-t-xs"> 
                                            <strong class="font-bold"><?php echo $dataView['userName']; ?></strong>
                                        </span> 
                                        <span class="text-muted text-xs block">
                                            <?php echo $dataView['userFunction']; ?> <b class="caret"></b>
                                        </span> 
                                    </span>
                                </a>

                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="logout">Logout</a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                A&J+
                            </div>
                        </li>
                        <li style="<?php echo ($_SESSION['has_home']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'home') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/home"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_dashboard']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'dashboard') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/dashboard"><i class="fa fa-line-chart"></i> <span class="nav-label">Dashboard</span></a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_avisos']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'avisos') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/avisos"><i class="fa fa-envelope-o"></i> <span class="nav-label">Avisos</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_anexos']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'anexos') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/anexos"><i class="fa fa-floppy-o"></i> <span class="nav-label">Anexos</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_comunas']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'comunas') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/comunas"><i class="fa fa-euro"></i> <span class="nav-label">Comunas</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_discipulados']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'discipulados') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/discipulados"><i class="fa fa-handshake-o"></i> <span class="nav-label">Discipulados</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_celulasVisitadas']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'celulasVisitadas') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/celulasVisitadas"><i class="fa fa-american-sign-language-interpreting"></i> <span class="nav-label">Celulas Visitadas</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_fichas']==1)?'display: block':'display: none'; ?>"  class="<?php echo (getFichas($dataView['viewLink'])) ? 'active' : ''; ?>">
                            <a href="#"><i class="fa fa-address-card-o"></i> <span class="nav-label">Fichas e Relatórios</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li style="<?php echo ($_SESSION['has_fichasVVitoriosa']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'fichasVVitoriosa') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/fichasVVitoriosa">Vida Vitoriosa</a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_fichasFColheita']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'fichasFColheita') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/fichasFColheita">Festa da Colheita</a>
                                </li>
                            </ul>
                        </li>
                        <li style="<?php echo ($_SESSION['has_pessoas']==1)?'display: block':'display: none'; ?>"  class="<?php echo (getEncargos($dataView['viewLink'])) ? 'active' : ''; ?>">
                            <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Membros</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li style="<?php echo ($_SESSION['has_membros']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'membros') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/membros">Membros</span> </a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_auxiliares']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'auxiliares') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/auxiliares">Auxiliares</span> </a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_lideres']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'lideres') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/lideres">Lideres</span> </a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_supervisores']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'supervisores') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/supervisores">Supervisores</span> </a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_areas']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'areas') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/areas"></i>Áreas</span> </a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_pastores']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'pastores') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/pastores">Pastores</span> </a>
                                </li>
                            </ul>
                        </li>
                        <li style="<?php echo ($_SESSION['has_celulas']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'celulas') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/celulas"><i class="fa fa-university"></i> <span class="nav-label">Células</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_presencas']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'presencas') ? 'active' : ''; ?>">
                            <a href="<?php echo BASE; ?>/presencas"><i class="fa fa-id-card-o"></i> <span class="nav-label">Presença</span> </a>
                        </li>
                        <li style="<?php echo ($_SESSION['has_configuracoes']==1)?'display: block':'display: none'; ?>">
                            <a href="#"><i class="fa fa-server"></i> <span class="nav-label">Configurações</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li style="<?php echo ($_SESSION['has_usuarios']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'usuarios') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/usuarios">Usuário</a>
                                </li>
                                <li style="<?php echo ($_SESSION['has_permissoes']==1)?'display: block':'display: none'; ?>" class="<?php echo ($dataView['viewLink'] == 'permissoes') ? 'active' : ''; ?>">
                                    <a href="<?php echo BASE; ?>/permissoes">Permissões</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <a href="<?php echo BASE . '/logout'; ?>">
                                    <i class="fa fa-sign-out"></i> Sair
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-4">
                        <h2><?php echo $dataView['viewName']; ?></h2>
                        <ol class="breadcrumb">
                            <li>
                                <a href="<?php echo BASE . '/home'; ?>">Home</a>
                            </li>
                            <?php if ($dataView['viewLink'] != 'home'): ?>
                                <li class="active">
                                    <a href="<?php echo $dataView['viewLink']; ?>"><strong><?php echo $dataView['viewName']; ?></strong></a>
                                </li>
                            <?php endif; ?>
                        </ol>
                    </div>
                </div>                
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php $this->loadViewInTemplate($viewName, $dataView); ?>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <div>
                        <strong>Copyright</strong> <?php echo SITE_FOOTER_COPYRIGTH; ?>
                    </div>
                </div>

            </div>
        </div>

        <!-- Mainly scripts -->
        <script src="<?php echo BASE; ?>/assets/theme/js/jquery-2.1.1.js"></script>
        <script src="<?php echo BASE; ?>/assets/theme/js/bootstrap.min.js"></script>
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Custom and plugin javascript -->
        <script src="<?php echo BASE; ?>/assets/theme/js/inspinia.js"></script>
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/pace/pace.min.js"></script>

        <!-- Toastr script -->
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/toastr/toastr.min.js"></script>

        <!-- Input Mask-->
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/jasny/jasny-bootstrap.min.js"></script>

        <!-- iCheck -->
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/iCheck/icheck.min.js"></script>
        
        <!-- Clock picker -->
        <script src="<?php echo BASE; ?>/assets/theme/js/plugins/clockpicker/clockpicker.js"></script>

        <script src="<?php echo BASE; ?>/assets/specs/js/scripts.js"></script>

        <script type="text/javascript">
            var tipToastr = '<?php echo (!empty($_SESSION['mensagem']['tipToastr'])) ? $_SESSION['mensagem']['tipToastr'] : ''; ?>';
            var titToastr = '<?php echo (!empty($_SESSION['mensagem']['titToastr'])) ? $_SESSION['mensagem']['titToastr'] : ''; ?>';
            var msgToastr = '<?php echo (!empty($_SESSION['mensagem']['msgToastr'])) ? $_SESSION['mensagem']['msgToastr'] : ''; ?>';
        </script>
    </body>
</html>
