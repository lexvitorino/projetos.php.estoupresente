<?php

class FichaFColheita {

    private $Data;
    private $FichaFColheita;
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
        $this->FichaFColheita = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->FichaFColheita = (int) $Id;

        $read = new Read;
        $read->ExeRead(FICHA_FCOLHEITA, "WHERE id = :id", "id={$this->FichaFColheita}");

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

        if(empty($this->Data['encargo'])):
            $this->Data['encargo'] = ENCARGO;
        endif;
        
        $f = new Upload("./_uploads/fotos/");
        if(!empty($_FILES['foto']['name'])):
            $f->Image($_FILES['foto'], Check::Name($_FILES['foto']['name']));
            if ($f->getResult()):
                $this->Data['foto'] = $f->getResult();
            endif;
        endif;
        
        if (!empty($_FILES['foto']['name']) && !$f->getResult()):
            $this->Error = [$f->getError(), WS_ALERT];
            $this->Result = false;
        elseif (in_array('', $this->Data)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(FICHA_FCOLHEITA, $this->Data);
        if ($Create->getResult()):
            $this->Error = ["A ficha de <b>{$this->Data['nome']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(FICHA_FCOLHEITA, $this->Data, "WHERE id = :id", "id={$this->FichaFColheita}");
        if ($Update->getResult()):
            $this->Error = ["A ficha de <b>{$this->Data['nome']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(FICHA_FCOLHEITA, "WHERE id = :id", "id={$this->FichaFColheita}");
        if ($Delete->getResult()):
            $this->Error = ["A ficha foi removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
