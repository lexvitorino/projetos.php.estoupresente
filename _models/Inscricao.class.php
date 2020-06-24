<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Inscricao {

    private $Data;
    private $Inscricao;
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
        $this->Inscricao = (int) $Id;
        $this->Data = $Data;

        $this->checkData();

        if ($this->Result):
            $this->Update();
        endif;
    }

    public function ExeDelete($Id) {
        $this->Inscricao = (int) $Id;

        $read = new Read;
        $read->ExeRead(INSCRICAO, "WHERE id = :id", "id={$this->Inscricao}");

        if (!$read->getResult()):
            $this->Error = ['Oppsss, você tentou remover uma inscricao que não existe no sistema!', WS_ERROR];
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

    public function getMembros() {
        $data = '[';
        $str = file_get_contents(BASE . '/assets/lista.json');
        $json = json_decode($str, true);
        
        foreach ($json as $key => $value) {
            $a = explode(' - ', $value['campo']);
            if ($data != "[") {
                $data .= ',';
            }
            $data .= '{"area":"'.$a[0].'","supervisor":"'.$a[1].'","dirigente":"'.$a[2].'"}';    
        }
        
        return json_decode($data . ']', true);
    }

    public function getAreas() {
        $areas = array();
        foreach ($this->getMembros() as $key => $value){
            $areas[] = $value['area'];
        }
        return $areas;
    }

    public function sendemail($id) {
        $data = array();

        $Read = new Read();
        $Read->ExeRead(INSCRICAO, "WHERE id = :id", "id={$id}");
        if ($Read->getResult()):
            $Inscricao = $Read->getResult()[0];
        endif;

        if (!empty($Inscricao)) {
            extract($Inscricao);

            $onibus = ($tipo_transporte == 'Ônibus') ? '55,00' : '0,00';
            
            if (!$tipo_acomodacao) { 
		$tipo_acomodacao = "Quarto";
	    }
		
	    $vlAcomodacao = 0;
	    if ($tipo_acomodacao === 'Tenda') {
		$vlAcomodacao = 360;
	    } else if ($tipo_acomodacao === 'Barraca') {
		$vlAcomodacao = 305;
	    } else {
		$vlAcomodacao = 360;
	    }
		
	    $vlOnibus = 0;
            if ($tipo_transporte === 'Ônibus') {
		$vlOnibus = 55;
	    }          
	    
            $total = ($vlAcomodacao + $vlOnibus) . ".00";

            $Body = "<html>
                          <body>
                                <div style='text-align: left;'>
                                    <table border='0' cellpadding='1' cellspacing='1' style='width: 600px;'>
                                        <tbody> 
                                            <tr>
                                                <td> <span style='font-size:22px;'>Ficha de Inscri&ccedil;&atilde;o N&ordm;  " . $id . "&nbsp;</span></td>
                                            </tr>
                                            <tr>
                                                <td><span style='font-size:20px;'>Evento.: Acamp Jovens Solteiros 2020</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <table border='0' cellpadding='1' cellspacing='1' style='width: 600px;'>
                                        <tbody>
                                            <tr>
                                                <td>E-mail.:  " . $email . "</td>
                                                <td>RG.:  " . $rg . "</td>
                                            </tr>
                                            <tr>
                                                <td>Nome.:  " . $nome . "</td>
                                                <td>Sobrenome.:  " . $sobrenome . "</td>
                                            </tr>
                                            <tr>
                                                <td>Data de Nascimento.:  " . date("d/m/Y", strtotime($data_nascimento)) . "</td>
                                                <td>Sexo.:  " . $sexo . "</td>
                                            </tr>
                                            <tr>
                                                <td>Dirigente.:  " . $dirigente . "</td>
                                                <td>Supervidor.:  " . $id_supervisor . "</td>
                                                <td>&Aacute;rea.:  " . $id_area . "</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <br />
                                    <table border='0' cellpadding='1' cellspacing='1' style='width: 600px;'>
                                        <tbody>
                                            <tr>
                                                <td>Tipo de Transporte.:  " . $tipo_transporte . "</td>
                                            </tr>
                                            <tr>
                                                <td>Forma de Pagamento.:  " . $forma_pagamento . "</td>
                                            </tr>
                                        </tbody> 
                                    </table>
                                    <br />
                                    <table border='0' cellpadding='1' cellspacing='1' style='width: 600px;'>
                                        <tbody>
                                            <tr>
                                                <td><span style='color:#ff0000;'>Quarto.:  R$ ". ($tipo_acomodacao === "Quarto" ? $vlAcomodacao : 0) . ",00</span></td>
                                            </tr>   
                                            <tr>
                                                <td><span style='color:#ff0000;'>Tenda.:  R$ ". ($tipo_acomodacao === "Tenda" ? $vlAcomodacao : 0) . ",00</span></td>
                                            </tr>     
                                            <tr>
                                                <td><span style='color:#ff0000;'>Barraca.:</u>  R$ ". ($tipo_acomodacao === "Barraca" ? $vlAcomodacao : 0) . ",00</span></td>
                                            </tr>     
                                            <tr>
                                                <td><span style='color:#ff0000;'>&Ocirc;nibus.:  ". $onibus ."</span></td>
                                            </tr>                       
                                            <tr>
                                                <td><span style='color:#ff0000; border-top: 1px solid red'>Valor Total.:   ". $total ."</span></td> 
                                            </tr> 
                                        </tbody> 
                                    </table>
                                    <br />
                                    <table border='0' cellpadding='1' cellspacing='1' style='width: 600px;'>
                                        <tbody>
                                            <tr>
                                                <td><span style='color:#ff0000;'>SUA INSCRIÇÃO NÃO ESTA EFETIVADA!!!</span></td>
                                            </tr>                       
                                            <tr>
                                                <td><span style='color:#ff0000;'>Você precisa efetivar o pagamento no balcão de inscrição da igreja!</span></td>
                                            </tr>                       
                                            <tr>
                                                <td><span style='color:#ff0000;'><strong>Caso isso não aconteça sua inscrição será cancelada automaticamente!!!</strong></span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </body>
                        </html>" ;
                        
            $CharSet = EMAIL_CHARSET;
            $Host = EMAIL_HOST;                  // Specify main and backup SMTP servers
            $SMTPAuth = EMAIL_SMTP_AUTH;         // Enable SMTP authentication
            $Username = EMAIL_USERNAME;          // SMTP username
            $Password = EMAIL_PASSWORD;          // SMTP password
            $SMTPSecure = EMAIL_SMTP_SECURE;     // Enable TLS encryption, `ssl` also accepted
            $Port = EMAIL_PORT;                  // TCP port to connect to
            $From = EMAIL_FROM;
            $FromName = EMAIL_FROM_NAME;
            $Subject = "Acamp Jovens Solteiros 2020: Inscrição Nº" . $Inscricao['id'];

            $mail = new PHPMailer;
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->CharSet = $CharSet;
            $mail->Host = $Host;              // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $Username;          // SMTP username
            $mail->Password = $Password;                          // SMTP password
            $mail->SMTPSecure = $SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $Port;                                     // TCP port to connect to
            $mail->setFrom($From, $FromName);
            $mail->addAddress($Inscricao['email'], $Inscricao['nome'] . " " . $Inscricao['sobrenome']); // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $Subject;
            $mail->Body = $Body;
            
            if (!$mail->send()) {
                $data['Message'] = [$mail->ErrorInfo, WS_ERROR];
            } else {
                $data['Message'] = ['E-mail enviado com sucesso!', 'WS_ACCEPT'];
            }
        }
    }

    public function checkData() {
        $this->Result = false;

        /* VALIDA IDADE MINIMA */
        $dataNascimento = strtotime($this->Data['data_nascimento']);
        $dataAtual = strtotime(date("Y-m-d"));
        $difAnos = floor(abs($dataNascimento - $dataAtual) / (365*60*60*24));
        if ($difAnos < 14) {
            $this->Error = ["Não é permitido menores de 14 anos", WS_ALERT];
        } else if (in_array('', $this->Data)) {
            $this->Error = ["Existem campos em branco. Favor preencha todos os campos!", WS_ALERT];
        } else {
            $this->Result = true;
        }
    }

    /*
     * ***************************************
     * **********  PRIVATE METHODS  **********
     * ***************************************
     */

    private function Create() {
        $Create = new Create;
        $Create->ExeCreate(INSCRICAO, $this->Data);
        if ($Create->getResult()):
            $this->Error = ["A inscrição foi cadastrado com sucesso no sistema!", WS_ACCEPT];
            $this->Result = $Create->getResult();
        endif;
    }

    private function Update() {
        $Update = new Update;
        $Update->ExeUpdate(INSCRICAO, $this->Data, "WHERE id = :id", "id={$this->Inscricao}");
        if ($Update->getResult()):
            $this->Error = ["A inscrição foi atualizado com sucesso!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

    private function Delete() {
        $Delete = new Delete;
        $Delete->ExeDelete(INSCRICAO, "WHERE id = :id", "id={$this->Inscricao}");
        if ($Delete->getResult()):
            $this->Error = ["A inscrição foi removido com sucesso do sistema!", WS_ACCEPT];
            $this->Result = true;
        endif;
    }

}
