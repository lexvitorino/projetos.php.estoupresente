<?php

define('BASE', 'http://localhost/estoupresente');

// CONFIGRAÇÕES DO SITE ####################
define('HOST', 'localhost');
define('USER', 'db_estoupresente');
define('PASS', 'root');
define('DBSA', '');

// CONFIGRAÇÕES DO EMAIL ####################
define('EMAIL_CHARSET', 'UTF-8');
define('EMAIL_HOST', 'contato.mi7dev.com.br');
define('EMAIL_SMTP_AUTH', true);
define('EMAIL_USERNAME', 'contato@mi7dev.com.br');
define('EMAIL_PASSWORD', '');
define('EMAIL_SMTP_SECURE', 'ssl');
define('EMAIL_PORT', 465);
define('EMAIL_FROM', 'contato@mi7dev.com.br');
define('EMAIL_FROM_NAME', 'Contato');

// CONFIGRAÇÕES DO SITE ####################
define('SITE_TITLE', 'Acamp 2020');
define('SITE_FOOTER_COPYRIGTH', 'A&J Soluções Informática &copy; 2013-' . date('Y'));

// TRATAMENTO DE ERROS #####################
//CSS constantes :: Mensagens de Erro
define('WS_ACCEPT', 'success');
define('WS_INFOR', 'info');
define('WS_ALERT', 'warning');
define('WS_ERROR', 'error');


//TABELAS DO SISTEMA
define('USUARIO', 'users');
define('AVISO', 'avisos');
define('PERMISSION_GRUPO', 'permission_groups');
define('ANEXO', 'anexos');
define('CELULA', 'celulas');
define('CELULA_VISITADA', 'celulas_visitadas');
define('COMUNA', 'comunas');
define('DISCIPULADO', 'discipulados');
define('FICHA_FCOLHEITA', 'fichas_fcolheita');
define('FICHA_FCOLHEITA_ITEM', 'fichas_fcolheita_item');
define('FICHA_VVITORIOSA', 'fichas_vvitoriosa');
define('PERMISSION_PARAM', 'permission_params');
define('PRESENCA', 'presencas');
define('PRESENCA_ITEM', 'presenca_itens');
define('MEMBRO', 'membros');
define('INSCRICAO', 'inscricao');

//LISTA DE ENCARGOS
define('ENCARGO_MEMBRO', 'Pastor');
define('ENCARGO_DISTRITO', 'Distrito');
define('ENCARGO_AREA', 'Area');
define('ENCARGO_SUPERVISOR', 'Supervisor');
define('ENCARGO_LIDER', 'Lider');
define('ENCARGO_AUXILIAR', 'Auxiliar');
define('ENCARGO_MEMBROS', 'membros');

//DEFINICAO DE VARIAVEIS UTEIS GLOBAIS
define('REGISTROS_PAGINA', 6);
define('SUBSCRIBER_ID', empty($_SESSION['userlogin']['id_subscriber']) ? 0 : $_SESSION['userlogin']['id_subscriber']);
define('MEMBRO_ID', empty($_SESSION['userlogin']['chave']) ? 0 : $_SESSION['userlogin']['chave']);
define('USUARIO_ID', empty($_SESSION['userlogin']['id']) ? 0 : $_SESSION['userlogin']['id']);
define('ADMIN', empty($_SESSION['userlogin']['is_admin']) ? 0 : $_SESSION['userlogin']['is_admin']);
define('ENCARGO', empty($_SESSION['userlogin']['encargo']) ? 0 : $_SESSION['userlogin']['encargo']);
define('ENCARGO_SEL', empty($_SESSION['encargo_sel']) ? 0 : $_SESSION['encargo_sel']);

//WSErro :: Exibe erros lançados :: Front
function WSErro($ErrMsg, $ErrNo) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    switch ($ErrNo):
        case WS_ALERT:
            $ErrTit = 'Ops.. Precisamos da sua atenção';
            break;
        case WS_INFOR:
            $ErrTit = 'Fica dica!';
            break;
        case WS_ALERT:
            $ErrTit = 'Ops.. Algo aconteceu de muito errado!';
            break;
        default:
            $ErrTit = 'Tudo certinho!';
            break;
    endswitch;
    $_SESSION['alert'] = array();
    $_SESSION['alert']['tipToastr'] = $CssClass;
    $_SESSION['alert']['titToastr'] = $ErrTit;
    $_SESSION['alert']['msgToastr'] = $ErrMsg;
}

