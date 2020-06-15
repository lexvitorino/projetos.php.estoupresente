<?php

class usuarioController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'usuario',
            'GetExeLb' => 'Usuários',
            'GetExeLbs' => 'Usuários',
        );

        $login = new Login();
        if ($login->hasPermission('usuarios')) {
            $this->loadTamplate('usuario/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'usuario',
            'GetExeLb' => 'Usuário',
            'GetExeLbs' => 'Usuários',
            'UsuarioData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('usuarios') && $login->hasPermission('usuarios_novo')) {

            $data['UsuarioData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);

            if ($UsuarioData && $UsuarioData['SendPostForm']):
                unset($UsuarioData['SendPostForm']);

                $usuario = new Usuario();
                $usuario->ExeCreate($UsuarioData);
                if ($usuario->getResult()):
                    WSErro($usuario->getError()[0], $usuario->getError()[1]);
                    header("Location: " . BASE . "/usuario");
                else:
                    WSErro($usuario->getError()[0], $usuario->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('usuario/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($UsuarioId) {
        $data = array(
            'GetExe' => 'usuario',
            'GetExeLb' => 'Usuário',
            'GetExeLbs' => 'Usuários',
            'UsuarioData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('usuarios') && $login->hasPermission('usuarios_editar')) {

            $UsuarioData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($UsuarioData && $UsuarioData['SendPostForm']):
                unset($UsuarioData['SendPostForm']);

                $usuario = new Usuario();
                $usuario->ExeUpdate($UsuarioId, $UsuarioData);
                if ($usuario->getResult()):
                    WSErro($usuario->getError()[0], $usuario->getError()[1]);
                    header("Location: " . BASE . "/usuario");
                else:
                    WSErro($usuario->getError()[0], $usuario->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(USUARIO, "WHERE id = :id", "id={$UsuarioId}");
            if ($Read->getResult()):
                $data['UsuarioData'] = $Read->getResult()[0];
            endif;

            $this->loadTamplate('usuario/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($id) {
        $data = array(
            'GetExe' => 'usuario',
            'GetExeLb' => 'Usuário',
            'GetExeLbs' => 'Usuários',
        );

        $login = new Login();
        if ($id && $login->hasPermission('usuarios') && $login->hasPermission('usuarios_deletar')):
            $usuario = new Usuario();
            $usuario->ExeDelete($id);
            WSErro($usuario->getError()[0], $usuario->getError()[1]);
            header("Location: " . BASE . "/usuario");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

}
