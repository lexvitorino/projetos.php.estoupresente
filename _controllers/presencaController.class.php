<?php

class presencaController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'presenca',
            'GetExeLb' => 'Presenças',
            'GetExeLbs' => 'Presenças',
            'PresencaFiltro' => array()
        );

        $login = new Login();
        if ($login->hasPermission('presencas')) {
            $this->loadTamplate('presenca/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'presenca',
            'GetExeLb' => 'Presença',
            'GetExeLbs' => 'Presenças',
            'PresencaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('presencas') && $login->hasPermission('presencas_novo')) {

            $data['PresencaData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($PresencaData && $PresencaData['SendPostForm']):
                unset($PresencaData['SendPostForm']);
            
                $presenca = new Presenca();
                $presenca->ExeCreate($PresencaData);
                if ($presenca->getResult()):
                    WSErro($presenca->getError()[0], $presenca->getError()[1]);
                    header("Location: " . BASE . "/presenca");
                else:
                    WSErro($presenca->getError()[0], $presenca->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('presenca/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($PresençaId) {
        $data = array(
            'GetExe' => 'presenca',
            'GetExeLb' => 'Presença',
            'GetExeLbs' => 'Presenças',
            'PresencaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('presencas') && $login->hasPermission('presencas_editar')) {

            $PresencaData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($PresencaData && $PresencaData['SendPostForm']):
                unset($PresencaData['SendPostForm']);
            
                $presenca = new Presenca();
                $presenca->ExeUpdate($PresençaId, $PresencaData);
                if ($presenca->getResult()):
                    WSErro($presenca->getError()[0], $presenca->getError()[1]);
                    header("Location: " . BASE . "/presenca");
                else:
                    WSErro($presenca->getError()[0], $presenca->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(PRESENCA, "WHERE id = :id", "id={$PresençaId}");
            if ($Read->getResult()):
                $data['PresencaData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('presenca/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($PresençaId) {
        $data = array(
            'GetExe' => 'presenca',
            'GetExeLb' => 'Presença',
            'GetExeLbs' => 'Presenças',
        );

        $login = new Login();
        if ($PresençaId && $login->hasPermission('presencas') && $login->hasPermission('presencas_deletar')):
            $presenca = new Presenca();
            $presenca->ExeDelete($PresençaId);
            WSErro($presenca->getError()[0], $presenca->getError()[1]);
            header("Location: " . BASE . "/presenca");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