//PHPErro :: personaliza o gatilho do PHP
function PHPErro($ErrNo, $ErrMsg, $ErrFile, $ErrLine) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? WS_INFOR : ($ErrNo == E_USER_WARNING ? WS_ALERT : ($ErrNo == E_USER_ERROR ? WS_ERROR : $ErrNo)));
    echo "<p class=\"trigger {$CssClass}\">";
    echo "<b>Erro na Linha: #{$ErrLine} ::</b> {$ErrMsg}<br>";
    echo "<small>{$ErrFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($ErrNo == E_USER_ERROR):
        die;
    endif;
}

// Mensagens lançadas em panel no form
function Erro($ErrMsg, $ErrNo = null) {
    $CssClass = ($ErrNo == E_USER_NOTICE ? 'trigger_info' : ($ErrNo == E_USER_WARNING ? 'trigger_alert' : ($ErrNo == E_USER_ERROR ? 'trigger_error' : 'trigger_success')));
    echo "<div class='trigger {$CssClass}'>{$ErrMsg}<span class='ajax_close'></span></div>";
}

/*
 * TABELAS AUXILIARES
 */

// TIPOS DE ENCARGOS
function getEncargos($encargo = null) {
    $encargos = ['Membro','Auxiliar','Lider','Supervisor','Area','Pastor','Distrito'];

    if (!empty($encargo)):
        return in_array($encargo, $encargos);
    else:
        return $encargos;
    endif;
}

// TIPOS DE STATUS DE VISITAS
function getVisitaStatus($Status = null) {
    $VisitaStatus = [
        1 => 'Não houve',
        2 => 'Insatisfatório',
        3 => 'Bom',
        4 => 'Ótimo'
    ];

    if (!empty($Status)):
        return $VisitaStatus[$Status];
    else:
        return $VisitaStatus;
    endif;
}

// TIPOS DE VIDA VITORIOSA
function getTipoVVitoriosa($Tipo = null) {
    $TipoVVitoriosa = [
        'B' => 'Batismo',
        'N' => 'Novo Membro',
        'P' => 'Apenas Participante'
    ];

    if (!empty($Tipo)):
        return $TipoVVitoriosa[$Tipo];
    else:
        return $TipoVVitoriosa;
    endif;
}

// ESTADO CIVEL
function getEstadoCivil($Tipo = null) {
    $EstadoCivil = [
        'S' => 'Solteiro(a)',
        'C' => 'Casado(a)',
        'V' => 'Viúvo(a)',
        'D' => 'Divorciado(a)',
        'O' => 'Outro'
    ];

    if (!empty($Tipo)):
        return $EstadoCivil[$Tipo];
    else:
        return $EstadoCivil;
    endif;
}

// MEIO DE TRANSPORTE
function getTipoTransporte($Tipo = null) {
    $TipoTransporte = [
        'Ônibus' => 'Ônibus',
        'Carro' => 'Carro',
    ];

    if (!empty($Tipo)):
        return $TipoTransporte[$Tipo];
    else:
        return $TipoTransporte;
    endif;
}

// MEIO DE ACOMODAÇÃO
function getTipoAcomodacao($Tipo = null) {
    $TipoAcomodacao = [
        'Quarto' => 'Quarto',
        'Tenda' => 'Tenda',
        'Barraca' => 'Barraca',
    ];

    if (!empty($Tipo)):
        return $TipoAcomodacao[$Tipo];
    else:
        return $TipoAcomodacao;
    endif;
}

// MEIO DE ACOMODAÇÃO
function getFormaPagamento($Tipo = null) {
    $FormaPagamento = [
        'Depósito' => 'Depósito',
        'Cartão' => 'Cartão'
    ];

    if (!empty($Tipo)):
        return $FormaPagamento[$Tipo];
    else:
        return $FormaPagamento;
    endif;
}

// CONDICAO PARA TODA LIDERANCA
define('LIDERES', "AND ( " . (ADMIN?"1=1":"1=0") . " OR
                         m.id = :idMembro OR
                         m.id_lider = :idMembro OR
                         m.id_lider in (select id from " . MEMBRO . " where id_lider = :idMembro) OR 
                         m.id_lider in (select id from " . MEMBRO . " where id_lider in (select id from " . MEMBRO . " where id_lider = :idMembro)) OR
                         m.id_lider in (select id from " . MEMBRO . " where id_lider in (select id from " . MEMBRO . " where id_lider in (select id from " . MEMBRO . " where id_lider = :idMembro))) )");

set_error_handler('PHPErro');
