<?php

class Usuario {

    private $Data;
    private $Usuario;
    private $Error;
    private $Result;

    /*
     * ***************************************
     * ******* PUBLIC CONSULTATIONS **********
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
        $this->Usuario = (int) $Id;
        $this->Data = $Data;

        if (!$this->Data['password']):
            unset($this->Data['password']);
        endif;

        if (!$this->Data['repassword']):
            unset($this->Data['repassword']);
        endif;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Usuario = (int) $Id;

        $readUser = new Read;
        $readUser->ExeRead(USUARIO, "WHERE id = :id", "id={$this->Usuario}");

        if (!$readUser->getResult()):
            $this->Error = ['Oppsss, você tentou remover um usuário que não existe no sistema!', WS_ERROR];
            $this->Result = false;
        elseif ($this->Usuario == $_SESSION['userlogin']['id']):
            $this->Error = ['Oppsss, você tentou remover seu usuário. Essa ação não é permitida!!!', WS_INFOR];
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
        elseif (isset($this->Data['password']) && (strlen($this->Data['password']) < 6 || strlen($this->Data['password']) > 12)):
            $this->Error = ["A senha deve ter entre 6 e 12 caracteres!", WS_ALERT];
            $this->Result = false;
        elseif (isset($this->Data['password']) && $this->Data['password'] !== $this->Data['repassword']):
            $this->Error = ["Senha não podem ser diferentes!", WS_ALERT];
            $this->Result = false;
        else:
            $this->Result = true;
        endif;
    }

    private function Create() {
        $Create = new Create;

        $this->Data['password'] = md5($this->Data['password']);
        unset($this->Data['repassword']);

        $Create->ExeCreate(USUARIO, $this->Data);

        if ($Create->getResult()):
            $this->Error = ["O usuário <b>{$this->Data['name']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;

        unset($this->Data['repassword']);
        if (isset($this->Data['password'])):
            $this->Data['password'] = md5($this->Data['password']);
        endif;

        $Update->ExeUpdate(USUARIO, $this->Data, "WHERE id = :id", "id={$this->Usuario}");
        if ($Update->getResult()):
            $this->Error = ["O usuário <b>{$this->Data['name']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(USUARIO, "WHERE id = :id", "id={$this->Usuario}");
        if ($Delete->getResult()):
            $this->Error = ["Usuário removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
