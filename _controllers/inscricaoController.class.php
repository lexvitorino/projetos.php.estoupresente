<?php

class inscricaoController extends ViewControl
{

    public function __construct()
    {
    }


    public function index() {
        $data = array(
            'InscricaoData' => array(),
            'Message' => array()
        );

        $_SESSION['email'] = '';

        $data['InscricaoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        extract($data);

        if ($InscricaoData && !empty($InscricaoData['SendPostValid'])):
            unset($InscricaoData['SendPostValid']);
            $_SESSION['email'] = $InscricaoData['email'];
            

            $Read = new Read;
            $Read->ExeRead(INSCRICAO, "WHERE id_evento = 2 and email = :email", "email={$InscricaoData['email']}");
            if ($Read->getResult()) {
                $data['InscricaoData'] = $Read->getResult()[0];
                $data['Message'] = ['Já existe uma inscrição para o e-mail informado!', 'info'];
                header("Location: " . BASE . "/inscricao/update/" . $Read->getResult()[0]['id']);
            } else {
                header("Location: " . BASE . "/inscricao/create");
            }
        endif;

        $this->loadCleanTamplate('/inscricao/valida', $data);
    }

    public function create() {    
        $data = array(
            'InscricaoData' => array(),
            'Message' => array()
        );

        $inscricao = new Inscricao();
        $data['Areas'] = array_unique($inscricao->getAreas());

        $data['InscricaoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        extract($data);

        if ($InscricaoData && !empty($InscricaoData['SendPostForm'])):
            unset($InscricaoData['SendPostForm']);

            $Read = new Read;
            $Read->ExeRead(INSCRICAO, "WHERE id_evento = 2 and email = :email", "email={$InscricaoData['email']}");
            if ($Read->getResult()) {
                $data['InscricaoData'] = $Read->getResult()[0];
                $data['Message'] = ['Já existe uma inscrição para o e-mail informado!', 'info'];
                header("Location: " . BASE . "/inscricao/update/" . $Read->getResult()[0]['id']);
                return;
            }
            
            $InscricaoData["id_evento"] = 2;
            $InscricaoData["disable"] = 1;

            $inscricao = new Inscricao();
            $inscricao->ExeCreate($InscricaoData);
            
            if ($inscricao->getResult()):
                $Read->ExeRead(INSCRICAO, "WHERE id_evento = 2 and email = :email", "email={$InscricaoData['email']}");
                if ($Read->getResult()):
                    $inscricao->sendemail($Read->getResult()[0]['id']);
                    header("Location: " . BASE . "/inscricao/confirmacao/" . $Read->getResult()[0]['id']);
                endif;
            else:
                $data['Message'] = $inscricao->getError();
            endif;
        endif;

        if (!empty($_SESSION['email'])) {
            
            $ReadOld = new Read;
            $ReadOld->ExeRead(INSCRICAO, "WHERE email = :email ORDER BY id DESC LIMIT 1", "email={$_SESSION['email']}");
            
            if ($ReadOld->getResult()) {
                $data['InscricaoData'] = $ReadOld->getResult()[0];
                $data['InscricaoData']['id'] = null;
                $data['InscricaoData']['id_area'] = null;
	        $data['InscricaoData']['id_supervisor'] = null;
            	$data['InscricaoData']['id_lider'] = null;
            	$data['InscricaoData']['tipo_acomodacao'] = null;
            	$data['InscricaoData']['tipo_transporte'] = null;
            }
            
            $data['InscricaoData']["id_evento"] = 2;
            $data['InscricaoData']["disable"] = 0;
            $data['InscricaoData']['email'] = $_SESSION['email'];
        }
        
        
        $this->loadCleanTamplate('/inscricao/data', $data);
    }

    public function update($id) {
        $data = array(
            'InscricaoData' => array(),
            'Message' => array(),
            'Areas' => array()
        );

        $inscricao = new Inscricao();
        $data['Areas'] = array_unique($inscricao->getAreas());

        $data['InscricaoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        extract($data);

        if ($InscricaoData && !empty($InscricaoData['SendPostForm'])):
            unset($InscricaoData['SendPostForm']);

	    $InscricaoData['disable'] = 1;	

            $inscricao = new Inscricao();
            $inscricao->ExeUpdate($id, $InscricaoData);

            if ($inscricao->getResult()):
                $inscricao->sendemail($id);
                header("Location: " . BASE . "/inscricao/confirmacao/" . $id);
            else:
                $data['Message'] = $inscricao->getError();
            endif;
        endif;

        $Read = new Read;
        $Read->ExeRead(INSCRICAO, "WHERE id = :id", "id={$id}");
        if ($Read->getResult()):
            $data['InscricaoData'] = $Read->getResult()[0];
        endif;

        $this->loadCleanTamplate('/inscricao/data', $data);
    }

    public function membros() {
        $inscricao = new Inscricao();
        echo json_encode($inscricao->getMembros());
    }

    public function confirmacao($id) {
        $data = array(
            'InscricaoData' => array()
        );

        $Read = new Read();
        $Read->ExeRead(INSCRICAO, "WHERE id = :id", "id={$id}");
        if ($Read->getResult()):
            $data['InscricaoData'] = $Read->getResult()[0];
        endif;

        $this->loadCleanTamplate('/inscricao/confirmacao', $data);
    }

}
