<?php

class fichaFColheitaController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Fichas Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
        );

        $login = new Login();
        if ($login->hasPermission('fichasVVitoriosa')) {
            $this->loadTamplate('fichaFColheita/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
            'FichaFColheitaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('fichasVVitoriosa') && $login->hasPermission('fichasVVitoriosa_novo')) {

            $data['FichaFColheitaData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($FichaFColheitaData && $FichaFColheitaData['SendPostForm']):
                unset($FichaFColheitaData['SendPostForm']);
            
                $fichaFColheita = new FichaFColheita();
                $fichaFColheita->ExeCreate($FichaFColheitaData);
                if ($fichaFColheita->getResult()):
                    WSErro($fichaFColheita->getError()[0], $fichaFColheita->getError()[1]);
                    header("Location: " . BASE . "/fichaFColheita");
                else:
                    WSErro($fichaFColheita->getError()[0], $fichaFColheita->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('fichaFColheita/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($FichaFColheitaId) {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
            'FichaFColheitaData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('fichasVVitoriosa') && $login->hasPermission('fichasVVitoriosa_editar')) {

            $FichaFColheitaData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($FichaFColheitaData && $FichaFColheitaData['SendPostForm']):
                unset($FichaFColheitaData['SendPostForm']);
            
                $fichaFColheita = new FichaFColheita();
                $fichaFColheita->ExeUpdate($FichaFColheitaId, $FichaFColheitaData);
                if ($fichaFColheita->getResult()):
                    WSErro($fichaFColheita->getError()[0], $fichaFColheita->getError()[1]);
                    header("Location: " . BASE . "/fichaFColheita");
                else:
                    WSErro($fichaFColheita->getError()[0], $fichaFColheita->getError()[1]);
                endif;
            endif;

            $Read = new Read();
            $Read->ExeRead(FICHA_FCOLHEITA, "WHERE id = :id", "id={$FichaFColheitaId}");
            if ($Read->getResult()):
                $data['FichaFColheitaData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('fichaFColheita/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($FichaFColheitaId) {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Fichas Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
        );

        $Read = new Read();
        $Read->ExeRead(FICHA_FCOLHEITA_ITEM, "WHERE id_ficha_fcolheita = :id", "id={$FichaFColheitaId}");
        if ($Read->getResult()):
            WSErro('Existem itens relacionados a esta ficha', WS_ALERT);
            header("Location: " . BASE . "/fichaFColheita");
        else:
            $login = new Login();
            if ($FichaFColheitaId && $login->hasPermission('fichasVVitoriosa') && $login->hasPermission('fichasVVitoriosa_deletar')):
                $fichaFColheita = new FichaFColheita();
                $fichaFColheita->ExeDelete($FichaFColheitaId);
                WSErro($fichaFColheita->getError()[0], $fichaFColheita->getError()[1]);
                header("Location: " . BASE . "/fichaFColheita");
            else:
                $this->loadTamplate('nopermission', $data);
            endif;
        endif;
    }

}
