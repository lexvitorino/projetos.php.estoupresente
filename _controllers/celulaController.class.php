<?php

class celulaController extends ViewControl {
    /*
     * ***************************************
     * **********  PUBLIC METHODS  ***********
     * ***************************************
     */

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'celula',
            'GetExeLb' => 'Células',
            'GetExeLbs' => 'Celulas',
        );

        $login = new Login();
        if ($login->hasPermission('celulas')) {
            $this->loadTamplate('celula/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'celula',
            'GetExeLb' => 'Célula',
            'GetExeLbs' => 'Celulas',
            'CelulaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('celulas') && $login->hasPermission('celulas_novo')) {

            $celula = new Celula();
            
            $data['CelulaData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data['CelulaData'] = $celula->inicializaCampos($data['CelulaData']);
            extract($data);

            if ($CelulaData && !empty($CelulaData['SendPostForm'])):
                unset($CelulaData['SendPostForm']);

                $celula->ExeCreate($CelulaData);
                if ($celula->getResult()):
                    WSErro($celula->getError()[0], $celula->getError()[1]);
                    header("Location: " . BASE . "/celula");
                else:
                    WSErro($celula->getError()[0], $celula->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('celula/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($CelulaId) {
        $data = array(
            'GetExe' => 'celula',
            'GetExeLb' => 'Célula',
            'GetExeLbs' => 'Celulas',
            'CelulaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('celulas') && $login->hasPermission('celulas_editar')) {

            $CelulaData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($CelulaData && $CelulaData['SendPostForm']):
                unset($CelulaData['SendPostForm']);

                $celula = new Celula();
                $celula->ExeUpdate($CelulaId, $CelulaData);
                if ($celula->getResult()):
                    WSErro($celula->getError()[0], $celula->getError()[1]);
                    header("Location: " . BASE . "/celula");
                else:
                    WSErro($celula->getError()[0], $celula->getError()[1]);
                endif;
            endif;

            $Read = new Read();
            $Read->ExeRead(CELULA, "WHERE id = :id", "id={$CelulaId}");
            if ($Read->getResult()):
                $data['CelulaData'] = $Read->getResult()[0];
            endif;

            $this->loadTamplate('celula/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($CelulaId) {
        $data = array(
            'GetExe' => 'celula',
            'GetExeLb' => 'Célula',
            'GetExeLbs' => 'Celulas',
        );

        $login = new Login();
        if ($CelulaId && $login->hasPermission('celulas') && $login->hasPermission('celulas_deletar')):
            $celula = new Celula();
            $celula->ExeDelete($CelulaId);
            WSErro($celula->getError()[0], $celula->getError()[1]);
            header("Location: " . BASE . "/celula");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
