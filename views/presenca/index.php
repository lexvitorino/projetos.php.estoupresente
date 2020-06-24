<?php
if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);

$Celulas = array();
$Read->ExeRead(CELULA, "WHERE id_subscriber = :idSubscriber 
                          AND ativo = 1
                          AND :idMembroLogin in (id_auxiliar, id_dirigente, id_supervisor, id_area, id_pastor, id_distrito)", "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);
if ($Read->getResult()):
    $Celulas = $Read->getResult();
endif;

$PresencaFiltro = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($PresencaFiltro && $PresencaFiltro['SendPostFiltro']):
    $MesAno = (string) ( (!empty($PresencaFiltro) && !empty($PresencaFiltro["mes_ano"])) ? $PresencaFiltro["mes_ano"] : $_SESSION['mes_ano']);
    $_SESSION['mes_ano'] = $MesAno;

    $IdCelula = (int) ( (!empty($PresencaFiltro) && !empty($PresencaFiltro["id_celula"])) ? $PresencaFiltro["id_celula"] : $_SESSION['id_celula']);
    $_SESSION['id_celula'] = $IdCelula;
endif;
?>

<div class="ibox-content">
    <form method="POST">
        <div class="col-sm-6 form-group">
            <label for="id_celula">Célula</label>
            <select name="id_celula" class="form-control" required>
                <option value="">Selecione um</option>
                <?php foreach ($Celulas as $item): ?>
                    <option value="<?= $item['id'] ?>" <?= ($item['id'] == (empty($_SESSION['id_celula']) ? '' : $_SESSION['id_celula'])) ? 'selected="selected"' : ''; ?>> <?= $item['nome']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-3 form-group">
            <label for="id_celula">Referência</label>
            <select name="mes_ano" class="form-control" required>
                <option value="">Selecione um</option>
                <?php
                $data0 = date("m/Y", strtotime("-2 month"));

                $select = ("{$data0}" == (empty($_SESSION['mes_ano']) ? '' : $_SESSION['mes_ano'])) ? "selected='selected'" : "";
                if (empty($select)) {
                    $select = str_pad(date("m"), 2, "0", STR_PAD_LEFT) + "/" + str_pad(date("Y"), 4, "0", STR_PAD_LEFT);
                }
                echo "<option value='{$data0}' " . $select . ">{$data0}</option>";
                
                $data1 = date("m/Y", strtotime("-1 month"));

                $select = ("{$data1}" == (empty($_SESSION['mes_ano']) ? '' : $_SESSION['mes_ano'])) ? "selected='selected'" : "";
                if (empty($select)) {
                    $select = str_pad(date("m"), 2, "0", STR_PAD_LEFT) + "/" + str_pad(date("Y"), 4, "0", STR_PAD_LEFT);
                }
                echo "<option value='{$data1}' " . $select . ">{$data1}</option>";

                $data2 = date("m/Y");

                $select = ("{$data2}" == (empty($_SESSION['mes_ano']) ? '' : $_SESSION['mes_ano'])) ? "selected='selected'" : "";
                if (empty($select)) {
                    $select = str_pad(date("m"), 2, "0", STR_PAD_LEFT) + "/" + str_pad(date("Y"), 4, "0", STR_PAD_LEFT);
                }
                echo "<option value='{$data2}' " . $select . ">{$data2}</option>";
                ?>
            </select>
        </div>

        <div class="clearfix"></div>

        <input id="submit" name="SendPostFiltro" type="submit" class="btn btn-w-m btn-primary" value="Buscar"/>
    </form>   
</div>

