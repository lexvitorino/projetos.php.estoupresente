<?php

class Anexo {

    private $Data;
    private $Anexo;
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
        $this->Anexo = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Anexo = (int) $Id;

        $read = new Read;
        $read->ExeRead(ANEXO, "WHERE id = :id", "id={$this->Anexo}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover um anexo que não existe no sistema!', WS_ERROR];
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
        
        if (empty($this->Data['publico'])):
            $this->Data['publico'] = 'N';
        endif;
        if (empty($this->Data['ativo'])):
            $this->Data['ativo'] = 'N';
        endif;
        if (empty($this->Data['id_membro'])):
            unset($this->Data['id_membro']);
        endif;

        $f = new Upload("./_uploads/");
        if(!empty($_FILES['caminho']['name'])):
            $f->File($_FILES['caminho'], $_FILES['caminho']['name']);
            if ($f->getResult()):
                $this->Data['caminho'] = $f->getResult();
                $this->Data['tipo'] = $_FILES['caminho']['type'];
            endif;
        endif;

        if (!empty($_FILES['caminho']['name']) && !$f->getResult()):
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
        $Create->ExeCreate(ANEXO, $this->Data);
        if ($Create->getResult()):
            $this->Error = ["O anexo <b>{$this->Data['nome']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(ANEXO, $this->Data, "WHERE id = :id", "id={$this->Anexo}");
        if ($Update->getResult()):
            $this->Error = ["O anexo <b>{$this->Data['nome']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(ANEXO, "WHERE id = :id", "id={$this->Anexo}");
        if ($Delete->getResult()):
            $this->Error = ["Anexo removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
