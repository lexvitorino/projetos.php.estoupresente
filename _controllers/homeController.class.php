<?php

class homeController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'home',
            'GetExeLb' => 'Home',
            'GetExeLbs' => 'Home',
            'Celulas' => array()
        );

        if (empty($Read)):
            $Read = new Read;
        endif;

        $Read = new Read;
        $Read->FullRead("SELECT u.*, c.nome as celula
                         FROM   " . CELULA_VISITADA . " u
                            INNER JOIN " . CELULA . " c on c.id = u.id_celula
                         WHERE u.id_subscriber = :idSubscriber
                           AND :idMembroLogin in (c.id_auxiliar, c.id_dirigente, c.id_supervisor, c.id_area, c.id_pastor, c.id_distrito)
                         ORDER BY u.data DESC LIMIT 6", 
                        "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);
        
        $Celulas = array();
        if ($Read->getResult()):
            $Celulas = $Read->getResult();
        endif;

        $data['Celulas'] = $Celulas;        

        $this->loadTamplate('home', $data);
    }

}
