<?php

class Login {

    private $Level;
    private $Login;
    private $Senha;
    private $Forgout;
    private $Error;
    private $Result;

    /*
     * ***************************************
     * **********  PUBLIC METHODS  **********
     * ***************************************
     */

    public function ExeLogin(array $UserData) {
        $this->Login = (string) strip_tags(trim($UserData['usuario']));
        $this->Senha = (string) strip_tags(trim($UserData['password']));
        $this->setLogin();
    }

    public function ExeForgout($Login, array $UserData) {
        $this->Login = $Login;
        $this->Senha = (string) strip_tags(trim($UserData['oldPassword']));
        
        $this->Forgout = array();
        $this->Forgout["OldPassword"] = $this->Senha;
        $this->Forgout["Password"] = (string) strip_tags(trim($UserData['password']));
        $this->Forgout["Repassword"] = (string) strip_tags(trim($UserData['repassword']));
        
        $this->setForgout();
    }

    public function ExeLogout() {
        unset($_SESSION['userlogin'], $_SESSION['menu_permission']);
        header("Location: " . BASE . "/login");
    }

    public function getResult() {
        return $this->Result;
    }

    public function getError() {
        return $this->Error;
    }

    public function CheckLogin() {
        if (empty($_SESSION['userlogin'])):
            unset($_SESSION['userlogin']);
            return false;
        else:
            if ((bool) $_SESSION['userlogin']['altera_senha']):
                return false;
            else:
                return true;
            endif;
        endif;
    }

    public function hasPermission($name) {
        if (ADMIN || in_array($name, $_SESSION['Permissions'])) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    //Valida os dados e armazena os erros caso existam. Executa o login!
    private function setLogin() {
        if (!$this->Login || !$this->Senha):
            $this->Error = ['Informe seu Usuário e senha para efetuar o login!', WS_INFOR];
            $this->Result = false;
        elseif (!$this->getUser()):
            $this->Error = ['Os dados informados não são compatíveis!', WS_ALERT];
            $this->Result = false;
        else:
            $this->Execute();
        endif;
    }

    private function setForgout() {
        $this->Senha = $this->Forgout['OldPassword'];
        if (in_array('', $this->Forgout)):
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
            $this->Result = false;
        elseif (!$this->getUser()):
            $this->Error = ['A senha atual não confere!', WS_ALERT];
            $this->Result = false;
        elseif (isset($this->Forgout['Password']) && (strlen($this->Forgout['Password']) < 6 || strlen($this->Forgout['Password']) > 12)):
            $this->Error = ["A senha deve ter entre 6 e 12 caracteres!", WS_ALERT];
            $this->Result = false;
        elseif (isset($this->Forgout['Password']) && $this->Forgout['Password'] !== $this->Forgout['Repassword']):
            $this->Error = ["Senha não podem ser diferentes!", WS_ALERT];
            $this->Result = false;
        else:
            $this->setPassword();
        endif;
    }

    private function getUser() {
        $this->Senha = md5($this->Senha);
        $read = new Read;
        $read->FullRead("SELECT u.*, m.encargo
                         FROM users u 
                            LEFT JOIN membros m on m.id = u.chave 
                         WHERE login = :e AND password = :p", "e={$this->Login}&p={$this->Senha}");

        if ($read->getResult()):
            $this->Result = $read->getResult()[0];
            return true;
        else:
            return false;
        endif;
    }

    private function setPassword() {
        $this->Senha = $this->Forgout['Password'];
        $Update = new Update;
        $UpdateData = [
            'password' => md5($this->Senha),
            'altera_senha' => 0
        ];
        $Update->ExeUpdate(USUARIO, $UpdateData, "WHERE login = :login", "login={$this->Login}");
        if (!$Update->getResult()):
            $this->Error = ['Não foi possível gravar a nova senha!', WS_ALERT];
            $this->Result = false;
        else:
            $this->setLogin();
        endif;
    }

    private function Execute() {
        if (!session_id()):
            session_start();
        endif;

        $_SESSION['userlogin'] = $this->Result;

        unset($_SESSION['menu_permission']);

        $this->getPermissionsByGroupId($this->Result['id_group']);
        $_SESSION['menu_permission']['has_configuracoes'] = $this->hasPermission('configuracoes');
        $_SESSION['menu_permission']['has_home'] = $this->hasPermission('home');
        $_SESSION['menu_permission']['has_usuarios'] = $this->hasPermission('usuarios');
        $_SESSION['menu_permission']['has_permissoes'] = $this->hasPermission('permissoes');
        $_SESSION['menu_permission']['has_pessoas'] = $this->hasPermission('pessoas');
        $_SESSION['menu_permission']['has_membros'] = $this->hasPermission('membros');
        $_SESSION['menu_permission']['has_auxiliares'] = $this->hasPermission('auxiliares');
        $_SESSION['menu_permission']['has_supervisores'] = $this->hasPermission('supervisores');
        $_SESSION['menu_permission']['has_areas'] = $this->hasPermission('areas');
        $_SESSION['menu_permission']['has_pastores'] = $this->hasPermission('pastores');
        $_SESSION['menu_permission']['has_lideres'] = $this->hasPermission('lideres');
        $_SESSION['menu_permission']['has_celulas'] = $this->hasPermission('celulas');
        $_SESSION['menu_permission']['has_presencas'] = $this->hasPermission('presencas');
        $_SESSION['menu_permission']['has_anexos'] = $this->hasPermission('anexos');
        $_SESSION['menu_permission']['has_dashboard'] = $this->hasPermission('dashboard');
        $_SESSION['menu_permission']['has_avisos'] = $this->hasPermission('avisos');
        $_SESSION['menu_permission']['has_discipulados'] = $this->hasPermission('discipulados');
        $_SESSION['menu_permission']['has_fichas'] = $this->hasPermission('fichas');
        $_SESSION['menu_permission']['has_fichasVVitoriosa'] = $this->hasPermission('fichasVVitoriosa');
        $_SESSION['menu_permission']['has_fichasFColheita'] = $this->hasPermission('fichasFColheita');
        $_SESSION['menu_permission']['has_celulasVisitadas'] = $this->hasPermission('celulasVisitadas');
        $_SESSION['encargo_sel'] = $this->Result['encargo'];

        $this->Error = ["Olá {$this->Result['name']}, seja bem vindo(a). Aguarde redirecionamento!", WS_ACCEPT];
        $this->Result = true;
    }

    private function getPermissionsByGroupId($groupId) {
        $permissions = array();

        if (empty($groupId)):
            $groupId = 0;
        endif;

        $read = new Read;
        $read->ExeRead('permission_groups', "WHERE id = :id", "id={$groupId}");

        if ($read->getResult()):
            $params = $read->getResult()[0]['params'];
            if (empty($params)):
                $params = '0';
            endif;

            $read->FullRead("SELECT name FROM permission_params WHERE id IN ($params)");
            if ($read->getResult()):
                foreach ($read->getResult() as $item):
                    $permissions[] = $item['name'];
                endforeach;
            endif;
        endif;

        $_SESSION['Permissions'] = $permissions;
    }

}
