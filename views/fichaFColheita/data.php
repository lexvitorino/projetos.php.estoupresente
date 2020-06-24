<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($FichaFColheitaData)):
    extract($FichaFColheitaData);
endif;

$Membro = new Membro();
$Membros = $Membro->getLideres();
if(empty($Membros)):
    $Membros = array();
endif;

?>

<div class="ibox float-e-margins">
    <form method="POST" enctype="multipart/form-data">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/fichaFColheita" class="btn btn-w-m btn-default">Voltar</a>        
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6 b-r">
                        <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>
                        <input type="hidden" name="encargo" value="<?= (!empty($encargo)) ? $encargo : ''; ?>"/>

                        <div class="col-sm-6 form-group">
                            <label for="ano">Ano</label>
                            <input type="number" name="ano" class="form-control" value="<?= !empty($ano) ? $ano : date('Y'); ?>" required/>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-sm-12 form-group">
                            <label for="id_membro">Membro</label>
                            <select name="id_membro" class="form-control" required>
                                <option value="">Selecione um</option>
                                <?php foreach ($Membros as $item): ?>
                                <option class="<?= ($item['id'] == MEMBRO_ID) ? 'font-bold' : '' ?>" value="<?= $item['id'] ?>" <?= ($item['id'] == (empty($id_membro) ? '' : $id_membro)) ? 'selected="selected"' : ''; ?>><?= $item['nome']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label for="membros">Membros</label>
                            <input type="number" name="membros" class="form-control" value="<?= !empty($membros) ? $membros : 0; ?>"/>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label for="visitas">Visitas</label>
                            <input type="number" name="visitas" class="form-control" value="<?= !empty($visitas) ? $visitas : 0; ?>"/>
                        </div>

                        <div class="col-sm-6 form-group">
                            <label for="total">Total Pessoas</label>
                            <input type="number" name="total" class="form-control" value="<?= !empty($total) ? $total : 0; ?>"/>
                        </div>   

                        <div class="col-sm-6 form-group">
                            <label for="total_pago">Total Oferta</label>
                            <input type="text" name="total_pago" class="form-control" value="<?= !empty($total_pago) ? $total_pago : 0; ?>"/>
                        </div>     

                        <div class="col-sm-12 form-group">
                            <label for="foto">Foto</label>
                            <input type="file" class="form-control" name="foto"/>
                        </div>               
                    </div>
                    <div class="col-sm-6 b-r">
                        <?php if(!empty($foto)): ?>
                            <img src="<?= BASE; ?>/_uploads/<?= $foto; ?>" alt="Foto" style="width: 100%; height: 100%;">
                        <?php endif; ?>
                    </div>                
                </div>
            </div>
        </div>
    </form>   

    <br/>
    
    <?php if(!empty($id)): ?>
    <a class="btn btn-w-m btn-info" href="<?= BASE; ?>/fichaFColheitaItem/create/<?= $id; ?>">Adicionar</a><br/><br/>
    <?php endif; ?>            
        
    <?php
    $read = new Read;
    $read->ExeRead(FICHA_FCOLHEITA_ITEM, " WHERE id_ficha_fcolheita = :id_ficha_fcolheita", 
                                         "id_ficha_fcolheita=" . (!empty($id) ? $id : 0));

    if ($read->getResult()): ?>     
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr>
                        <?php if(ADMIN): ?><th style="text-align: left">ID</th><?php endif; ?>
                        <th style="text-align: left">Nome</th>
                        <th style="text-align: right">Valor</th>
                        <?php if($encargo!='Lider'): ?><th style="text-align: right">Valor Célula</th><?php endif; ?>
                        <th style="text-align: left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($read->getResult() as $fichaFColheita):
                    ?>            
                    <tr>
                        <?php if(ADMIN): ?><td width="50"><?= $id; ?></td><?php endif; ?>
                        <td><?= $fichaFColheita['nome']; ?></td>
                        <td width="150" style="text-align: right"><?= $fichaFColheita['valor']; ?></td>
                        <?php if($encargo!='Lider'): ?><td width="150" style="text-align: right"><?= $fichaFColheita['valor_celula']; ?></td><?php endif; ?>
                        <td width="110">
                            <a class="btn btn-warning dim" href="<?= BASE; ?>/fichaFColheitaItem/update/<?= $fichaFColheita['id']; ?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger dim " href="<?= BASE; ?>/fichaFColheitaItem/delete/<?= $fichaFColheita['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
    <?php
    else:
        echo Erro("<span class='al_center icon-notification'>Ainda não existem itens lançados!</span>", E_USER_NOTICE);
    endif;      
    ?>  
</div>