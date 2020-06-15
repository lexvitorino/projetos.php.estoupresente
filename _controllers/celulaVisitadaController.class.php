<?php

class celulaVisitadaController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'celulaVisitada',
            'GetExeLb' => 'Células Visitadas',
            'GetExeLbs' => 'Células Visitadas',
        );

        $login = new Login();
        if ($login->hasPermission('celulasVisitadas')) {
            $this->loadTamplate('celulaVisitada/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'celulaVisitada',
            'GetExeLb' => 'Visita',
            'GetExeLbs' => 'Células Visitadas',
            'CelulaVisitadaData' => array()
        );
        
        $login = new Login();
        if ($login->hasPermission('celulasVisitadas') && $login->hasPermission('celulasVisitadas_novo')) {
            $data['CelulaVisitadaData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($CelulaVisitadaData && $CelulaVisitadaData['SendPostForm']):
                unset($CelulaVisitadaData['SendPostForm']);
            
                $celulaVisitada = new CelulaVisitada();
                $celulaVisitada->ExeCreate($CelulaVisitadaData);
                if ($celulaVisitada->getResult()):
                    WSErro($celulaVisitada->getError()[0], $celulaVisitada->getError()[1]);
                    header("Location: " . BASE . "/celulaVisitada");
                else:
                    WSErro($celulaVisitada->getError()[0], $celulaVisitada->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('celulaVisitada/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($CelulaVisitadaId) {
        $data = array(
            'GetExe' => 'celulaVisitada',
            'GetExeLb' => 'Visita',
            'GetExeLbs' => 'Células Visitadas',
            'CelulaVisitadaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('celulasVisitadas') && $login->hasPermission('celulasVisitadas_editar')) {

            $CelulaVisitadaData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($CelulaVisitadaData && $CelulaVisitadaData['SendPostForm']):
                unset($CelulaVisitadaData['SendPostForm']);
            
                $celulaVisitada = new CelulaVisitada();
                $celulaVisitada->ExeUpdate($CelulaVisitadaId, $CelulaVisitadaData);
                if ($celulaVisitada->getResult()):
                    WSErro($celulaVisitada->getError()[0], $celulaVisitada->getError()[1]);
                    header("Location: " . BASE . "/celulaVisitada");
                else:
                    WSErro($celulaVisitada->getError()[0], $celulaVisitada->getError()[1]);
                endif;
            endif;

            $Read = new Read();
            $Read->ExeRead(CELULA_VISITADA, "WHERE id = :id", "id={$CelulaVisitadaId}");
            if ($Read->getResult()):
                $data['CelulaVisitadaData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('celulaVisitada/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($CelulaVisitadaId) {
        $data = array(
            'GetExe' => 'celulaVisitada',
            'GetExeLb' => 'Células Visitadas',
            'GetExeLbs' => 'Células Visitadas',
        );

        $login = new Login();
        if ($CelulaVisitadaId && $login->hasPermission('celulasVisitadas') && $login->hasPermission('celulasVisitadas_deletar')):
            $celulaVisitada = new CelulaVisitada();
            $celulaVisitada->ExeDelete($CelulaVisitadaId);
            WSErro($celulaVisitada->getError()[0], $celulaVisitada->getError()[1]);
            header("Location: " . BASE . "/celulaVisitada");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
