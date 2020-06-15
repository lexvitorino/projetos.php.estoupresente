<?php

class loginController extends ViewControl {

    private $Login;

    public function __construct() {
        $this->Login = new Login();
    }

    public function index() {
        if ($this->Login->CheckLogin()):
            header('Location: ' . BASE);
        endif;

        $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dataLogin['AdminLogin'])):
            $this->Login->ExeLogin($dataLogin);
            if (!$this->Login->getResult()) {
                WSErro($this->Login->getError()[0], $this->Login->getError()[1]);
            } else if ((bool) $_SESSION['userlogin']['altera_senha']) {
                $this->Login = (string) strip_tags(trim($dataLogin['usuario']));
                header("Location: " . BASE . "/forgout/set/" . $this->Login);
            } else {
                header('Location: ' . BASE);
            }
        endif;
        
        $this->loadView('login');
    }

    public function logout() {
        $this->Login->ExeLogout();
    }

}
