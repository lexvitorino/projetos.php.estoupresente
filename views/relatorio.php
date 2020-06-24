<?php
extract($viewData);
?>

<div class="ibox-title">
    <h5>Relatório de</h5>
</div>

<div class="ibox-content">
    <form method="POST">
        <div class="col-sm-3 form-group">
            <label for="mes_ano">Referência</label>
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

<div class="ibox float-e-margins">
    <div class="ibox-content">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-2"> Discipulados</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3"> Células Visitadas</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4"> Totais da Célula</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-2" class="tab-pane active">
                        <div class="panel-body">
                            <?php if ($Discipulados): ?> 
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr>
                                                <th style="text-align: left">Com quem</th>
                                                <th style="text-align: left">Dia</th>
                                                <th style="text-align: left">Assunto</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($Discipulados as $discipulado):
                                                extract($discipulado);
                                                ?>            
                                                <tr>
                                                    <td width="250"><?= $com_quem; ?></td>
                                                    <td width="150"><?= date('d/m/Y', strtotime($data)); ?></td>
                                                    <td><?= $assunto; ?></td>
                                                </tr>
                                                <?php
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            else:
                                echo Erro("<span class='al_center icon-notification'>Ainda não existem discipulados lançados!</span>", E_USER_NOTICE);
                            endif;
                            ?>
                        </div>                        
                    </div>
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <?php if ($CelulasVisitadas): ?> 
                                <div class="ibox-title">
                                    <h5>Listagem de <?= $GetExeLb; ?></h5>
                                </div>
                                <div class="ibox-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" >
                                            <thead>
                                                <tr>
                                                    <th style="text-align: left">Célula</th>
                                                    <th style="text-align: left">Data</th>
                                                    <th style="text-align: left">Tempo</th>
                                                    <th style="text-align: left">Encontro</th>
                                                    <th style="text-align: left">Exaltação</th>
                                                    <th style="text-align: left">Edificação</th>
                                                    <th style="text-align: left">Evangelismo</th>
                                                    <th style="text-align: left">Houve Oração</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($CelulasVisitadas as $visitada):
                                                    extract($visitada);
                                                    ?>            
                                                    <tr>
                                                        <td><?= $celula; ?></td>
                                                        <td width="150"><?= date('d/m/Y', strtotime($data)); ?></td>
                                                        <td><?= $tempo; ?></td>
                                                        <td><?= $encontro; ?></td>
                                                        <td><?= $exaltacao; ?></td>
                                                        <td><?= $edificacao; ?></td>
                                                        <td><?= $evangelismo; ?></td>
                                                        <td><?= $oracao; ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php
                            else:
                                echo Erro("<span class='al_center icon-notification'>Ainda não existem células visitadas lançados!</span>", E_USER_NOTICE);
                            endif;
                            ?>
                        </div>                        
                    </div>
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <?php if ($Presencas): ?> 
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr>
                                                <th style="text-align: left">Célula</th>
                                                <th style="text-align: left">Crianças até 11 anos</th>
                                                <th style="text-align: left">Adol de 12 a 14 anos</th>
                                                <th style="text-align: left">Adol de 15 a 17 anos</th>
                                                <th style="text-align: left">Homens solteiros</th>
                                                <th style="text-align: left">Homens casados</th>
                                                <th style="text-align: left">Mulheres solteiras</th>
                                                <th style="text-align: left">Mulheres casadas</th>
                                                <th style="text-align: left">Total</th>
                                                <th style="text-align: left">Visitas</th>
                                                <th style="text-align: left">Total de Novas Decisões no Mês</th>
                                                <th style="text-align: left">Pessoas que concluíram o livreto Bem Vindo no mês</th>
                                                <th style="text-align: left">Pessoas que fizeram o encontro Vida Vitoriosa</th>
                                                <th style="text-align: left">Pessoas batizadas no mês</th>
                                                <th style="text-align: left">Pessoas que concluiram o livro Nossa Visão no Mês</th>
                                                <th style="text-align: left">Pessoas que concluiram o livro Formando Discipulos</th>
                                                <th style="text-align: left">Crianças 3 a 11 ligadas ao GCEM infantil</th>
                                                <th style="text-align: left">Total crianças até 11 anos ligadas ao GCEM</th>
                                                <th style="text-align: left">Quantidade Adulto/Adolecentes ligados ao GCEM</th>
                                                <th style="text-align: left">Quantidade total de membros ligados ao GCEM</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($Presencas as $Preenca):
                                                extract($Preenca['Itens']);
                                                ?>            
                                                <tr>
                                                    <td><?= $celula; ?></td>
                                                    <td><?= (empty($PresencaItem['MediaAte11'])) ? '0' : round($PresencaItem['MediaAte11'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['MediaAdol1214Anos'])) ? '0' : round($PresencaItem['MediaAdol1214Anos'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['MediaAdol1517Anos'])) ? '0' : round($PresencaItem['MediaAdol1517Anos'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['MediaHomensSolteiros'])) ? '0' : round($PresencaItem['MediaHomensSolteiros'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['MediaHomensCasados'])) ? '0' : round($PresencaItem['MediaHomensCasados'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['MediaMulheresSolteiras'])) ? '0' : round($PresencaItem['MediaMulheresSolteiras'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['MediaMulheresCasadas'])) ? '0' : round($PresencaItem['MediaMulheresCasadas'], 2); ?></td>
                                                    <td><?= (empty($PresencaItem['Total'])) ? '0' : $PresencaItem['Total']; ?></td>
                                                    <td><?= (empty($PresencaItem['Visitas'])) ? '0' : $PresencaItem['Visitas']; ?></td>
                                                    <td><?= (empty($PresencaItem['Decisoes'])) ? '0' : $PresencaItem['Decisoes']; ?></td>
                                                    <td><?= (empty($Presenca['total_vida_vitoriosa_mes'])) ? '0' : $Presenca['total_vida_vitoriosa_mes']; ?></td>
                                                    <td><?= (empty($Presenca['Decisoes'])) ? '0' : $Presenca['Decisoes']; ?></td>
                                                    <td><?= (empty($Presenca['total_batizados_mes'])) ? '0' : $Presenca['total_batizados_mes']; ?></td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td><?= (empty($Presenca['total_celulas_criancas_mes'])) ? '0' : $Presenca['total_celulas_criancas_mes']; ?></td>
                                                    <td><?= (empty($Presenca['total_menor_11_anos_mes'])) ? '0' : $Presenca['total_menor_11_anos_mes']; ?></td>
                                                    <td><?= (empty($Presenca['total_maior_12_anos_mes'])) ? '0' : $Presenca['total_maior_12_anos_mes']; ?></td>
                                                    <td><?= (empty($Presenca['TotalMembrosLigados'])) ? '0' : $Presenca['TotalMembrosLigados']; ?></td>
                                                </tr>
                                                <?php
                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            else:
                                echo Erro("<span class='al_center icon-notification'>Ainda não existem presenças lançados!</span>", E_USER_NOTICE);
                            endif;
                            ?>                                
                        </div>
                    </div>        
                </div>
            </div>
        </div>
    </div>
</div>