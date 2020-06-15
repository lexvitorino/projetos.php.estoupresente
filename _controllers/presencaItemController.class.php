<?php

class presencaItemController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function create($PresencaItemId) {
        $data = array(
            'GetExe' => 'presencaItem',
            'GetExeLb' => 'Presença',
            'GetExeLbs' => 'Presenças',
            'PresencaItemData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('presencas') && $login->hasPermission('presencas_novo')) {

            $data['PresencaItemData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);

            if ($PresencaItemData && $PresencaItemData['SendPostForm']):
                unset($PresencaItemData['SendPostForm']);

                $presencaItem = new PresencaItem();
                $presencaItem->ExeCreate($PresencaItemData);
                if ($presencaItem->getResult()):
                    WSErro($presencaItem->getError()[0], $presencaItem->getError()[1]);
                    header("Location: " . BASE . "/presenca");
                else:
                    WSErro($presencaItem->getError()[0], $presencaItem->getError()[1]);
                endif;
            endif;

            $data['PresencaItemData']['id_presenca'] = $PresencaItemId;
            $this->loadTamplate('presenca/dataItem', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($PresencaItemId) {
        $data = array(
            'GetExe' => 'presencaItem',
            'GetExeLb' => 'Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
            'PresencaItemData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('presencas') && $login->hasPermission('presencas_editar')) {

            $PresencaItemData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($PresencaItemData && $PresencaItemData['SendPostForm']):
                unset($PresencaItemData['SendPostForm']);

                $PresencaItem = new PresencaItem();
                $PresencaItem->ExeUpdate($PresencaItemId, $PresencaItemData);
                if ($PresencaItem->getResult()):
                    WSErro($PresencaItem->getError()[0], $PresencaItem->getError()[1]);
                    header("Location: " . BASE . "/presenca");
                else:
                    WSErro($PresencaItem->getError()[0], $PresencaItem->getError()[1]);
                endif;
            endif;

            $Read = new Read();
            $Read->ExeRead(PRESENCA_ITEM, "WHERE id = :id", "id={$PresencaItemId}");
            if ($Read->getResult()):
                $data['PresencaItemData'] = $Read->getResult()[0];
            endif;

            $this->loadTamplate('presenca/dataItem', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($PresencaItemId) {
        $data = array(
            'GetExe' => 'presencaItem',
            'GetExeLb' => 'Fichas Festa Colheita',
            'GetExeLbs' => 'Fichas Festa Colheita',
        );

        $Read = new Read;
        $Read->ExeRead(PRESENCA_ITEM, "WHERE id = :id", "id={$PresencaItemId}");
        if ($Read->getResult()):
            $PresencaItemData = $Read->getResult()[0];
        endif;

        $login = new Login();
        if ($PresencaItemId && $login->hasPermission('presencas') && $login->hasPermission('presencas_deletar')):
            $presencaItem = new PresencaItem();
            $presencaItem->ExeDelete($PresencaItemId);
            WSErro($presencaItem->getError()[0], $presencaItem->getError()[1]);
            header("Location: " . BASE . "/presenca");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
