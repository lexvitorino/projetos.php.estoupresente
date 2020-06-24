<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/aviso/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Pager = new Pager(BASE . '/aviso/index?page=');
    $Pager->ExePager($getPage, REGISTROS_PAGINA);

    $Read = new Read;
    $Read->ExeRead(AVISO, "WHERE id_subscriber = :id_subscriber " .
            (!ADMIN ? " AND created_id_user = " . USUARIO_ID : "") .
            " ORDER BY created_date DESC LIMIT :limit OFFSET :offset", "id_subscriber=" . SUBSCRIBER_ID . "&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

    if ($Read->getResult()):
        ?> 
        <div class="ibox-title">
            <h5>Listagem de <?= $GetExeLb; ?></h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                        <tr>
                            <?php if (ADMIN): ?><th style="text-align: left">ID</th><?php endif; ?>
                            <th style="text-align: left">Título</th>
                            <th style="text-align: left">Inicio</th>
                            <th style="text-align: left">Fim</th>
                            <th style="text-align: left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($Read->getResult() as $aviso):
                            extract($aviso);
                            ?>            
                            <tr>
                                <?php if (ADMIN): ?><td width="50"><?= $id; ?></td><?php endif; ?>
                                <td><?= $titulo; ?></td>
                                <td width="150"><?= date('d/m/Y H:i', strtotime($inicio)); ?></td>
                                <td width="150"><?= date('d/m/Y H:i', strtotime($fim)); ?></td>
                                <td width="140">
                                    <a class="btn btn-warning dim" href="<?= BASE; ?>/aviso/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                    <a class="btn btn-danger dim " href="<?= BASE; ?>/aviso/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                                    <a class="btn btn-info dim " href="<?= BASE; ?>/aviso/sendemail/<?= $id; ?>" onclick="return confirm('Deseja enviar email?')"><i class="fa fa-envelope"></i></a>
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
        echo Erro("<span class='al_center icon-notification'>Ainda não existem avisos lançados!</span>", E_USER_NOTICE);
    endif;
    $Pager->ExePaginator(AVISO, "WHERE id_subscriber = :id_subscriber " .
            (!ADMIN ? " AND created_id_user = " . USUARIO_ID : ""), "id_subscriber=" . SUBSCRIBER_ID);
    echo $Pager->getPaginator();
    ?>
</div>