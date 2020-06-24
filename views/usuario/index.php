<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/usuario/create">Adicionar</a><br/><br/>
<div class="ibox float-e-margins">
    <?php
    $Read = new Read;
    $Read->FullRead("SELECT u.*, pg.name as grupo 
                     FROM   " . USUARIO . " u
                       LEFT JOIN " . PERMISSION_GRUPO . " pg on pg.id = u.id_group
                     WHERE u.id_subscriber = :id_subscriber
                     ORDER BY u.name", "id_subscriber=" . SUBSCRIBER_ID);

    if ($Read->getResult()): ?>
    <div class="ibox-title">
        <h5>Listagem de <?= $GetExeLb; ?></h5>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table id="datatables" class="table table-striped table-bordered table-hover" >
                <thead>
                    <tr>
                        <?php if(ADMIN): ?><th style="text-align: left">ID</th><?php endif; ?>
                        <th style="text-align: left">Nome</th>
                        <th style="text-align: left">Login</th>
                        <th style="text-align: left">Grupo</th>
                        <th style="text-align: left">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($Read->getResult() as $usuario):
                        extract($usuario);
                        ?>            
                        <tr>
                            <?php if(ADMIN): ?><td width="50"><?= $id; ?></td><?php endif; ?>
                            <td><?= $name; ?></td>
                            <td width="150"><?= $login; ?></td>
                            <td width="150"><?= $grupo; ?></td>
                            <td width="110">
                                <a class="btn btn-warning dim" href="<?= BASE; ?>/usuario/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger dim " href="<?= BASE; ?>/usuario/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
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
    echo Erro("<span class='al_center icon-notification'>Ainda não existem usuários lançados!</span>", E_USER_NOTICE);
endif;
?>
</div>
