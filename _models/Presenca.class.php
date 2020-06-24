<?php

class Presenca {

    private $Data;
    private $Presenca;
    private $Error;
    private $Result;

    /*
     * ***************************************
     * **********  PUBLIC CONSULTAS **********
     * ***************************************
     */
    
    public function InitPresenca($IdCelula, $MesAno) {
        return $this->ExeCreatePorMesAno($IdCelula, $MesAno)[0];
    }

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
        $this->Presenca = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Presenca = (int) $Id;

        $read = new Read;
        $read->ExeRead(PRESENCA, "WHERE id = :id", "id={$this->Presenca}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover uma presença que não existe no sistema!', WS_ERROR];
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
        
        if(empty($this->Data['total_decisoes_mes'])):
            unset($this->Data['total_decisoes_mes']);
        endif;
        if(empty($this->Data['total_batizados_mes'])):
            unset($this->Data['total_batizados_mes']);
        endif;
        if(empty($this->Data['total_vida_vitoriosa_mes'])):
            unset($this->Data['total_vida_vitoriosa_mes']);
        endif;
        if(empty($this->Data['total_maior_12_anos_mes'])):
            unset($this->Data['total_maior_12_anos_mes']);
        endif;
        if(empty($this->Data['total_menor_11_anos_mes'])):
            unset($this->Data['total_menor_11_anos_mes']);
        endif;
        if(empty($this->Data['total_celulas_criancas_mes'])):
            unset($this->Data['total_celulas_criancas_mes']);
        endif;
        if(empty($this->Data['auxiliar_vigilia'])):
            unset($this->Data['auxiliar_vigilia']);
        endif;
        if(empty($this->Data['auxiliar_treinamento_1_vigilia'])):
            unset($this->Data['auxiliar_treinamento_1_vigilia']);
        endif;
        if(empty($this->Data['auxiliar_treinamento_2_vigilia'])):
            unset($this->Data['auxiliar_treinamento_2_vigilia']);
        endif;        
        
        if (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(PRESENCA, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["A presença foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(PRESENCA, $this->Data, "WHERE id = :id", "id={$this->Presenca}");
        if ($Update->getResult()):
            $this->Error = ["A presença foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(PRESENCA, "WHERE id = :id", "id={$this->Presenca}");
        if ($Delete->getResult()):
            $this->Error = ["Presenca removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }
    
    private function ExeCreatePorMesAno($IdCelula, $MesAno) {
        $data = array();
        $data['id_celula'] = $IdCelula;
        $data['mes_ano'] = $MesAno;
        
        $this->ExeCreate($data);
        if ($this->getResult()):
            $Read = new Read();
            $Read->ExeRead(PRESENCA, "WHERE id = :id", "id={$this->getResult()}");
            return $Read->getResult();
        else:
            return $this->Error = ["Não foi retornado nenhuma informação!", WS_ALERT];
        endif;
    }

}
