<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/celulaVisitada/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
    <?php
    $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    $Pager = new Pager(BASE . '/celulaVisitada/index?page=');
    $Pager->ExePager($getPage, REGISTROS_PAGINA);

    $Read = new Read;
    $Read->FullRead("SELECT u.*, c.nome as celula
                     FROM   " . CELULA_VISITADA . " u
                        INNER JOIN " . CELULA . " c on c.id = u.id_celula
                     WHERE u.id_subscriber = :idSubscriber
                       AND :idMembroLogin in (c.id_auxiliar, c.id_dirigente, c.id_supervisor, c.id_area, c.id_pastor, c.id_distrito)
                     ORDER BY u.data DESC LIMIT :limit OFFSET :offset", 
                    "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID . "&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

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
                        <th style="text-align: left">Data</th>
                        <th style="text-align: left">Célula</th>
                        <th style="text-align: left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($Read->getResult() as $visitada):
                    extract($visitada);
                    ?>            
                    <tr>
                        <?php if(ADMIN): ?><td width="50"><?= $id; ?></td><?php endif; ?>
                        <td width="150"><?= date('d/m/Y', strtotime($data)); ?></td>
                        <td><?= $celula; ?></td>
                        <td width="110">
                            <a class="btn btn-warning dim" href="<?= BASE; ?>/celulaVisitada/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger dim " href="<?= BASE; ?>/celulaVisitada/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    else:
        $Pager->ReturnPage();
        echo Erro("<span class='al_center icon-notification'>Ainda não existem células visitadas lançados!</span>", E_USER_NOTICE);
    endif;
    $Pager->FullPaginator("SELECT u.id
                           FROM   " . CELULA_VISITADA . " u
                              INNER JOIN " . CELULA . " c on c.id = u.id_celula
                           WHERE u.id_subscriber = :idSubscriber
                             AND :idMembroLogin in (c.id_auxiliar, c.id_dirigente, c.id_supervisor, c.id_area, c.id_pastor, c.id_distrito)",
                          "idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);
    echo $Pager->getPaginator();
    ?>
</div>