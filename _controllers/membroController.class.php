<?php

class membroController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'membro',
            'GetExeLb' => 'Membros',
            'GetExeLbs' => 'Membros',
        );

        $login = new Login();
        if ($login->hasPermission('membros')) {
            $this->loadTamplate('membro/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'membro',
            'GetExeLb' => 'Membro',
            'GetExeLbs' => 'Membros',
            'MembroData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('membros') && $login->hasPermission('membros_novo')) {

            $data['MembroData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);

            if ($MembroData && $MembroData['SendPostForm']):
                unset($MembroData['SendPostForm']);

                $membro = new Membro();
                $membro->ExeCreate($MembroData);
                if ($membro->getResult()):
                    WSErro($membro->getError()[0], $membro->getError()[1]);
                    header("Location: " . BASE . "/membro");
                else:
                    WSErro($membro->getError()[0], $membro->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('membro/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($MembroId) {
        $data = array(
            'GetExe' => 'membro',
            'GetExeLb' => 'Membro',
            'GetExeLbs' => 'Membros',
            'MembroData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('membros') && $login->hasPermission('membros_editar')) {

            $MembroData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($MembroData && $MembroData['SendPostForm']):
                unset($MembroData['SendPostForm']);

                $membro = new Membro();
                $membro->ExeUpdate($MembroId, $MembroData);
                if ($membro->getResult()):
                    WSErro($membro->getError()[0], $membro->getError()[1]);
                    header("Location: " . BASE . "/membro");
                else:
                    WSErro($membro->getError()[0], $membro->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(MEMBRO, "WHERE id = :id", "id={$MembroId}");
            if ($Read->getResult()):
                $data['MembroData'] = $Read->getResult()[0];
            endif;

            $this->loadTamplate('membro/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($MembroId) {
        $data = array(
            'GetExe' => 'membro',
            'GetExeLb' => 'Membro',
            'GetExeLbs' => 'Membros',
        );
        
        $login = new Login();
        if ($MembroId && $login->hasPermission('membros') && $login->hasPermission('membros_deletar')):
            $membro = new Membro();
            $membro->ExeDelete($MembroId);
            WSErro($membro->getError()[0], $membro->getError()[1]);
            header("Location: " . BASE . "/membro");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

    public function getMembrosPorEncargo($Encargo) {
        $Membro = new Membro();
        $Membros = $Membro->getMembrosPorEncargo($Encargo);
        if(empty($Membros)):
            $Membros = array();
        endif;
        echo json_encode($Membros);
    }

    public function getMembrosPorLiderEEncargo($IdLider, $Encargo) {
        $Membros = array();
        $Read = new Read();
        $Read->ExeRead(MEMBRO, "WHERE encargo = :encargo and id_lider = :idLider ORDER BY nome ASC", "encargo={$Encargo}&idLider={$IdLider}");
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;
        echo json_encode($Membros);
    }

    public function getDirigentePorSupervisor($IdLider) {
        $Membros = array();
        $Read = new Read();
        $Read->ExeRead(MEMBRO, "WHERE (encargo = 'Lider' and id_lider = :idLider) OR (dirigente = 'S' and id = :idLider) ORDER BY nome ASC", "idLider={$IdLider}");
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;
        echo json_encode($Membros);
    }

    public function getAnfitrioesPorDirigente($IdLider) {
        $Membros = array();
        $Read = new Read();
        $Read->ExeRead(MEMBRO, "WHERE anfitriao = 'S' and (id_lider = :idLider OR id = :idLider) ORDER BY nome ASC", "idLider={$IdLider}");
        if ($Read->getResult()):
            $Membros = $Read->getResult();
        endif;
        echo json_encode($Membros);
    }

    public function getMembrosPorDirigente($IdLider) {
        $Membro = new Membro();
        $Membros = $Membro->getMembrosPorDirigente($IdLider);
        if (!$Membros):
            $Membros = array();
        endif;
        echo json_encode($Membros);
    }

    public function getEncargoSel($EncargoSel) {
        echo $_SESSION['encargo_sel'] = $EncargoSel;
    }

}
