<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/fichaFColheita/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
        <?php
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager(BASE . '/fichaFColheita/index?page=');
        $Pager->ExePager($getPage, REGISTROS_PAGINA);

        $read = new Read;
        $read->FullRead("SELECT f.*, m.nome as membro FROM " . FICHA_FCOLHEITA . " f 
                             LEFT JOIN " . MEMBRO . " m ON m.id = f.id_membro " .
                        " WHERE f.id_subscriber = :idSubscriber AND f.encargo = :encargo " . LIDERES . 
                        " ORDER BY f.created_date DESC LIMIT :limit OFFSET :offset", 
                        "idSubscriber=" . SUBSCRIBER_ID . "&idMembro=" . MEMBRO_ID . "&encargo=" . ENCARGO_SEL. "&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");
                        
        if ($read->getResult()): ?> 
        <div class="ibox-title">
            <h5>Listagem de <?= $viewData['GetExeLb']; ?></h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" >
                    <thead>
                        <tr>
                            <?php if(ADMIN): ?><th style="text-align: left">ID</th><?php endif; ?>
                            <th style="text-align: left">Ano</th>
                            <th style="text-align: left">Lider</th>
                            <th style="text-align: right">Total Pessoas</th>
                            <th style="text-align: right">Total Oferta</th>
                            <th style="text-align: center">Foto</th>
                            <th style="text-align: left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($read->getResult() as $fichaFColheita):
                        extract($fichaFColheita);
                        ?>            
                        <tr>
                            <?php if(ADMIN): ?><td width="50"><?= $id; ?></td><?php endif; ?>
                            <td width="150"><?= $ano; ?></td>
                            <td><?= $membro; ?></td>
                            <td width="150" style="text-align: right"><?= $total; ?></td>
                            <td width="150" style="text-align: right"><?= $total_pago; ?></td>
                            <td width="150" style="text-align: center">
                                <?php if(!empty($foto)): ?>
                                    <img src="<?= BASE; ?>/_uploads/<?= $foto; ?>" alt="Foto" style="width: 130px; height: 100px;">
                                <?php endif; ?>
                            </td>
                            <td width="110">
                                <a class="btn btn-warning dim" href="<?= BASE; ?>/fichaFColheita/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger dim " href="<?= BASE; ?>/fichaFColheita/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
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
        echo Erro("<span class='al_center icon-notification'>Ainda não existem fichas lançados!</span>", E_USER_NOTICE);
    endif;
    $Pager->ExePaginator(FICHA_FCOLHEITA, "WHERE id_subscriber = :idSubscriber AND created_id_user = :idLogin",
                                          "idSubscriber=" . SUBSCRIBER_ID . "&idLogin=" . USUARIO_ID);
    echo $Pager->getPaginator();
    ?>
</div>