<?php

class relatorioController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login"); 
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'relatorio',
            'GetExeLb' => 'Relatório',
            'GetExeLbs' => 'Relatório',
            'MesAno' => '',
            'Presenca' => array(),
            'Presencas' => array(),
            'Discipulados' => array(),
            'CelulasVisitadas' => array()
        );

        if (empty($Read)):
            $Read = new Read;
        endif;

        $Read->ExeRead(CELULA, "WHERE id_subscriber = :idSubscriber 
                                  AND ativo = 1
                                  AND :idMembroLogin in (id_auxiliar, id_dirigente, id_supervisor, id_area, id_pastor, id_distrito)", "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);
        if ($Read->getResult()):
            $celulas = $Read->getResult();
        endif;

        $RelatorioFiltro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if ($RelatorioFiltro && $RelatorioFiltro['SendPostFiltro']):
            $_SESSION['mes_ano'] = (string) $RelatorioFiltro['mes_ano'];
        endif;

        if (!empty($_SESSION['mes_ano'])):
            $mesAno = $_SESSION['mes_ano'];

            $Read->FullRead("SELECT d.*, DATE_FORMAT(d.data, '%m/%Y') as mes_ano
                               FROM " . DISCIPULADO . " d 
                                 INNER JOIN " . USUARIO . " u ON u.id = d.created_id_user
                             WHERE u.chave = :idMembroLogin 
                               AND DATE_FORMAT(d.data, '%m/%Y') = :mesAno
                             ORDER BY d.data DESC", "idMembroLogin=" . MEMBRO_ID . "&mesAno={$mesAno}");                 
                             
            if ($Read->getResult()):
                $data["Discipulados"] = $Read->getResult();
            endif;

            $Read->FullRead("SELECT u.*, c.nome as celula
                     FROM   " . CELULA_VISITADA . " u
                        INNER JOIN " . CELULA . " c on c.id = u.id_celula
                     WHERE u.id_subscriber = :idSubscriber
                       AND :idMembroLogin in (c.id_auxiliar, c.id_dirigente, c.id_supervisor, c.id_area, c.id_pastor, c.id_distrito)
                       AND DATE_FORMAT(u.data, '%m/%Y') = :mesAno
                     ORDER BY c.nome ASC", "mesAno={$mesAno}&idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);

            if ($Read->getResult()):
                $data["CelulasVisitadas"] = $Read->getResult();
            endif;
            
            foreach ($celulas as $celula):

                $Presenca = array();
                $Read->ExeRead(PRESENCA, "WHERE id_celula = :idCelula AND mes_ano = :mesAno", "idCelula={$celula['id']}&mesAno={$mesAno}");
                if ($Read->getResult()):
                    $Presenca = $Read->getResult()[0];
                endif;

                $presencaItem = $this->getMediaPresencasDoMes($celula['id'], $mesAno);

                $data['Presencas'][] = array(
                    'Itens' => array(
                        'celula' => $celula['nome'],
                        'Presenca' => $Presenca,
                        'TotalMembrosLigados' => (empty($Presenca['total_menor_11_anos_mes']) ? 0 : (int) $Presenca['total_menor_11_anos_mes']) +
                        empty($Presenca['total_maior_12_anos_mes']) ? 0 : (int) $Presenca['total_maior_12_anos_mes'],
                        'PresencaItem' => $presencaItem
                    )
                );
            endforeach;
        endif;

        $login = new Login();
        if ($login->hasPermission('relatorio')) {
            $this->loadTamplate('relatorio', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    private function getMediaPresencasDoMes($idCelula, $mesAno) {
        $qtEncontros = 0;
        $idPresenca = 0;
        $dados = array();

        $Read = new Read;
        $Read->FullRead("SELECT s.id_presenca as idPresenca,
                                COUNT(s.id) as QtEncontros
                         FROM   presenca_itens s
                           inner join presencas p on p.id = s.id_presenca
                         WHERE  s.total_geral > 0
                         AND    p.id_celula = :idCelula
                         AND    p.mes_ano = :mesAno
                         GROUP BY s.id_presenca", "idCelula={$idCelula}&mesAno={$mesAno}");

        if ($Read->getResult()):
            $data = $Read->getResult()[0];
            $idPresenca = (int) $data['idPresenca'];
            $qtEncontros = (int) $data['QtEncontros'];

            $Read->FullRead("SELECT SUM(ate_11) / {$qtEncontros} as MediaAte11, 
                                    SUM(adol_12_14_anos) / {$qtEncontros}  as MediaAdol1214Anos, 
                                    SUM(adol_15_17_anos) / {$qtEncontros}  as MediaAdol1517Anos, 
                                    SUM(homens_solteiros) / {$qtEncontros}  as MediaHomensSolteiros, 
                                    SUM(homens_casados) / {$qtEncontros}  as MediaHomensCasados,
                                    SUM(mulheres_solteiras) / {$qtEncontros}  as MediaMulheresSolteiras, 
                                    SUM(mulheres_casadas) / {$qtEncontros}  as MediaMulheresCasadas,
                                    SUM(total_visitas) as Visitas,
                                    SUM(total_decisoes) as Decisoes
                             FROM   presenca_itens
                             WHERE  id_presenca = :idPresenca", "idPresenca={$idPresenca}");

            if ($Read->getResult()):
                $dados = $Read->getResult()[0];

                $dados['Total'] = (float) $dados['MediaAte11'] +
                        (float) $dados['MediaAdol1214Anos'] +
                        (float) $dados['MediaAdol1517Anos'] +
                        (float) $dados['MediaHomensSolteiros'] +
                        (float) $dados['MediaHomensCasados'] +
                        (float) $dados['MediaMulheresSolteiras'] +
                        (float) $dados['MediaMulheresCasadas'];
            endif;
        endif;

        return $dados;
    }

}
