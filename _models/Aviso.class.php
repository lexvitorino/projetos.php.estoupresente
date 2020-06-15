<?php

class Aviso {

    private $Data;
    private $Aviso;
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
        $this->Aviso = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Aviso = (int) $Id;

        $read = new Read;
        $read->ExeRead(AVISO, "WHERE id = :id", "id={$this->Aviso}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover um aviso que não existe no sistema!', WS_ERROR];
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
        
        if (empty($this->Data['publico'])) {
            $this->Data['publico'] = 'N';
        }
        if (empty($this->Data['ativo'])) {
            $this->Data['ativo'] = 'N';
        }
        if (empty($this->Data['id_membro'])) {
            unset($this->Data['id_membro']);
        }
        
        if (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(AVISO, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O aviso foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(AVISO, $this->Data, "WHERE id = :id", "id={$this->Aviso}");
        if ($Update->getResult()):
            $this->Error = ["O aviso foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(AVISO, "WHERE id = :id", "id={$this->Aviso}");
        if ($Delete->getResult()):
            $this->Error = ["Aviso removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
