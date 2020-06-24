<?php
$login = new Login();
if (!$login->CheckLogin()):
    unset($_SESSION['userlogin']);
    header('Location: ' . BASE . '/login');
else:
    $userlogin = $_SESSION['userlogin'];
    $userPermissions = $_SESSION['menu_permission'];
endif;

extract($viewData);
?>

<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?= SITE_TITLE; ?> | Painel</title>

        <script type="text/javascript">
            var BASE = '<?= BASE; ?>';
        </script>

        <link href="<?= BASE; ?>/assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= BASE; ?>/assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?= BASE; ?>/assets/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link href="<?= BASE; ?>/assets/inspinia/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="<?= BASE; ?>/assets/inspinia/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
        <link href="<?= BASE; ?>/assets/inspinia/css/animate.css" rel="stylesheet">
        <link href="<?= BASE; ?>/assets/inspinia/css/style.css" rel="stylesheet">  
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.0/cr-1.5.0/r-2.2.2/sc-1.5.0/datatables.min.css"/>

        <link rel="stylesheet" href="<?= BASE; ?>/assets/styles.css" />  

        <link rel="shortcut icon" href="<?= BASE; ?>/assets/images/favicon.ico" /> 
    </head>

    <body>

        <div id="wrapper">

            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav metismenu" id="side-menu">
                        <li class="nav-header">
                            <div class="dropdown profile-element">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?= $userlogin['name']; ?></strong>
                                        </span> <span class="text-muted text-xs block"><?= $userlogin['encargo']; ?></span> </span> </a>
                            </div>
                            <div class="logo-element">
                                IN+
                            </div>
                        </li>
                        <li class="<?php if ('home' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('home') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE ?>"><i class="fa fa-home"></i> <span class="nav-label">Home</span></a>
                        </li>
                        <li class="<?php if ('dashboard' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('dashboard') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/dashboard"><i class="fa fa-line-chart"></i> <span class="nav-label">Dashboard</span></a>
                        </li>
                        <li class="<?php if ('links' == $GetExe) echo ' active'; ?>">
                            <a href="<?= BASE; ?>/links"><i class="fa fa-apple"></i> <span class="nav-label">Links</span></a>
                        </li>
                        <li class="<?php if ('aviso' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('avisos') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/aviso"><i class="fa fa-envelope-o"></i> <span class="nav-label">Avisos</span> </a>
                        </li>
                        <li class="<?php if ('anexo' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('anexos') ?> <?= $login->hasPermission('anexos') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/anexo"><i class="fa fa-floppy-o"></i> <span class="nav-label">Anexos</span> </a>
                        </li>
                        <li class="<?php if ('discipulado' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('discipulados') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/discipulado"><i class="fa fa-slideshare"></i> <span class="nav-label">Discipulados</span> </a>
                        </li>
                        <li class="<?php if ('celulaVisitada' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('celulasVisitadas') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/celulaVisitada"><i class="fa fa-lastfm-square"></i> <span class="nav-label">Celulas Visitadas</span> </a>
                        </li>
                        <li class="<?php if ('fichasVVitoriosa' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('fichas') ? 'display: block' : 'display: none'; ?>">
                            <a href="#"><i class="fa fa-newspaper-o"></i> <span class="nav-label">Fichas e Relatórios</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li class="<?php if ('posts' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('fichasVVitoriosa') ? 'display: block' : 'display: none'; ?>">
                                    <a href="<?= BASE; ?>/fichaVVitoriosa">Vida Vitoriosa</a>
                                </li>
                                <li class="<?php if ('posts' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('fichasFColheita') ? 'display: block' : 'display: none'; ?>">
                                    <a href="<?= BASE; ?>/fichaFColheita">Festa da Colheita</a>
                                </li>
                            </ul>
                        </li>
                        <li class="<?php if ('membro' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('membros') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/membro"><i class="fa fa-users"></i><span class="nav-label"> Membros</span></span> </a>
                        </li>
                        <li class="<?php if ('celula' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('celulas') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/celula"><i class="fa fa-university"></i> <span class="nav-label">Células</span> </a>
                        </li>
                        <li class="<?php if ('presenca' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('presencas') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/presenca"><i class="fa fa-drupal"></i> <span class="nav-label">Presença</span> </a>
                        </li>
                        <li class="<?php if ('relatorio' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('relatorio') ? 'display: block' : 'display: none'; ?>">
                            <a href="<?= BASE; ?>/relatorio"><i class="fa fa-list-ol"></i> <span class="nav-label">Relatório</span></a>
                        </li>
                        <li class="<?php if ('usuario' == $GetExe || 'grupoPermissao' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('configuracoes') ? 'display: block' : 'display: none'; ?>">
                            <a href="#"><i class="fa fa-server"></i> <span class="nav-label">Configurações</span> <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li class="<?php if ('usuario' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('usuarios') ? 'display: block' : 'display: none'; ?>">
                                    <a href="<?= BASE; ?>/usuario">Usuários</a>
                                </li>
                                <li class="<?php if ('grupoPermissao' == $GetExe) echo ' active'; ?>" style="<?= $login->hasPermission('permissoes') ? 'display: block' : 'display: none'; ?>">
                                    <a href="<?= BASE; ?>/grupoPermissao">Grupos de Permissões</a>
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
                            <form role="search" class="navbar-form-custom" method="post" action="#">
                                <div class="form-group">
                                    <select name="encargo" class="form-control encargoSel" id="top-search">
                                        <option value="">Selecione um encargo</option>
                                        <?php foreach (getEncargos() as $StatusId => $StatusName): ?>
                                            <option value="<?= $StatusName; ?>" <?= ($StatusName == (empty(ENCARGO_SEL) ? '' : ENCARGO_SEL)) ? 'selected="selected"' : ''; ?>> <?= Check::NomeProprio($StatusName); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li><a href="<?= BASE . '/login/logout'; ?>"><i class="fa fa-sign-out"></i> Sair</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-sm-4">
                        <h2><?= $GetExeLb; ?></h2>
                        <?php if (!empty($GetExe) && $GetExe != 'home'): ?>
                            <ol class="breadcrumb">
                                <li>
                                    <a href="<?= BASE ?>">Home</a>
                                </li>
                                <li class="<?php if ($GetExe == $GetExe) echo ' active'; ?>">
                                    <a href="<?= BASE . '/' . $GetExe ?>"><strong><?= $GetExeLbs; ?></strong></a>
                                </li>
                            </ol>
                        <?php endif; ?>
                    </div>
                </div>   
                <div class="wrapper wrapper-content animated fadeInRight">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="painel">
                                <?php $this->loadViewInTamplate($viewName, $viewData); ?>
                            </div> 
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

    </body>

    <script src="<?= BASE; ?>/assets/inspinia/js/jquery-2.1.1.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/bootstrap.min.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/inspinia.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/pace/pace.min.js"></script>    
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/toastr/toastr.min.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/iCheck/icheck.min.js"></script>
    <script src="<?= BASE; ?>/assets/inspinia/js/plugins/clockpicker/clockpicker.js"></script>

    <script src="<?= BASE; ?>/assets/outhers/Chart.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.18/af-2.3.0/cr-1.5.0/r-2.2.2/sc-1.5.0/datatables.min.js"></script>

    <script src="<?= BASE; ?>/assets/scripts.js"></script>

    <script src="<?= BASE; ?>/_ajax/membros.ajax.js"></script>
    <script src="<?= BASE; ?>/_ajax/grupoPermissao.ajax.js"></script>
    <script src="<?= BASE; ?>/_ajax/dashboard.ajax.js"></script>

    <script type="text/javascript">
            var tipToastr = '<?= (!empty($_SESSION['alert']['tipToastr'])) ? $_SESSION['alert']['tipToastr'] : ''; ?>';
            var titToastr = '<?= (!empty($_SESSION['alert']['titToastr'])) ? $_SESSION['alert']['titToastr'] : ''; ?>';
            var msgToastr = '<?= (!empty($_SESSION['alert']['msgToastr'])) ? $_SESSION['alert']['msgToastr'] : ''; ?>';
    </script> 
</html>