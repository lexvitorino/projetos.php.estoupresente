<?php

class dashboardController extends ViewControl {

    public function __construct() {
        $login = new Login();
        if (!$login->CheckLogin()):
            header("Location: " . BASE . "/login");
        endif;
    }

    public function index() {
        $data = array(
            'GetExe' => 'dashboard',
            'GetExeLb' => 'Dashboard',
            'GetExeLbs' => 'Dashboard',
            'Celulas' => array()
        );

        if (empty($Read)):
            $Read = new Read;
        endif;

        $Read->ExeRead(CELULA, "WHERE id_subscriber = :idSubscriber 
                                  AND ativo = 1
                                  AND :idMembroLogin in (id_auxiliar, id_dirigente, id_supervisor, id_area, id_pastor, id_distrito)", "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);
        
        $Celulas = array();
        if ($Read->getResult()):
            $Celulas = $Read->getResult();
        endif;
        
        $startDate = strtotime(date('Y/m/01/', strtotime(date('Y/m/01/'))) . ' -12 month');
        $endDate = strtotime(date('Y/m/01/', strtotime(date('Y/m/01/'))));
        $currentDate = $endDate;

        while ($currentDate >= $startDate) {
            $currentDate = strtotime(date('Y/m/01/', $currentDate) . ' -1 month');
            $noAno[] = date('m/Y', $currentDate);
        }

        $noAno = array_reverse($noAno);

        $idCelula = '';

        $DashboardFiltro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if ($DashboardFiltro && $DashboardFiltro['SendPostFiltro']):
            $_SESSION['id_celula'] = (int) $DashboardFiltro['id_celula'];

            $datasets = [];

            if (!empty($_SESSION['id_celula'])):
                $idCelula = $_SESSION['id_celula'];

                $celula = $this->getCelula($idCelula);

                $presencas = $this->getPresencasDoAno($idCelula, $noAno);
                $dataList = is_array($presencas) ? array_values($presencas) : array();
                $color = View::RandomColor();
                
                $datasets = [
                    'label' => $celula['nome'],
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'data' => $dataList,
                    'fill' => false
                ];

                $data['DataSets'][0] = $datasets;
            else:
                $idCelula = "";
                for ($i = 0; $i < count($Celulas); $i++):
                    $idCelula = $Celulas[$i]['id'];

                    $celula = $this->getCelula($idCelula);

                    $presencas = $this->getPresencasDoAno($idCelula, $noAno);
                    $dataList = is_array($presencas) ? array_values($presencas) : array();
                    $color = View::RandomColor();
                    
                    $datasets[$i] = [
                        'label' => $celula['nome'],
                        'backgroundColor' => $color,
                        'borderColor' => $color,
                        'data' => $dataList,
                        'fill' => false
                    ];

                    $data['DataSets'] = $datasets;
                endfor;
            endif;
        endif;

        $data['Celulas'] = $Celulas;
        $data['NoAno'] = $noAno;

        $login = new Login();
        if ($login->hasPermission('dashboard')) {
            $this->loadTamplate('dashboard', $data);
        } else {
            $this->loadTamplate('nopermission', $data);
        }
    }

    private function getCelula($idCelula) {
        if (!empty($idCelula)):
            $Read = new Read;
            $Read->ExeRead(CELULA, "WHERE id = :idCelula", "idCelula={$idCelula}");
            return $Read->getResult()[0];
        else:
            return array();
        endif;
    }

    private function getPresencasDoAno($idCelula, array $ref) {
        $array = array();

        $currentRef = 0;
        $lastRef = count($ref) - 1;

        while ($currentRef < $lastRef) {
            $array[$ref[$currentRef]] = 0;
            $currentRef = $currentRef + 1;
        }

        $read = new Read;
        $meses = implode("','", $ref);
        $read->FullRead("SELECT p.mes_ano,
                                SUM(i.total_geral) / (SELECT COUNT(s.total_geral)
                                                      FROM   presenca_itens s 
                                                      WHERE  s.id_presenca = p.id
                                                      and    s.total_geral > 0) as total
                         FROM   presencas p 
                                 inner join presenca_itens i on i.id_presenca = p.id 
                         WHERE p.id_celula in ({$idCelula})
                         AND   p.mes_ano in ('{$meses}')
                         GROUP BY p.mes_ano");

        if ($read->getRowCount()) {
            foreach ($read->getResult() as $value) {
                $array[$value['mes_ano']] = $value['total'];
            }
            return $array;
        }
    }

}
