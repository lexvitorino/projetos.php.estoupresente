<?php

class PresencaItem {

    private $Data;
    private $PresencaItem;
    private $Error;
    private $Result;

    /*
     * ***************************************
     * **********  PUBLIC CONSULTAS **********
     * ***************************************
     */

    /*
     * ***************************************
     * **********  PUBLIC METHODS  ***********
     * ***************************************
     */

    public function ExeCreate(array $Data) {
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Create();
        endif;
    }

    public function ExeUpdate($Id, array $Data) {
        $this->PresencaItem = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->PresencaItem = (int) $Id;

        $read = new Read;
        $read->ExeRead(PRESENCA_ITEM, "WHERE id = :id", "id={$this->PresencaItem}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover uma ficha que não existe no sistema!', WS_ERROR];
            $this->Result = false;
        else:
            $this->Delete();
        endif;
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function checkData() {

        if (empty($this->Data['semana'])):
            $Read = new Read();
            $Read->ExeRead(PRESENCA_ITEM, "WHERE id_presenca = :id", "id={$this->Data['id_presenca']}");

            $this->Data['semana'] = 1;
            if ($Read->getResult()):
                $this->Data['semana'] = $Read->getRowCount() + 1;
            endif;
        endif;

        $this->Data['total_geral'] = intval($this->Data['ate_11']) + intval($this->Data['adol_12_14_anos']) + intval($this->Data['adol_15_17_anos']) + intval($this->Data['homens_casados']) +
                intval($this->Data['homens_solteiros']) + intval($this->Data['mulheres_casadas']) + intval($this->Data['mulheres_solteiras']);
        
        if (empty($this->Data['ate_11'])):
            $this->Data['ate_11'] = "0";
        endif; 
        if (empty($this->Data['adol_12_14_anos'])):
            $this->Data['adol_12_14_anos'] = "0";
        endif;
        if (empty($this->Data['adol_15_17_anos'])):
            $this->Data['adol_15_17_anos'] = "0";
        endif; 
        if (empty($this->Data['homens_casados'])):
            $this->Data['homens_casados'] = "0";
        endif; 
        if (empty($this->Data['homens_solteiros'])):
            $this->Data['homens_solteiros'] = "0";
        endif;
        if (empty($this->Data['mulheres_casadas'])):
            $this->Data['mulheres_casadas'] = "0";
        endif;
        if (empty($this->Data['mulheres_solteiras'])):
            $this->Data['mulheres_solteiras'] = "0";
        endif;
        if (empty($this->Data['total_visitas'])):
            $this->Data['total_visitas'] = "0";
        endif;
        if (empty($this->Data['total_decisoes'])):
            $this->Data['total_decisoes'] = "0";
        endif;
        if (empty($this->Data['auxiliar_encontro_9'])):
            $this->Data['auxiliar_encontro_9'] = "0";
        endif;
        if (empty($this->Data['auxiliar_encontro_18'])):
            $this->Data['auxiliar_encontro_18'] = "0";
        endif;
        if (empty($this->Data['auxiliar_encontro_ide'])):
            $this->Data['auxiliar_encontro_ide'] = "0";
        endif;
        if (empty($this->Data['auxiliar_treinamento_1_encontro_9'])):
            $this->Data['auxiliar_treinamento_1_encontro_9'] = "0";
        endif;
        if (empty($this->Data['auxiliar_treinamento_1_encontro_18'])):
            $this->Data['auxiliar_treinamento_1_encontro_18'] = "0";
        endif;
        if (empty($this->Data['auxiliar_treinamento_1_encontro_ide'])):
            $this->Data['auxiliar_treinamento_1_encontro_ide'] = "0";
        endif;
        if (empty($this->Data['auxiliar_treinamento_2_encontro_9'])):
            $this->Data['auxiliar_treinamento_2_encontro_9'] = "0";
        endif;
        if (empty($this->Data['auxiliar_treinamento_2_encontro_18'])):
            $this->Data['auxiliar_treinamento_2_encontro_18'] = "0";
        endif;
        if (empty($this->Data['auxiliar_treinamento_2_encontro_ide'])):
            $this->Data['auxiliar_treinamento_2_encontro_ide'] = "0";
        endif;
        if (empty($this->Data['total_geral'])):
            $this->Data['total_geral'] = "0";
        endif;
        
        //var_dump(array_search('', $this->Data)); exit;
        
        if (in_array('', $this->Data)):
            $fieldBanco = array_search('', $this->Data);
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos! <p>CAMPO.: {$fieldBanco}</p>", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(PRESENCA_ITEM, $this->Data);
        if ($Create->getResult()):
            $this->Error = ["A presença foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(PRESENCA_ITEM, $this->Data, "WHERE id = :id", "id={$this->PresencaItem}");
        if ($Update->getResult()):
            $this->Error = ["A presença foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(PRESENCA_ITEM, "WHERE id = :id", "id={$this->PresencaItem}");
        if ($Delete->getResult()):
            $this->Error = ["A presença foi removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
