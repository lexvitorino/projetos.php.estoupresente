<?php

class discipuladoController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'discipulado',
            'GetExeLb' => 'Discipulados',
            'GetExeLbs' => 'Discipulados',
        );

        $login = new Login();
        if ($login->hasPermission('discipulados')) {
            $this->loadTamplate('discipulado/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'discipulado',
            'GetExeLb' => 'Discipulado',
            'GetExeLbs' => 'Discipulados',
            'DiscipuladoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('discipulados') && $login->hasPermission('discipulados_novo')) {

            $data['DiscipuladoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($DiscipuladoData && $DiscipuladoData['SendPostForm']):
                unset($DiscipuladoData['SendPostForm']);
            
                $discipulado = new Discipulado();
                $discipulado->ExeCreate($DiscipuladoData);
                if ($discipulado->getResult()):
                    WSErro($discipulado->getError()[0], $discipulado->getError()[1]);
                    header("Location: " . BASE . "/discipulado");
                else:
                    WSErro($discipulado->getError()[0], $discipulado->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('discipulado/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($DiscipuladoId) {
        $data = array(
            'GetExe' => 'discipulado',
            'GetExeLb' => 'Discipulado',
            'GetExeLbs' => 'Discipulados',
            'DiscipuladoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('discipulados') && $login->hasPermission('discipulados_editar')) {

            $DiscipuladoData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($DiscipuladoData && $DiscipuladoData['SendPostForm']):
                unset($DiscipuladoData['SendPostForm']);
            
                $discipulado = new Discipulado();
                $discipulado->ExeUpdate($DiscipuladoId, $DiscipuladoData);
                if ($discipulado->getResult()):
                    WSErro($discipulado->getError()[0], $discipulado->getError()[1]);
                    header("Location: " . BASE . "/discipulado");
                else:
                    WSErro($discipulado->getError()[0], $discipulado->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(DISCIPULADO, "WHERE id = :id", "id={$DiscipuladoId}");
            if ($Read->getResult()):
                $data['DiscipuladoData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('discipulado/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($DiscipuladoId) {
        $data = array(
            'GetExe' => 'discipulado',
            'GetExeLb' => 'Discipulado',
            'GetExeLbs' => 'Discipulados',
        );

        $login = new Login();
        if ($DiscipuladoId && $login->hasPermission('discipulados') && $login->hasPermission('discipulados_deletar')):
            $discipulado = new Discipulado();
            $discipulado->ExeDelete($DiscipuladoId);
            WSErro($discipulado->getError()[0], $discipulado->getError()[1]);
            header("Location: " . BASE . "/discipulado");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
