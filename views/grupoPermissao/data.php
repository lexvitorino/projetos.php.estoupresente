<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($GrupoPermissaoData)):
    extract($GrupoPermissaoData);
endif;

$Permissoes = array();
$Read->ExeRead(PERMISSION_PARAM, "ORDER BY name");
if ($Read->getResult()):
    $Permissoes = $Read->getResult();
endif;

$PermissoesSel = array();
if(!empty($params)):
    $Read->ExeRead(PERMISSION_PARAM, "WHERE id in (" . $params . ") ORDER BY name ");
    if ($Read->getResult()):
        $PermissoesSel = $Read->getResult();
    endif;
endif;

?>

<div class="ibox float-e-margins">
    <form method="POST">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary f-permissao" value="Salvar" />
            <a href="<?= BASE; ?>/grupoPermissao" class="btn btn-w-m btn-default">Voltar</a>   
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>
                    <input type="hidden" name="params" class="permissao-sel"/>

                    <div class="col-sm-12 form-group">
                        <label for="name">Nome do Grupo</label>
                        <input type="text" name="name" class="form-control" value="<?= (!empty($name)) ? $name : ''; ?>" required/>
                    </div>

                    <div class="col-sm-5">
                        <div class="panel panel-default">
                            <select class="form-control permissao-sel-in" multiple="" style="height: 350px;">
                                <?php foreach($Permissoes as $item):?> 
                                    <option value="<?= $item['id']; ?>"> <?= $item['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 text-center">
                        <label style="margin-top: 160px" class="btn btn-white dim permissao-sel-out-click"><i class="fa fa-mail-reply"></i></label>
                        <label style="margin-top: 160px" class="btn btn-white dim permissao-sel-in-click"><i class="fa fa-mail-forward"></i></label>
                    </div>
                    <div class="col-sm-5">
                        <div class="panel panel-default">
                            <select class="form-control permissao-sel-out" multiple="" style="height: 350px;">
                                <?php foreach($PermissoesSel as $item):?> 
                                    <option value="<?= $item['id']; ?>"> <?= $item['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>               
                </div>
            </div>
        </div>
    </form>  
</div>