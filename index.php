<?php
session_start();

require_once '_app/Config.inc.php';

require_once '_libaries/PHPMailer/Exception.php';
require_once '_libaries/PHPMailer/PHPMailer.php';
require_once '_libaries/PHPMailer/SMTP.php';

spl_autoload_register(function ($Class) {
    if (strpos($Class, 'Controller') > -1) {
        if (file_exists('_controllers/' . $Class . '.class.php')) {
            require_once '_controllers/' . $Class . '.class.php';
        }
    } else if (file_exists('_models/' . $Class . '.class.php')) {
        require_once '_models/' . $Class . '.class.php';
    } else if (file_exists('_app/Conn/' . $Class . '.class.php')) {
        require_once '_app/Conn/' . $Class . '.class.php';
    } else if (file_exists('_app/Helpers/' . $Class . '.class.php')) {
        require_once '_app/Helpers/' . $Class . '.class.php';
    } else if (file_exists('_app/Core/' . $Class . '.class.php')) {
        require_once '_app/Core/' . $Class . '.class.php';
    }
});

$core = new Core();
$core->Run();
