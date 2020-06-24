<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/anexo/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Pager = new Pager(BASE . '/anexo/index?page=');
    $Pager->ExePager($getPage, REGISTROS_PAGINA);

    $Read = new Read;
    $Read->ExeRead(ANEXO, "WHERE id_subscriber = :id_subscriber " .
                          (!ADMIN ? " AND created_id_user = " . USUARIO_ID : " ") .
                          " ORDER BY created_date DESC LIMIT :limit OFFSET :offset", 
                          "id_subscriber=" . SUBSCRIBER_ID ."&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                          
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
                            <th style="text-align: left">Arquivo</th>
                            <th style="text-align: left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($Read->getResult() as $anexo):
                        extract($anexo);
                        ?>            
                        <tr>
                            <?php if(ADMIN): ?><td><?= $id; ?></td><?php endif; ?>
                            <td><?= $nome; ?></td>
                            <td><?= $caminho; ?></td>
                            <td width="110">
                                <a class="btn btn-warning dim" href="<?= BASE; ?>/anexo/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger dim " href="<?= BASE; ?>/anexo/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
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
        echo Erro("<span class='al_center icon-notification'>Ainda não existem anexos lançados!</span>", E_USER_NOTICE);
    endif;
    $Pager->ExePaginator(ANEXO, "WHERE id_subscriber = :id_subscriber " .
                                (!ADMIN ? " AND created_id_user = " . USUARIO_ID : ""),
                                "id_subscriber=" . SUBSCRIBER_ID);
    echo $Pager->getPaginator();
    ?>
</div>