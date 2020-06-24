<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($FichaFColheitaItemData)):
    extract($FichaFColheitaItemData);
endif;

?>

<div class="ibox float-e-margins">
    <form method="POST">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/fichaFColheita/update/<?= $id_ficha_fcolheita ?>" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>
                    <input type="hidden" name="id_ficha_fcolheita" value="<?= (!empty($id_ficha_fcolheita)) ? $id_ficha_fcolheita : '0'; ?>"/>

                    <div class="col-sm-12 form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= !empty($nome) ? $nome : ""; ?>" autofocus=""/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="valor">Valor</label>
                        <input type="number" name="valor" class="form-control" value="<?= !empty($valor) ? $valor : ""; ?>"/>
                    </div>              
                </div>
            </div>
        </div>
    </form>  
</div>