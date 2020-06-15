<?php

class forgoutController extends ViewControl {

    private $Login;

    public function __construct() {
        $this->Login = new Login();
    }

    public function set($login) {
        if ($this->Login->CheckLogin()):
            header('Location: ' . BASE);
        endif;

        $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($dataLogin['AdminForgout'])):
            $this->Login->ExeForgout($login, $dataLogin);
            if (!$this->Login->getResult()):
                WSErro($this->Login->getError()[0], $this->Login->getError()[1]);
            else:
                header('Location: ' . BASE);
            endif;
        endif;
        
        $this->loadView('forgout');
    }

}
