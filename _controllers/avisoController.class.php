<?php

class avisoController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'aviso',
            'GetExeLb' => 'Avisos',
            'GetExeLbs' => 'Avisos',
        );

        $login = new Login();
        if ($login->hasPermission('avisos')) {
            $this->loadTamplate('aviso/index', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function create() {
        $data = array(
            'GetExe' => 'aviso',
            'GetExeLb' => 'Aviso',
            'GetExeLbs' => 'Avisos',
            'AvisoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('avisos') && $login->hasPermission('avisos_novo')) {

            $data['AvisoData'] = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            extract($data);

            if ($AvisoData && $AvisoData['SendPostForm']):
                unset($AvisoData['SendPostForm']);

                $Aviso = new Aviso();
                $Aviso->ExeCreate($AvisoData);
                if ($Aviso->getResult()):
                    WSErro($Aviso->getError()[0], $Aviso->getError()[1]);
                    header("Location: " . BASE . "/aviso");
                else:
                    WSErro($Aviso->getError()[0], $Aviso->getError()[1]);
                endif;
            endif;

            $this->loadTamplate('aviso/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function update($AvisoId) {
        $data = array(
            'GetExe' => 'aviso',
            'GetExeLb' => 'Aviso',
            'GetExeLbs' => 'Avisos',
            'AvisoData' => array()
        );

        $login = new Login();
        if ($login->hasPermission('avisos') && $login->hasPermission('avisos_editar')) {

            $AvisoData = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if ($AvisoData && $AvisoData['SendPostForm']):
                unset($AvisoData['SendPostForm']);

                $Aviso = new Aviso();
                $Aviso->ExeUpdate($AvisoId, $AvisoData);
                if ($Aviso->getResult()):
                    WSErro($Aviso->getError()[0], $Aviso->getError()[1]);
                    header("Location: " . BASE . "/aviso");
                else:
                    WSErro($Aviso->getError()[0], $Aviso->getError()[1]);
                endif;
            endif;

            $Read = new Read;
            $Read->ExeRead(AVISO, "WHERE id = :id", "id={$AvisoId}");
            if ($Read->getResult()):
                $data['AvisoData'] = $Read->getResult()[0];
            endif;

            $this->loadTamplate('aviso/data', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    public function delete($AvisoId) {
        $data = array(
            'GetExe' => 'aviso',
            'GetExeLb' => 'Aviso',
            'GetExeLbs' => 'Avisos',
        );

        $login = new Login();
        if ($AvisoId && $login->hasPermission('avisos') && $login->hasPermission('avisos_deletar')):
            $Aviso = new Aviso();
            $Aviso->ExeDelete($AvisoId);
            WSErro($Aviso->getError()[0], $Aviso->getError()[1]);
            header("Location: " . BASE . "/aviso");
        else:
            $this->loadTamplate('nopermission', $data);
        endif;
    }

    public function sendemail($AvisoId) {
        $data = array(
            'GetExe' => 'aviso',
            'GetExeLb' => 'Aviso',
            'GetExeLbs' => 'Avisos',
        );

        $Aviso = array();
        $Membro = array();

        $Read = new Read();
        $Read->ExeRead(AVISO, "WHERE id = :id", "id={$AvisoId}");
        if ($Read->getResult()):
            $Aviso = $Read->getResult()[0];
        endif;

        $Read->ExeRead(MEMBRO, "WHERE id = :id", "id=" . MEMBRO_ID);
        if ($Read->getResult()):
            $Membro = $Read->getResult()[0];
        endif;
        
        if (!empty($Aviso) && !empty($Membro) && !empty($Membro['email'])) {
            $Body = '<table width="550" style="font-family: "Trebuchet MS", sans-serif;">
                        <tr><td>
                            <font face="Trebuchet MS" size="3">
                                ' . $Aviso['mensagem'] . '
                            </font>
                            <p style="font-size: 0.875em;">
                                Atenciosamente, <br><br>
                                ' . $Membro['nome'] . '
                            </p>
                        </td></tr>
                    </table>
                    <style>body, img{max-width: 550px !important; height: auto !important;} p{margin-botton: 15px 0 !important;}</style>';
            
            $CharSet = EMAIL_CHARSET;
            $Host = EMAIL_HOST;                  // Specify main and backup SMTP servers
            $SMTPAuth = EMAIL_SMTP_AUTH;         // Enable SMTP authentication
            $Username = EMAIL_USERNAME;          // SMTP username
            $Password = EMAIL_PASSWORD;          // SMTP password
            $SMTPSecure = EMAIL_SMTP_SECURE;     // Enable TLS encryption, `ssl` also accepted
            $Port = EMAIL_PORT;                  // TCP port to connect to
            $From = EMAIL_FROM;
            $FromName = EMAIL_FROM_NAME;
            $Subject = "EstouPresente Avisa!: " . $Aviso['titulo'];

            if ($Aviso['publico'] == 'S') {
                $Read->ExeRead(MEMBRO);
                if ($Read->getResult()) {
                    foreach ($Read->getResult() as $destino) {
                        if (!empty($destino['email']) || !empty($destino['email_copia']) && (($Membro['email'] != $destino['email']) && ($Membro['email'] != $destino['email_copia']))) {
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
                            if (($Membro['email'] != $destino['email']) && ($Membro['email'] != $destino['email_copia'])) {
                                $mail->addAddress($destino['email'], $destino['nome']); // Add a recipient
                                $mail->addAddress($destino['email_copia'], $destino['nome']); // Add a recipient   
                            } if ($Membro['email'] != $destino['email']) {
                                $mail->addAddress($destino['email'], $destino['nome']); // Add a recipient
                            } else if ($Membro['email'] != $destino['email_copia']) {
                                $mail->addAddress($destino['email_copia'], $destino['nome']); // Add a recipient
                            }
                            $mail->isHTML(true);                                  // Set email format to HTML
                            $mail->Subject = $Subject;
                            $mail->Body = $Body;

                            if (!$mail->send()) {
                                WSErro("Opsss... E-mail não enviada: " . $mail->ErrorInfo, WS_ERROR);
                            } else {
                                WSErro("E-mail enviado com sucesso!", WS_ACCEPT);
                            }
                        }
                    }
                }
            } else if (!empty($Aviso['id_membro'])) {

                $Read->ExeRead(MEMBRO, "WHERE id = :id", "id={$Aviso['id_membro']}");
                if ($Read->getResult()):
                    $destino = $Read->getResult()[0];
                endif;

                if (!empty($destino) && (($Membro['email'] != $destino['email']) || ($Membro['email'] != $destino['email_copia']))) {
                    if (!empty($destino['email']) || !empty($destino['email_copia'])) {
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
                        
                        if (($Membro['email'] != $destino['email']) && ($Membro['email'] != $destino['email_copia'])) {
                            $mail->addAddress($destino['email'], $destino['nome']); // Add a recipient
                            $mail->addAddress($destino['email_copia'], $destino['nome']); // Add a recipient   
                        } if ($Membro['email'] != $destino['email']) {
                            $mail->addAddress($destino['email'], $destino['nome']); // Add a recipient
                        } else if ($Membro['email'] != $destino['email_copia']) {
                            $mail->addAddress($destino['email_copia'], $destino['nome']); // Add a recipient
                        }
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = $Subject;
                        $mail->Body = $Body;
                        
                        if (!$mail->send()) {
                            WSErro("Opsss... E-mail não enviada: " . $mail->ErrorInfo, WS_ERROR);
                        } else {
                            WSErro("E-mail enviado com sucesso!", WS_ACCEPT);
                        }
                    }
                }
            } else {
                WSErro("Ops.... Nenhum e-mail enviado!", WS_ALERT);
            }
        }

        header("Location: " . BASE . "/aviso");
    }

}
