<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/discipulado/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Pager = new Pager(BASE . '/discipulado/index?page=');
    $Pager->ExePager($getPage, REGISTROS_PAGINA);

    $Read = new Read;
    $Read->FullRead("SELECT d.* FROM " . DISCIPULADO . " d
                        INNER JOIN " . USUARIO . " u ON u.id = d.created_id_user
                      WHERE d.id_subscriber = :idSubscriber 
                        AND u.chave = :idMembroLogado
                     ORDER BY data DESC LIMIT :limit OFFSET :offset", "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogado=" . MEMBRO_ID . "&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                     
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
                            <th style="text-align: left">Dia</th>
                            <th style="text-align: left">Com quem</th>
                            <th style="text-align: left">Assunto</th>
                            <th style="text-align: left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($Read->getResult() as $discipulado):
                            extract($discipulado);
                            ?>            
                            <tr>
                                <?php if (ADMIN): ?><td><?= $id; ?></td><?php endif; ?>
                                <td width="150"><?= date('d/m/Y', strtotime($data)); ?></td>
                                <td><?= $com_quem; ?></td>
                                <td><?= $assunto; ?></td>
                                <td width="110">
                                    <a class="btn btn-warning dim" href="<?= BASE; ?>/discipulado/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                    <a class="btn btn-danger dim " href="<?= BASE; ?>/discipulado/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
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
        echo Erro("<span class='al_center icon-notification'>Ainda não existem discipulados lançados!</span>", E_USER_NOTICE);
    endif;
    $Pager->FullPaginator("SELECT d.* FROM " . DISCIPULADO . " d
                            INNER JOIN " . USUARIO . " u ON u.id = d.created_id_user
                           WHERE d.id_subscriber = :idSubscriber 
                             AND u.chave = :idMembroLogado", "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogado=" . MEMBRO_ID);
    echo $Pager->getPaginator();
    ?>
</div>