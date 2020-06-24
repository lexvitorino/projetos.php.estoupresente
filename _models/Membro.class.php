<?php

class Membro {

    private $Data;
    private $Membro;
    private $Error;
    private $Result;

    /*
     * ***************************************
     * **********  PUBLIC CONSULTAS **********
     * ***************************************
     */

    public function getLideres() {
        $Membros = array();

        $Read = new Read();
        $Read->ExeRead(MEMBRO, "WHERE (id_lider = :idLider OR id = :idLider) AND encargo not in ('Membro','Auxiliar') ORDER BY nome ASC", "idLider=" . MEMBRO_ID);
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;

        return $Membros;
    }

    public function getMembros() {
        $Membros = array();

        $Read = new Read();
        $Read->ExeRead(MEMBRO, "WHERE id_lider = :idLider ORDER BY nome ASC", "idLider=" . MEMBRO_ID);
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;

        return $Membros;
    }

    public function getMembrosPorEncargo($Encargo) {
        if ($Encargo == 'Membro' || $Encargo == 'Auxiliar'):
            $Encargo = 'Lider';
        elseif ($Encargo == 'Lider'):
            $Encargo = 'Supervisor';
        elseif ($Encargo == 'Supervisor'):
            $Encargo = 'Area';
        elseif ($Encargo == 'Area'):
            $Encargo = 'Pastor';
        elseif ($Encargo == 'Pastor'):
            $Encargo = 'Distrito';
        endif;

        $Membros = array();
        $Read = new Read();
        $Read->FullRead("SELECT * FROM " . MEMBRO . " m" .
                " WHERE m.id_subscriber = :idSubscriber AND m.encargo = :encargo " . LIDERES .
                " ORDER BY m.nome DESC", "idSubscriber=" . SUBSCRIBER_ID . "&idMembro=" . MEMBRO_ID . "&encargo=" . $Encargo);
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;

        return $Membros;
    }

    public function getMembrosPorDirigente($idLider) {
        $Membros = array();

        $Read = new Read();
        $Read->ExeRead(MEMBRO, "WHERE id_lider = :idLider AND id_subscriber = :idSubscriber
                                ORDER BY nome ASC", "idSubscriber=" . SUBSCRIBER_ID . "&idLider={$idLider}");
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;

        return $Membros;
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
        $this->Membro = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Membro = (int) $Id;

        $read = new Read;
        $read->ExeRead(MEMBRO, "WHERE id = :id", "id={$this->Membro}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover um membro que não existe no sistema!', WS_ERROR];
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

        if (empty($this->Data['email'])) {
            unset($this->Data['email']);
        }
        if (empty($this->Data['email_copia'])) {
            unset($this->Data['email_copia']);
        }
        if (empty($this->Data['telefone'])) {
            unset($this->Data['telefone']);
        }
        if (empty($this->Data['celular'])) {
            unset($this->Data['celular']);
        }
        if (empty($this->Data['anfitriao'])) {
            $this->Data['anfitriao'] = 'N';
        }
        if (empty($this->Data['dirigente'])) {
            $this->Data['dirigente'] = 'N';
        }
        if (empty($this->Data['telefone'])) {
            unset($this->Data['telefone']);
        }
        if (empty($this->Data['celular'])) {
            unset($this->Data['celular']);
        }
        if (empty($this->Data['data_nascimento'])) {
            unset($this->Data['data_nascimento']);
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
        $Create->ExeCreate(MEMBRO, $this->Data);

        if ($Create->getResult()):

            if (($this->Data["encargo"] == "Lider") || ($this->Data["encargo"] == "Supervisor") || ($this->Data["encargo"] == "Area")):
                $ResultUser = $this->CreateUser($Create->getResult());
            endif;

            if ($this->Data["encargo"] == "Lider" || ($this->Data["encargo"] == "Supervisor" && $this->Data["dirigente"] == "S")):
                $ResultCelula = $this->CreateCelula($Create->getResult());
            endif;

            $this->Error = ["O membro <b>{$this->Data['nome']}</b> foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(MEMBRO, $this->Data, "WHERE id = :id", "id={$this->Membro}");
        if ($Update->getResult()):

            if (1 == 2 && ADMIN):
                if (($this->Data["encargo"] == "Lider") || ($this->Data["encargo"] == "Supervisor") || ($this->Data["encargo"] == "Area")):
                    $ResultUser = $this->CreateUser($this->Membro);
                endif;

                if ($this->Data["encargo"] == "Lider" || ($this->Data["encargo"] == "Supervisor" && $this->Data["dirigente"] == "S")):
                    $ResultCelula = $this->CreateCelula($this->Membro);
                endif;
            endif;

            $this->Error = ["O membro <b>{$this->Data['nome']}</b> foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function CreateUser($MembroId) {
        $loginr = explode(" ", $this->Data["nome"]);
        $login = strtolower($loginr[0])[0] . strtolower($loginr[count($loginr) - 1]);

        $ReadUser = new Read();
        $ReadUser->ExeRead(USUARIO, "WHERE login = :login", "login={$login}");
        if ($ReadUser->getRowCount() > 0) {
            return NULL;
        }

        $IdGrupo = 2;
        if ($this->Data["encargo"] == "Area"):
            $IdGrupo = 1;
        elseif ($this->Data["encargo"] == "Supervisor"):
            $IdGrupo = 3;
        endif;

        $DadosUser = array(
            "name" => $this->Data["nome"],
            "login" => $login,
            "password" => md5("123456"),
            "altera_senha" => 0,
            "chave" => $MembroId,
            "id_group" => $IdGrupo,
            "id_subscriber" => 1,
            "is_admin" => 0
        );

        $CreateUser = new Create;
        $CreateUser->ExeCreate(USUARIO, $DadosUser);

        return $CreateUser->getResult();
    }

    private function CreateCelula($MembroId) {
        $ReadCelula = new Read();
        $ReadCelula->ExeRead(CELULA, "WHERE nome = :nome", "nome={$this->Data["nome"]}");
        if ($ReadCelula->getRowCount() > 0) {
            return NULL;
        }

        $IdSupervisor = 0;
        $IdArea = 0;

        if ($this->Data["encargo"] == "Lider"):
            $IdSupervisor = $this->Data["id_lider"];
            $ReadArea = new Read();
            $ReadArea->ExeRead(MEMBRO, "WHERE id = :id", "id={$IdSupervisor}");
            if ($ReadArea->getResult()):
                $IdArea = $ReadArea->getResult()[0]['id_lider'];
            endif;
        elseif ($this->Data["encargo"] == "Supervisor" && $this->Data["dirigente"] == "S"):
            $IdSupervisor = $MembroId;
            $idArea = $this->Data["id_lider"];
        endif;

        $DadosCelula = array(
            "id_comuna" => 1,
            "id_anfitriao" => $MembroId,
            "id_dirigente" => $MembroId,
            "id_supervisor" => $IdSupervisor,
            "id_area" => $IdArea,
            "nome" => $this->Data["nome"],
            "dia" => "Sabado",
            "horario" => "17 hs"
        );

        $CreateCelula = new Create;
        $CreateCelula->ExeCreate(CELULA, $DadosCelula);

        return $CreateCelula->getResult();
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(MEMBRO, "WHERE id = :id", "id={$this->Membro}");
        if ($Delete->getResult()):
            $this->Error = ["Membro removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
