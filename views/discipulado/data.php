<?php
extract($viewData);
if (!empty($DiscipuladoData)):
    extract($DiscipuladoData);
endif;

$data = !empty($data) ? Check::DataT($data) : '';
if (!empty($conversa)):
    $conversa = base64_decode($conversa);
endif;
?>

<div class="ibox float-e-margins">
    <form method="POST" enctype="multipart/form-data">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/discipulado" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>

                    <div class="clearfix"></div>

                    <div class="col-sm-3 form-group">
                        <label for="data">Data</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="data" value="<?= (!empty($data)) ? $data : ''; ?>" require>
                        </div>
                    </div>

                    <div class="col-sm-9 form-group">
                        <label for="titulo">Com quem?</label>
                        <input type="text" name="com_quem" class="form-control" value="<?php echo (!empty($com_quem)) ? $com_quem : ''; ?>" required/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="titulo">Assunto</label>
                        <input type="text" name="assunto" class="form-control" value="<?php echo (!empty($assunto)) ? $assunto : ''; ?>" required/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="mensagem">Conversa</label>
                        <textarea class="form-control" name="conversa" rows="10" require><?php echo (!empty($conversa)) ? $conversa : ''; ?></textarea>
                    </div>             
                </div>
            </div>
        </div>
    </form>   
</div>