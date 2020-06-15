<?php

class anexoController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'anexo',
            'GetExeLb' => 'Anexos',
            'GetExeLbs' => 'Anexos'
        );

        $login = new Login();
        if ($login->hasPermission('anexos')) {
            $this->loadTamplate('anexo/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'anexo',
            'GetExeLb' => 'Anexo',
            'GetExeLbs' => 'Anexos',
            'Pessoas' => array(),
            'AnexoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('anexos') && $login->hasPermission('anexos_novo')) {

            $Read = new Read;
            $Read->ExeRead(MEMBRO);
            if ($Read->getResult()):
                $data["Pessoas"] = $Read->getResult();
            endif;

            $data['AnexoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($AnexoData && $AnexoData['SendPostForm']):
                unset($AnexoData['SendPostForm']);
            
                $anexo = new Anexo();
                $anexo->ExeCreate($AnexoData);
                if ($anexo->getResult()):
                    WSErro($anexo->getError()[0], $anexo->getError()[1]);
                    header("Location: " . BASE . "/anexo");
                else:
                    WSErro($anexo->getError()[0], $anexo->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('anexo/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($AnexoId) {
        $data = array(
            'GetExe' => 'anexo',
            'GetExeLb' => 'Anexo',
            'GetExeLbs' => 'Anexos',
            'Pessoas' => array(),
            'AnexoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('anexos') && $login->hasPermission('anexos_editar')) {

            $AnexoData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $Read = new Read;
            $Read->ExeRead(MEMBRO);
            if ($Read->getResult()):
                $data["Pessoas"] = $Read->getResult();
            endif;

            if ($AnexoData && $AnexoData['SendPostForm']):
                unset($AnexoData['SendPostForm']);
            
                $anexo = new Anexo();
                $anexo->ExeUpdate($AnexoId, $AnexoData);
                if ($anexo->getResult()):
                    WSErro($anexo->getError()[0], $anexo->getError()[1]);
                    header("Location: " . BASE . "/anexo");
                else:
                    WSErro($anexo->getError()[0], $anexo->getError()[1]);
                endif;
            endif;

            $Read->ExeRead(ANEXO, "WHERE id = :id", "id={$AnexoId}");
            if ($Read->getResult()):
                $data['AnexoData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('anexo/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($AnexoId) {
        $data = array(
            'GetExe' => 'anexo',
            'GetExeLb' => 'Anexo',
            'GetExeLbs' => 'Anexos'
        );

        $login = new Login();
        if ($AnexoId && $login->hasPermission('anexos') && $login->hasPermission('anexos_deletar')):
            $anexo = new Anexo();
            $anexo->ExeDelete($AnexoId);
            WSErro($anexo->getError()[0], $anexo->getError()[1]);
            header("Location: " . BASE . "/anexo");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
