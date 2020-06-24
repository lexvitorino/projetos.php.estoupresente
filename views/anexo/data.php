<?php
extract($viewData);
if (!empty($AnexoData)):
    extract($AnexoData);
endif;

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
            <a href="<?= BASE; ?>/anexo" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>

                    <div class="col-sm-12 form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= (!empty($nome)) ? $nome : ''; ?>" required/>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-12 form-group">
                        <input type="file" class="form-control" name="caminho"/>
                        <?php if(!empty($caminho)): ?>
                        <label class="label"><?= $caminho ?></label>
                        <?php endif; ?>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-12 form-group">
                        <label for="comentario">Comentário</label>
                        <textarea class="form-control" name="comentario" rows="10" require><?= (!empty($comentario)) ? $comentario : ''; ?></textarea>
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