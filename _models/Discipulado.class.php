<?php

class Discipulado {

    private $Data;
    private $Discipulado;
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
        $this->Discipulado = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Discipulado = (int) $Id;

        $read = new Read;
        $read->ExeRead(DISCIPULADO, "WHERE id = :id", "id={$this->Discipulado}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover um discipulado que não existe no sistema!', WS_ERROR];
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

        $this->Data['conversa'] = base64_encode($this->Data['conversa']);

        if (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(DISCIPULADO, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O discipulado <b>{$this->Data['com_quem']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(DISCIPULADO, $this->Data, "WHERE id = :id", "id={$this->Discipulado}");
        if ($Update->getResult()):
            $this->Error = ["O discipulado <b>{$this->Data['com_quem']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(DISCIPULADO, "WHERE id = :id", "id={$this->Discipulado}");
        if ($Delete->getResult()):
            $this->Error = ["Discipulado removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
