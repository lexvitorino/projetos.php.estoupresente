<?php

class linksController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'links',
            'GetExeLb' => 'Links',
            'GetExeLbs' => 'Links'
        );

        $this->loadTamplate('links', $data);
    }

}
