<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		
        <title><?= SITE_TITLE; ?></title>

        <script type="text/javascript">
            var BASE = '<?= BASE; ?>';
        </script>

        <link href="assets/inspinia/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/inspinia/font-awesome/css/font-awesome.css" rel="stylesheet">

        <link href="assets/inspinia/css/plugins/toastr/toastr.min.css" rel="stylesheet">
        <link href="assets/inspinia/css/plugins/iCheck/custom.css" rel="stylesheet">

        <link href="assets/inspinia/css/animate.css" rel="stylesheet">
        <link href="assets/inspinia/css/style.css" rel="stylesheet">
    
        <link rel="shortcut icon" href="<?= BASE; ?>/assets/images/favicon.ico" /> 
    </head>
    <body class="gray-bg">
        <div class="middle-box text-center loginscreen animated fadeInDown">
            <div>
                <div>
                    <h1 class="logo-name">
                        <img alt="logo" src="assets/images/logo_cgermelino.png" />
                    </h1>
                </div>

                <h3>Bem vindo ao A&J+</h3>

                <form name="AdminLoginForm" class="m-t" role="form" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="usuario" placeholder="Login" required="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Senha" required="">
                    </div>
                    <input type="submit" name="AdminLogin" class="btn btn-primary block full-width m-b" value="Logar">
                </form>

                <?php echo SITE_FOOTER_COPYRIGTH; ?>
            </div>
        </div>

        <script src="assets/inspinia/js/jquery-2.1.1.js"></script>
        <script src="assets/inspinia/js/bootstrap.min.js"></script>
        <script src="assets/inspinia/js/plugins/metisMenu/jquery.metisMenu.js"></script>
        <script src="assets/inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
        <script src="assets/inspinia/js/inspinia.js"></script>
        <script src="assets/inspinia/js/plugins/pace/pace.min.js"></script>    
        <script src="assets/inspinia/js/plugins/toastr/toastr.min.js"></script>
        <script src="assets/inspinia/js/plugins/jasny/jasny-bootstrap.min.js"></script>
        <script src="assets/inspinia/js/plugins/iCheck/icheck.min.js"></script>
        <script src="assets/inspinia/js/plugins/clockpicker/clockpicker.js"></script>
        
        <script src="assets/scripts.js"></script>

        <script type="text/javascript">
            var tipToastr = '<?= (!empty($_SESSION['alert']['tipToastr'])) ? $_SESSION['alert']['tipToastr'] : ''; ?>';
            var titToastr = '<?= (!empty($_SESSION['alert']['titToastr'])) ? $_SESSION['alert']['titToastr'] : ''; ?>';
            var msgToastr = '<?= (!empty($_SESSION['alert']['msgToastr'])) ? $_SESSION['alert']['msgToastr'] : ''; ?>';
        </script>
    </body>
</html>