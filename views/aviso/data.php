<?php
if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if (!empty($AvisoData)):
    extract($AvisoData);
endif;

$inicio = !empty($inicio) ? Check::DataT($inicio) : '';
$fim = !empty($fim) ? Check::DataT($fim) : '';

$Membro = new Membro();
$Membros = $Membro->getMembros(MEMBRO);
if (!$Membros):
    $Membros = array();
endif;
?>

<div class="ibox float-e-margins">
    <form method="POST" enctype="multipart/form-data">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/aviso" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id) ? $id : 0) ?>"/>

                    <div class="col-sm-6 form-group">
                        <label for="inicio">Inicia dia</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            <input type="datetime-local" class="form-control" name="inicio" value="<?= (!empty($inicio)) ? $inicio : ''; ?>" require>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="fim">Finaliza dia</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="datetime-local" class="form-control" name="fim" value="<?= (!empty($fim)) ? $fim : ''; ?>" require>
                        </div>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="titulo">Titulo</label>
                        <input type="text" name="titulo" class="form-control" value="<?= (!empty($titulo)) ? $titulo : ''; ?>" required/>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-12 form-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea class="form-control" name="mensagem" rows="10" require><?= (!empty($mensagem)) ? $mensagem : ''; ?></textarea>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="id_membro">Membro</label>
                        <select name="id_membro" class="form-control">
                            <option value="">Selecione um</option>
                            <?php foreach ($Membros as $item): ?>
                                <option value="<?= $item['id'] ?>" <?= ($item['id'] == (empty($id_membro) ? '' : $id_membro)) ? 'selected="selected"' : ''; ?>> <?= $item['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-2 form-group">
                        <div class="i-checks">
                            <label for="publico">
                                <input type="checkbox" class="form-control" name="publico" value="S" <?= (!empty($publico) && $publico == 'S') ? 'checked' : ''; ?> />	
                                &nbsp;&nbsp;&nbsp;Publico
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-2 form-group">
                        <div class="i-checks">
                            <label for="ativo" >
                                <input type="checkbox" class="form-control" name="ativo" value="S" <?= (!empty($ativo) && $ativo == 'S') ? 'checked' : ''; ?>  require/>	
                                &nbsp;&nbsp;&nbsp;Ativo
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>                    
</div>