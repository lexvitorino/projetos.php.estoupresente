<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/fichaVVitoriosa/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
        <?php
        $getPage = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $Pager = new Pager(BASE . '/fichaVVitoriosa/index?page=');
        $Pager->ExePager($getPage, REGISTROS_PAGINA);

        $read = new Read;
        $read->ExeRead(FICHA_VVITORIOSA, 
                      "WHERE id_subscriber = :idSubscriber
                       AND (:idMembroLogin in (id_dirigente, id_supervisor, id_area) OR created_id_user = :idLogin)
                       ORDER BY created_date DESC LIMIT :limit OFFSET :offset", 
                      "idSubscriber=" . SUBSCRIBER_ID . "&idLogin=" . USUARIO_ID . "&idMembroLogin=" . MEMBRO_ID . "&limit={$Pager->getLimit()}&offset={$Pager->getOffset()}");

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
                            <th style="text-align: left">Nome</th>
                            <th style="text-align: left">Cadastro Para</th>
                            <th style="text-align: left">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($read->getResult() as $fichaVVitoriosa):
                        extract($fichaVVitoriosa);
                        ?>            
                        <tr>
                            <?php if(ADMIN): ?><td width="50"><?= $id; ?></td><?php endif; ?>
                            <td><?= $nome; ?></td>
                            <td><?= getTipoVVitoriosa($cadastro_para); ?></td>
                            <td width="110">
                                <a class="btn btn-warning dim" href="<?= BASE; ?>/fichaVVitoriosa/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger dim " href="<?= BASE; ?>/fichaVVitoriosa/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
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
    $Pager->ExePaginator(FICHA_VVITORIOSA);
    echo $Pager->getPaginator();
    ?>
</div>