<?php

if(empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($CelulaVisitadaData)):
    extract($CelulaVisitadaData);
endif;

$data = !empty($data) ? Check::DataT($data) : '';
$idMembroLogado = $_SESSION['userlogin']['chave'];

$Celulas = array();
$Read->ExeRead(CELULA, 
              "WHERE :idMembroLogado IN (id_dirigente, id_supervisor, id_area, id_pastor, id_distrito)",
              "idMembroLogado={$idMembroLogado}");
if ($Read->getResult()):
    $Celulas = $Read->getResult();
endif;

?>

<div class="ibox float-e-margins">
    <form method="POST" enctype="multipart/form-data">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/celulaVisitada" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <?php if (!empty($id)): ?> 
                    <input type="hidden" name="id" value="<?= $id; ?>"/>
                    <?php endif; ?>

                    <div class="col-sm-6 form-group">
                        <label for="data">Data</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="data" value="<?= (!empty($data)) ? $data : ''; ?>" require>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="tempo">Tempo</label>
                        <div class="input-group clockpicker" data-autoclose="true">
                            <input type="text" class="form-control" name="tempo" value="<?= (!empty($tempo)) ? $tempo : ''; ?>" >
                            <span class="input-group-addon">
                                <span class="fa fa-clock-o"></span>
                            </span>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-12 form-group">
                        <label for="id_celula">Célula</label>
                        <select name="id_celula" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach ($Celulas as $item): ?>
                                <option value="<?= $item['id']; ?>" <?= ($item['id'] == (empty($id_celula) ? '' : $id_celula)) ? 'selected="selected"' : ''; ?>> <?= $item['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-12 form-group">
                        <label for="observacao">Observação</label>
                        <textarea class="form-control" name="observacao" rows="10" require><?= (!empty($observacao)) ? $observacao : ''; ?></textarea>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="encontro">Encontro</label>
                        <select name="encontro" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($encontro) ? '' : $encontro)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="exaltacao">Exaltação</label>
                        <select name="exaltacao" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($exaltacao) ? '' : $exaltacao)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="edificacao">Edificação</label>
                        <select name="edificacao" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($edificacao) ? '' : $edificacao)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="evangelismo">Evangelismo</label>
                        <select name="evangelismo" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($evangelismo) ? '' : $evangelismo)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="oracao">Houve Oração</label>
                        <select name="oracao" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($oracao) ? '' : $oracao)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="presenca">Presença</label>
                        <select name="presenca" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($presenca) ? '' : $presenca)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="poder">Poder</label>
                        <select name="poder" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($poder) ? '' : $poder)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="proposito">Propósito</label>
                        <select name="proposito" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getVisitaStatus() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($proposito) ? '' : $proposito)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>                
                </div>
            </div>
        </div>
    </form>
</div>