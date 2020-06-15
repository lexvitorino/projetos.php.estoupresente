<?php

class fichaVVitoriosaController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'fichaVVitoriosa',
            'GetExeLb' => 'Fichas Vida Vitoriosa',
            'GetExeLbs' => 'Fichas Vida Vitoriosa',
        );

        $login = new Login();
        if ($login->hasPermission('fichasVVitoriosa')) {
            $this->loadTamplate('fichaVVitoriosa/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'fichaVVitoriosa',
            'GetExeLb' => 'Vida Vitoriosa',
            'GetExeLbs' => 'Fichas Vida Vitoriosa',
            'FichaVVitoriosaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('fichasVVitoriosa') && $login->hasPermission('fichasVVitoriosa_novo')) {

            $data['FichaVVitoriosaData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($FichaVVitoriosaData && $FichaVVitoriosaData['SendPostForm']):
                unset($FichaVVitoriosaData['SendPostForm']);
            
                $fichaVVitoriosa = new FichaVVitoriosa();
                $fichaVVitoriosa->ExeCreate($FichaVVitoriosaData);
                if ($fichaVVitoriosa->getResult()):
                    WSErro($fichaVVitoriosa->getError()[0], $fichaVVitoriosa->getError()[1]);
                    header("Location: " . BASE . "/fichaVVitoriosa");
                else:
                    WSErro($fichaVVitoriosa->getError()[0], $fichaVVitoriosa->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('fichaVVitoriosa/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($FichaVVitoriosaId) {
        $data = array(
            'GetExe' => 'fichaVVitoriosa',
            'GetExeLb' => 'Vida Vitoriosa',
            'GetExeLbs' => 'Fichas Vida Vitoriosa',
            'FichaVVitoriosaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('fichasVVitoriosa') && $login->hasPermission('fichasVVitoriosa_editar')) {

            $FichaVVitoriosaData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($FichaVVitoriosaData && $FichaVVitoriosaData['SendPostForm']):
                unset($FichaVVitoriosaData['SendPostForm']);
            
                $fichaVVitoriosa = new FichaVVitoriosa();
                $fichaVVitoriosa->ExeUpdate($FichaVVitoriosaId, $FichaVVitoriosaData);
                if ($fichaVVitoriosa->getResult()):
                    WSErro($fichaVVitoriosa->getError()[0], $fichaVVitoriosa->getError()[1]);
                    header("Location: " . BASE . "/fichaVVitoriosa");
                else:
                    WSErro($fichaVVitoriosa->getError()[0], $fichaVVitoriosa->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(FICHA_FCOLHEITA, "WHERE id = :id", "id={$FichaVVitoriosaId}");
            if ($Read->getResult()):
                $data['FichaVVitoriosaData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('fichaVVitoriosa/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($FichaVVitoriosaId) {
        $data = array(
            'GetExe' => 'fichaVVitoriosa',
            'GetExeLb' => 'Fichas Vida Vitoriosa',
            'GetExeLbs' => 'Fichas Vida Vitoriosa',
        );

        $login = new Login();
        if ($FichaVVitoriosaId && $login->hasPermission('fichasVVitoriosa') && $login->hasPermission('fichasVVitoriosa_deletar')):
            $fichaVVitoriosa = new FichaVVitoriosa();
            $fichaVVitoriosa->ExeDelete($FichaVVitoriosaId);
            WSErro($fichaVVitoriosa->getError()[0], $fichaVVitoriosa->getError()[1]);
            header("Location: " . BASE . "/fichaVVitoriosa");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
