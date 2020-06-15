<?php

class CelulaVisitada {

    private $Data;
    private $CelulaVisitada;
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
        $this->CelulaVisitada = (int) $Id;
        $this->Data = $Data;

        $this->checkData();
        
        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->CelulaVisitada = (int) $Id;

        $read = new Read;
        $read->ExeRead(CELULA_VISITADA, "WHERE id = :id", "id={$this->CelulaVisitada}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover um visita que não existe no sistema!', WS_ERROR];
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
        $Create->ExeCreate(CELULA_VISITADA, $this->Data);
        if ($Create->getResult()):
            $this->Error = ["A visita foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(CELULA_VISITADA, $this->Data, "WHERE id = :id", "id={$this->CelulaVisitada}");
        if ($Update->getResult()):
            $this->Error = ["A visita foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(CELULA_VISITADA, "WHERE id = :id", "id={$this->CelulaVisitada}");
        if ($Delete->getResult()):
            $this->Error = ["A visita foi removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
