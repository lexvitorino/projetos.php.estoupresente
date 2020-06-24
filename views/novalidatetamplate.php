<?php
extract($viewData);
?>

<!DOCTYPE html>
<html lang="pt-br" class="h-100">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <title><?= SITE_TITLE; ?> | Painel</title>

        <script type="text/javascript">
            var BASE = '<?= BASE; ?>';
        </script>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= BASE; ?>/assets/styles.css" />  
    
        <link rel="shortcut icon" href="https://cgermelino.com.br/wp-content/uploads/2019/02/cropped-comuna_icone-1-32x32.jpg" /> 
    </head>

    <body class="d-flex flex-column h-100">
        <div id="top-bar">
            <div id="top-bar-inner" class="content">
                <div class="text-right mr-3">
                    <i class="fa fa-phone-square pr-2"></i>(11) 2547-3116 
                    <i class="fa fa-envelope pr-2"></i>ermelino@cgbr.com.br
                </div>
            </div>
        </div>
        
        <main role="main" class="flex-shrink-0 mb-3">
          <?php $this->loadViewInTamplate($viewName, $viewData); ?>
        </main>

        <footer id="bottom" class="footer mt-auto py-3">
          <div class="container">
            <strong>Copyright</strong> <?php echo SITE_FOOTER_COPYRIGTH; ?>
          </div>
        </footer>
    </body>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha256-BJeo0qm959uMBGb65z40ejJYGSgR7REI4+CW1fNKwOg=" crossorigin="anonymous"></script>
    <script src="<?= BASE; ?>/views/inscricao/inscricao.js"></script>
</html>