<?php
if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if (!empty($PresencaItemData)):
    extract($PresencaItemData);
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
                    <input type="hidden" name="id_presenca" value="<?= (!empty($id_presenca)) ? $id_presenca : '0'; ?>"/>
                    <input type="hidden" name="semana" value="<?= (!empty($semana)) ? $semana : '0'; ?>"/>

                    <div class="col-sm-3 form-group">
                        <label for="data">Data</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="data" value="<?= (!empty($data)) ? $data : ''; ?>" required>
                        </div>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="ate_11">Crianças até 11 anos</label>
                        <input type="number" name="ate_11" class="form-control" value="<?= !empty($ate_11) ? $ate_11 : ""; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="adol_12_14_anos">Adol de 12 a 14 anos</label>
                        <input type="number" name="adol_12_14_anos" class="form-control" value="<?= !empty($adol_12_14_anos) ? $adol_12_14_anos : ""; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="adol_15_17_anos">Adol de 15 a 17 anos</label>
                        <input type="number" name="adol_15_17_anos" class="form-control" value="<?= !empty($adol_15_17_anos) ? $adol_15_17_anos : ""; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="homens_solteiros">Homens solteiros</label>
                        <input type="number" name="homens_solteiros" class="form-control" value="<?= !empty($homens_solteiros) ? $homens_solteiros : ""; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="homens_casados">Homens casados</label>
                        <input type="number" name="homens_casados" class="form-control" value="<?= !empty($homens_casados) ? $homens_casados : ""; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="mulheres_solteiras">Mulheres solteiras</label>
                        <input type="number" name="mulheres_solteiras" class="form-control" value="<?= !empty($mulheres_solteiras) ? $mulheres_solteiras : ""; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="mulheres_casadas">Mulheres casadas</label>
                        <input type="number" name="mulheres_casadas" class="form-control" value="<?= !empty($mulheres_casadas) ? $mulheres_casadas : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="total_visitas">Do total de pessoas, quantas visitas?</label>
                        <input type="number" name="total_visitas" class="form-control" value="<?= !empty($total_visitas) ? $total_visitas : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="total_decisoes">Do total de pessoas, quantas decisões? </label>
                        <input type="number" name="total_decisoes" class="form-control" value="<?= !empty($total_decisoes) ? $total_decisoes : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_encontro_9">Auxiliar (Culto 9hs)</label>
                        <input type="number" name="auxiliar_encontro_9" class="form-control" value="<?= !empty($auxiliar_encontro_9) ? $auxiliar_encontro_9 : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_encontro_18">Auxiliar (Culto 18hs)</label>
                        <input type="number" name="auxiliar_encontro_18" class="form-control" value="<?= !empty($auxiliar_encontro_18) ? $auxiliar_encontro_18 : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_encontro_ide">Auxiliar (IDE)</label>
                        <input type="number" name="auxiliar_encontro_ide" class="form-control" value="<?= !empty($auxiliar_encontro_ide) ? $auxiliar_encontro_ide : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_treinamento_1_encontro_9">Auxiliar em Treinamento 1 (Culto 9hs)</label>
                        <input type="number" name="auxiliar_treinamento_1_encontro_9" class="form-control" value="<?= !empty($auxiliar_treinamento_1_encontro_9) ? $auxiliar_treinamento_1_encontro_9 : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_treinamento_1_encontro_18">Auxiliar em Treinamento 1 (Culto 18hs)</label>
                        <input type="number" name="auxiliar_treinamento_1_encontro_18" class="form-control" value="<?= !empty($auxiliar_treinamento_1_encontro_18) ? $auxiliar_treinamento_1_encontro_18 : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_treinamento_1_encontro_ide">Auxiliar em Treinamento 1 (IDE)</label>
                        <input type="number" name="auxiliar_treinamento_1_encontro_ide" class="form-control" value="<?= !empty($auxiliar_treinamento_1_encontro_ide) ? $auxiliar_treinamento_1_encontro_ide : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_treinamento_2_encontro_9">Auxiliar em Treinamento 2 (Culto 9hs)</label>
                        <input type="number" name="auxiliar_treinamento_2_encontro_9" class="form-control" value="<?= !empty($auxiliar_treinamento_2_encontro_9) ? $auxiliar_treinamento_2_encontro_9 : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_treinamento_2_encontro_18">Auxiliar em Treinamento 2 (Culto 18hs)</label>
                        <input type="number" name="auxiliar_treinamento_2_encontro_18" class="form-control" value="<?= !empty($auxiliar_treinamento_2_encontro_18) ? $auxiliar_treinamento_2_encontro_18 : ""; ?>"/>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="auxiliar_treinamento_2_encontro_ide">Auxiliar em Treinamento 2 (IDE)</label>
                        <input type="number" name="auxiliar_treinamento_2_encontro_ide" class="form-control" value="<?= !empty($auxiliar_treinamento_2_encontro_ide) ? $auxiliar_treinamento_2_encontro_ide : ""; ?>"/>
                    </div>
                </div>
            </div>
        </div>
    </form>                
</div>