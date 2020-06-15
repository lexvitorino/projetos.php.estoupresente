<?php

class fichaFColheitaItemController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function create($FichaFColheitaId) {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
            'FichaFColheitaItemData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('fichasFColheita') && $login->hasPermission('fichasFColheita_novo')) {

            $data['FichaFColheitaItemData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data['FichaFColheitaItemData']['id_ficha_fcolheita'] = $FichaFColheitaId;
            extract($data);

            if ($FichaFColheitaItemData && !empty($FichaFColheitaItemData['SendPostForm'])):
                unset($FichaFColheitaItemData['SendPostForm']);

                $fichaFColheitaItem = new FichaFColheita();
                $fichaFColheitaItem->ExeCreate($FichaFColheitaItemData);
                if ($fichaFColheitaItem->getResult()):
                    WSErro($fichaFColheitaItem->getError()[0], $fichaFColheitaItem->getError()[1]);
                    header("Location: " . BASE . "/fichaFColheita/" . $FichaFColheitaId);
                else:
                    WSErro($fichaFColheitaItem->getError()[0], $fichaFColheitaItem->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('fichaFColheita/dataItem', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($FichaFColheitaItemId) {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
            'FichaFColheitaItemData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('fichasFColheita') && $login->hasPermission('fichasFColheita_editar')) {

            $FichaFColheitaItemData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($FichaFColheitaItemData && $FichaFColheitaItemData['SendPostForm']):
                unset($FichaFColheitaItemData['SendPostForm']);

                $FichaFColheitaItem = new FichaFColheitaItem();
                $FichaFColheitaItem->ExeUpdate($FichaFColheitaItemId, $FichaFColheitaItemData);
                if ($FichaFColheitaItem->getResult()):
                    WSErro($FichaFColheitaItem->getError()[0], $FichaFColheitaItem->getError()[1]);
                    header("Location: " . BASE . "/fichaFColheita/update/" . $FichaFColheitaItemData['id_ficha_fcolheita']);
                else:
                    WSErro($FichaFColheitaItem->getError()[0], $FichaFColheitaItem->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(FICHA_FCOLHEITA_ITEM, "WHERE id = :id", "id={$FichaFColheitaItemId}");
            if ($Read->getResult()):
                $data['FichaFColheitaItemData'] = $Read->getResult()[0];
            endif;

            $this->loadTamplate('fichaFColheita/dataItem', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($FichaFColheitaItemId) {
        $data = array(
            'GetExe' => 'fichaFColheita',
            'GetExeLb' => 'Fichas Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
        );

        $Read = new Read;
        $Read->ExeRead(FICHA_FCOLHEITA_ITEM, "WHERE id = :id", "id={$FichaFColheitaItemId}");
        if ($Read->getResult()):
            $FichaFColheitaItemData = $Read->getResult()[0];
        endif;

        $login = new Login();
        if ($FichaFColheitaItemId && $login->hasPermission('fichasFColheita') && $login->hasPermission('fichasFColheita_deletar')):
            $fichaFColheitaItem = new FichaFColheitaItem();
            $fichaFColheitaItem->ExeDelete($FichaFColheitaItemId);
            WSErro($fichaFColheitaItem->getError()[0], $fichaFColheitaItem->getError()[1]);
            header("Location: " . BASE . "/fichaFColheita/update/" . $FichaFColheitaItemData['id_ficha_fcolheita']);
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
