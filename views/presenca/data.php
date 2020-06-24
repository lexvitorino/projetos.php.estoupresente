<?php
extract($viewData);
if (!empty($PresencaData)):
    extract($PresencaData);
endif;
?>

<div class="ibox float-e-margins">
    <form method="POST">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/presenca" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>
                    <input type="hidden" name="id_celula" value="<?= (!empty($id_celula)) ? $id_celula : ''; ?>"/>
                    <input type="hidden" name="mes_ano" value="<?= (!empty($mes_ano)) ? $mes_ano : ''; ?>"/>

                    <div class="col-sm-12 form-group">
                        <label for="total_decisoes_mes">Total de novas decisões no mês</label>
                        <input type="number" name="total_decisoes_mes" class="form-control" value="<?= $total_decisoes_mes; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="total_batizados_mes">Total de pessoas foram batizados no mês</label>
                        <input type="number" name="total_batizados_mes" class="form-control" value="<?= $total_batizados_mes ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="total_vida_vitoriosa_mes">Total de pessoas fizeram vida vitoriosa no mês</label>
                        <input type="number" name="total_vida_vitoriosa_mes" class="form-control" value="<?= $total_vida_vitoriosa_mes; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="total_maior_12_anos_mes">Quantos adultos e/ou adolescentes estão ligados ao GCEM?</label>
                        <input type="number" name="total_maior_12_anos_mes" class="form-control" value="<?= $total_maior_12_anos_mes; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="total_menor_11_anos_mes">Quantas crianças até 11 anos estão ligadas ao GCEM?</label>
                        <input type="number" name="total_menor_11_anos_mes" class="form-control" value="<?= $total_menor_11_anos_mes; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="total_celulas_criancas_mes">Qtde de Crianças de 3 a 11 anos ligadas ao GCEM infantil</label>
                        <input type="number" name="total_celulas_criancas_mes" class="form-control" value="<?= $total_celulas_criancas_mes; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="auxiliar_vigilia">Auxiliar participou da vigilia</label>
                        <input type="number" name="auxiliar_vigilia" class="form-control" value="<?= $auxiliar_vigilia; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="auxiliar_treinamento_1_vigilia">Auxiliar treinamento 1 participou da vigilia</label>
                        <input type="number" name="auxiliar_treinamento_1_vigilia" class="form-control" value="<?= $auxiliar_treinamento_1_vigilia; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="auxiliar_treinamento_2_vigilia">Auxiliar treinamento 2 participou da vigilia</label>
                        <input type="number" name="auxiliar_treinamento_2_vigilia" class="form-control" value="<?= $auxiliar_treinamento_2_vigilia; ?>"/>
                    </div>              
                </div>
            </div>
        </div>
    </form>  
</div>