<?php
if (!empty($MesAno) && !empty($IdCelula)):
    ?>    
    <div class="ibox float-e-margins">
        <?php
        $Presenca = array();

        $Read->ExeRead(PRESENCA, "WHERE id_subscriber = :idSubscriber AND id_celula = :idCelula AND mes_ano = :mesAno", "idSubscriber=" . SUBSCRIBER_ID . "&idCelula={$IdCelula}&mesAno={$MesAno}");

        $Presencas = $Read->getResult();

        if (!$Presencas):
            $P = new Presenca();
            $Presenca = $P->InitPresenca($IdCelula, $MesAno);
        else:
            $Presenca = $Presencas[0];
        endif;

        extract($Presenca);
        ?>     

        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                        <tr>
                            <th style="text-align: left">Ações</th>
                            <?php if (ADMIN): ?><th style="text-align: left">ID</th><?php endif; ?>
                            <th style="text-align: left">Total de novas decisões no mês</th>
                            <th style="text-align: left">Total de pessoas foram batizados no mês</th>
                            <th style="text-align: left">Total de pessoas fizeram vida vitoriosa no mês</th>
                            <th style="text-align: left">Quantos adultos e/ou adolescentes estão ligados ao GCEM?</th>
                            <th style="text-align: left">Quantas crianças até 11 anos estão ligadas ao GCEM?</th>
                            <th style="text-align: left">Qtde de Crianças de 3 a 11 anos ligadas ao GCEM infantil</th>
                            <th style="text-align: left">Auxiliar participou da vigilia</th>
                            <th style="text-align: left">Auxiliar treinamento 1 participou da vigilia</th>
                            <th style="text-align: left">Auxiliar treinamento 2 participou da vigilia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td width="100">
                                <a class="btn btn-warning dim" href="<?= BASE; ?>/presenca/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger dim " href="<?= BASE; ?>/presenca/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                            </td>
                            <?php if (ADMIN): ?><td><?= $id; ?></td><?php endif; ?>
                            <td><?= $total_decisoes_mes; ?></td>
                            <td><?= $total_batizados_mes; ?></td>
                            <td><?= $total_vida_vitoriosa_mes; ?></td>
                            <td><?= $total_maior_12_anos_mes; ?></td>
                            <td><?= $total_menor_11_anos_mes; ?></td>
                            <td><?= $total_celulas_criancas_mes; ?></td>
                            <td><?= $auxiliar_vigilia; ?></td>
                            <td><?= $auxiliar_treinamento_1_vigilia; ?></td>
                            <td><?= $auxiliar_treinamento_2_vigilia; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ibox-title">
            <a class="btn btn-w-m btn-info" href="<?= BASE; ?>/presencaItem/create/<?= $id; ?>">Adicionar</a><br/>
        </div>    
        <?php
        $Read->ExeRead(PRESENCA_ITEM, "WHERE id_presenca = :id", "id={$id}");

        if ($Read->getResult()):
            ?>     
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" >
                        <thead>
                            <tr>
                                <th style="text-align: left;">Ações</th>
                                <?php if (ADMIN): ?><th>ID</th><?php endif; ?>
                                <th style="text-align: left;">Encontro</th>
                                <th style="text-align: center">Data</th>
                                <th style="text-align: left;">Crianças até 11 anos</th>
                                <th style="text-align: left;">Adol de 12 a 14 anos</th>
                                <th style="text-align: left;">Adol de 15 a 17 anos</th>
                                <th style="text-align: left;">Homens solteiros</th>
                                <th style="text-align: left;">Homens casados</th>
                                <th style="text-align: left;">Mulheres solteiras</th>
                                <th style="text-align: left;">Mulheres casadas</th>
                                <th style="text-align: left;">Total Geral</th>
                                <th style="text-align: left;">Do total de pessoas, quantas visitas?</th>
                                <th style="text-align: left;">Do total de pessoas, quantas decisões?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($Read->getResult() as $p): ?>
                                <tr>
                                    <td width="100">
                                        <a class="btn btn-warning dim" href="<?= BASE; ?>/presencaItem/update/<?= $p['id']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                        <a class="btn btn-danger dim " href="<?= BASE; ?>/presencaItem/delete/<?= $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                                    </td>
                                    <?php if (ADMIN): ?><td><?= $p['id']; ?></td><?php endif; ?>
                                    <td><?= $p['semana']; ?></td>
                                    <td><?= !empty($p['data']) ? date('d/m/Y', strtotime($p['data'])) : ""; ?></td>
                                    <td><?= $p['ate_11']; ?></td>
                                    <td><?= $p['adol_12_14_anos']; ?></td>
                                    <td><?= $p['adol_15_17_anos']; ?></td>
                                    <td><?= $p['homens_solteiros']; ?></td>
                                    <td><?= $p['homens_casados']; ?></td>
                                    <td><?= $p['mulheres_solteiras']; ?></td>
                                    <td><?= $p['mulheres_casadas']; ?></td>
                                    <td><?= $p['total_geral']; ?></td>
                                    <td><?= $p['total_visitas']; ?></td>
                                    <td><?= $p['total_decisoes']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>        
            <?php
        else:
            echo Erro("<span class='al_center icon-notification'>Ainda não existem presencas lançados!</span>", E_USER_NOTICE);
        endif;
        ?>
    </div>
<?php endif; ?>