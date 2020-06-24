<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/grupoPermissao/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Pager = new Pager(BASE . '/permissao/index?page=');
    $Pager->ExePager($getPage, REGISTROS_PAGINA);

    $Read = new Read;
    $Read->ExeRead(PERMISSION_GRUPO, "ORDER BY name DESC LIMIT :limit OFFSET :offset", 
                                     "limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

    if ($Read->getResult()): ?> 
    <div class="ibox-title">
        <h5>Listagem de <?= $GetExeLb; ?></h5>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr>
                        <?php if(ADMIN): ?><th style="text-align: left">ID</th><?php endif; ?>
                        <th style="text-align: left">Nome</th>
                        <th style="text-align: left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Read->getResult() as $grupo):
                    extract($grupo);
                    ?>            
                    <tr>
                        <?php if(ADMIN): ?><td><?= $id; ?></td><?php endif; ?>
                        <td><?= $name; ?></td>
                        <td width="110">
                            <a class="btn btn-warning dim" href="<?= BASE; ?>/grupoPermissao/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger dim " href="<?= BASE; ?>/grupoPermissao/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
else:
    $Pager->ReturnPage();
    echo Erro("<span class='al_center icon-notification'>Ainda não existem grupos de permissões lançadas!</span>", E_USER_NOTICE);
endif;
$Pager->ExePaginator(PERMISSION_GRUPO);
echo $Pager->getPaginator();
?>
</div>