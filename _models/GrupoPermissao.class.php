<?php

class GrupoPermissao {

    private $Data;
    private $Grupo;
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
        $this->GrupoPermissao = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->GrupoPermissao = (int) $Id;

        $read = new Read;
        $read->ExeRead(PERMISSION_GRUPO, "WHERE id = :id", "id={$this->GrupoPermissao}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover um grupo de permissões que não existe no sistema!', WS_ERROR];
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
        if (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(PERMISSION_GRUPO, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O grupo foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(PERMISSION_GRUPO, $this->Data, "WHERE id = :id", "id={$this->GrupoPermissao}");
        if ($Update->getResult()):
            $this->Error = ["O grupo foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(PERMISSION_GRUPO, "WHERE id = :id", "id={$this->GrupoPermissao}");
        if ($Delete->getResult()):
            $this->Error = ["Grupo removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
