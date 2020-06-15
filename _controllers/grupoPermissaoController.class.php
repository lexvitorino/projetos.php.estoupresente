<?php

class grupoPermissaoController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'grupoPermissao',
            'GetExeLb' => 'Grupos de Permissões',
            'GetExeLbs' => 'Grupos de Permissões',
        );

        $login = new Login();
        if ($login->hasPermission('permissoes')) {
            $this->loadTamplate('grupoPermissao/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'grupoPermissao',
            'GetExeLb' => 'Grupo de Permissões',
            'GetExeLbs' => 'Grupos de Permissões',
            'GrupoPermissaoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('permissoes') && $login->hasPermission('permissoes_novo')) {

            $data['GrupoPermissaoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);
            
            if ($GrupoPermissaoData && $GrupoPermissaoData['SendPostForm']):
                unset($GrupoPermissaoData['SendPostForm']);
            
                $grupoPermissao = new GrupoPermissao();
                $grupoPermissao->ExeCreate($GrupoPermissaoData);
                if ($grupoPermissao->getResult()):
                    WSErro($grupoPermissao->getError()[0], $grupoPermissao->getError()[1]);
                    header("Location: " . BASE . "/grupoPermissao");
                else:
                    WSErro($grupoPermissao->getError()[0], $grupoPermissao->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('grupoPermissao/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($GrupoPermissaoId) {
        $data = array(
            'GetExe' => 'grupoPermissao',
            'GetExeLb' => 'Grupo de Permissões',
            'GetExeLbs' => 'Grupos de Permissões',
            'GrupoPermissaoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('permissoes') && $login->hasPermission('permissoes_editar')) {

            $GrupoPermissaoData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($GrupoPermissaoData && $GrupoPermissaoData['SendPostForm']):
                unset($GrupoPermissaoData['SendPostForm']);
            
                $grupoPermissao = new GrupoPermissao();
                $grupoPermissao->ExeUpdate($GrupoPermissaoId, $GrupoPermissaoData);
                if ($grupoPermissao->getResult()):
                    WSErro($grupoPermissao->getError()[0], $grupoPermissao->getError()[1]);
                    header("Location: " . BASE . "/grupoPermissao");
                else:
                    WSErro($grupoPermissao->getError()[0], $grupoPermissao->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(PERMISSION_GRUPO, "WHERE id = :id", "id={$GrupoPermissaoId}");
            if ($Read->getResult()):
                $data['GrupoPermissaoData'] = $Read->getResult()[0];
            endif;
            
            $this->loadTamplate('grupoPermissao/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($GrupoPermissaoId) {
        $data = array(
            'GetExe' => 'grupoPermissao',
            'GetExeLb' => 'Permissão',
            'GetExeLbs' => 'Permissões',
        );

        $login = new Login();
        if ($GrupoPermissaoId && $login->hasPermission('permissoes') && $login->hasPermission('permissoes_deletar')):
            $grupoPermissao = new GrupoPermissao();
            $grupoPermissao->ExeDelete($GrupoPermissaoId);
            WSErro($grupoPermissao->getError()[0], $grupoPermissao->getError()[1]);
            header("Location: " . BASE . "/grupoPermissao");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

    public function getPermissionByIds($Params) {
        $Permissoes = array();
        $Params = implode(',', array_map('intval', explode(',', $Params)));
        $Read = new Read();
        $Read->ExeRead(PERMISSION_PARAM, "WHERE id in ({$Params}) ORDER BY name ASC");
        if ($Read->getResult()):
            $Permissoes = $Read->getResult();
        endif;
        echo json_encode($Permissoes);
    }

}
