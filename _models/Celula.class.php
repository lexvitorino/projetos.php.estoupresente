<?php

class Celula {

    private $Data;
    private $Celula;
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
        $this->Celula = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Celula = (int) $Id;

        $readUser = new Read;
        $readUser->ExeRead(CELULA, "WHERE id = :id", "id={$this->Celula}");

        if (!$readUser->getResult()):
            $this->Error = ['Oppsss, você tentou remover um celula que não existe no sistema!', WS_ERROR];
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

    public function inicializaCampos($data) {

        if (empty($data['ver_tot_mensal'])):
            $data['ver_tot_mensal'] = 'N';
        endif;
        if (empty($data['ver_ate11'])):
            $data['ver_ate11'] = 'N';
        endif;
        if (empty($data['ver_de12a14'])):
            $data['ver_de12a14'] = 'N';
        endif;
        if (empty($data['ver_de15a17'])):
            $data['ver_de15a17'] = 'N';
        endif;
        if (empty($data['ver_hs'])):
            $data['ver_hs'] = 'N';
        endif;
        if (empty($data['ver_hc'])):
            $data['ver_hc'] = 'N';
        endif;
        if (empty($data['ver_ms'])):
            $data['ver_ms'] = 'N';
        endif;
        if (empty($data['ver_mc'])):
            $data['ver_mc'] = 'N';
        endif;
        if (empty($data['universidade'])):
            $data['universidade'] = 'N';
        endif;
        if (empty($data['ativo'])):
            $data['ativo'] = 1;
        endif;
        if (empty($data['ge'])):
            $data['ge'] = 'N';
        endif;

        return $data;
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function checkData() {

        if (empty($this->Data['id_dirigente_crianca_1']) || $this->Data['id_dirigente_crianca_1'] == '0'):
            unset($this->Data['id_dirigente_crianca_1']);
        endif;
        if (empty($this->Data['id_dirigente_crianca_2']) || $this->Data['id_dirigente_crianca_2'] == '0'):
            unset($this->Data['id_dirigente_crianca_2']);
        endif;
        if (empty($this->Data['id_auxiliar']) || $this->Data['id_auxiliar'] == '0'):
            unset($this->Data['id_auxiliar']);
        endif;
        if (empty($this->Data['id_auxiliar_treinamento_1']) || $this->Data['id_auxiliar_treinamento_1'] == '0'):
            unset($this->Data['id_auxiliar_treinamento_1']);
        endif;
        if (empty($this->Data['id_auxiliar_treinamento_2']) || $this->Data['id_auxiliar_treinamento_2'] == '0'):
            unset($this->Data['id_auxiliar_treinamento_2']);
        endif;
        if (empty($this->Data['complemento']) || $this->Data['complemento'] == '0'):
            unset($this->Data['complemento']);
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
        $Create->ExeCreate(CELULA, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O celula <b>{$this->Data['nome']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(CELULA, $this->Data, "WHERE id = :id", "id={$this->Celula}");
        if ($Update->getResult()):
            $this->Error = ["O celula <b>{$this->Data['nome']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(CELULA, "WHERE id = :id", "id={$this->Celula}");
        if ($Delete->getResult()):
            $this->Error = ["Célula removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
