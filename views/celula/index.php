<?php
if (empty($Read)):
    $Read = new Read;
endif;

$Areas = array();
$Read->ExeRead(MEMBRO, "WHERE encargo = :encargo ORDER BY nome ASC", "encargo=" . ENCARGO_AREA);
if ($Read->getResult()):
    $Areas = $Read->getResult();
endif;

?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/celula/create">Adicionar</a><br/><br/>

<div class="ibox-content">
    <form method="POST">
        <div class="col-sm-4 form-group">
            <label for="id_area">Area</label>
            <select name="id_area" class="form-control area" data-id="<?= (!empty($id_area)) ? $id_area : '0'; ?>" required>
                <option value="">Selecione um</option>
                <?php foreach ($Areas as $item): ?>
                    <option value="<?= $item['id'] ?>"> <?= $item['nome']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label for="id_supervisor">Supervisor</label>
            <select name="id_supervisor" class="form-control supervisor" data-id="<?= (!empty($id_supervisor)) ? $id_supervisor : '0'; ?>">
                <option value="">Selecione um supervisor de Área</option>
            </select>
        </div>

        <div class="col-sm-4 form-group">
            <label for="id_dirigente">Dirigente</label>
            <select name="id_dirigente" class="form-control dirigente" data-id="<?= (!empty($id_dirigente)) ? $id_dirigente : '0'; ?>">
                <option value="">Selecione um supervisor</option>
            </select>
        </div>

        <div class="clearfix"></div>

        <input id="submit" name="SendPostFiltro" type="submit" class="btn btn-w-m btn-primary" value="Buscar"/>
    </form>   
</div>

<div class="ibox float-e-margins">
    <?php
    
    $Read = new Read();
    
    $Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $filtro = "";
    if (!empty($Data["id_dirigente"])):
        $filtro = " AND u.id_dirigente= {$Data["id_dirigente"]}";
    elseif (!empty($Data["id_supervisor"])):
        $filtro = " AND u.id_supervisor = {$Data["id_supervisor"]}";
    else:
        $filtro = " AND u.id_area = {$Data["id_area"]}";
    endif;
    
    if ($Data && $Data['SendPostFiltro']):
        $Read->FullRead("SELECT u.*, 
                                md.nome as dirigente,
                                ms.nome as supervisor,
                                ma.nome as area
                         FROM   " . CELULA . " u
                             LEFT JOIN " . MEMBRO . " md on md.id = u.id_dirigente
                             LEFT JOIN " . MEMBRO . " ms on ms.id = u.id_supervisor
                             LEFT JOIN " . MEMBRO . " ma on ma.id = u.id_area
                         WHERE u.id_subscriber = :idSubscriber 
                           AND (:idMembroLogin in (u.id_auxiliar, u.id_dirigente, u.id_supervisor, u.id_area, u.id_pastor, u.id_distrito) OR
                                md.id_lider = :idMembroLogin OR
                                :admin=1) " . $filtro . 
                        " ORDER BY u.created_date ASC", "admin=" . ADMIN . "&idSubscriber=" . SUBSCRIBER_ID . "&idMembroLogin=" . MEMBRO_ID);
    endif;
    
    if ($Read->getResult()):
        ?> 
        <div class="ibox-title">
            <h5>Listagem de <?= $GetExeLb; ?></h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <?php
                foreach ($Read->getResult() as $celula):
                    extract($celula);
                    ?>    
                    <div class="col-lg-6">
                        <div class="contact-box" style="<?= (!$ativo) ? 'border-color: #ed5565' : ''; ?> <?= strpos(strtolower($nome), 'criança') ? 'border-color: #8892BF' : ''; ?>">
                            <div class="col-sm-6">
                                <h3><strong><?= (ADMIN ? $id . ". " : "") ?> <?= $nome; ?></strong> <h5><?= $dia ?>, <?= $horario ?></h5></h3>
                                <p><i class="fa fa-map-marker"></i> <?= $endereco ?>, <?= $numero ?><br/>
                                    <?= Check::Words($bairro, 10) ?>, <?= $cep ?></p>

                                <div class="clearfix"></div>
                                <a class="btn btn-warning dim" title="Alterar" href="<?= BASE; ?>/celula/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                                <a class="btn btn-danger dim " title="Excluir" href="<?= BASE; ?>/celula/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
                            </div>
                            <div class="col-sm-6">
                                <br>
                                <?php
                                $ReadMembros = new Read();
                                $ReadMembros->ExeRead(MEMBRO, "WHERE id_lider = :id_lider", "id_lider={$id_dirigente}");
                                $QtM = $ReadMembros->getRowCount();

                                $QtA = 0;
                                if (!empty($id_auxiliar)):
                                    $QtA = $QtA + 1;
                                endif;

                                if (!empty($id_auxiliar_treinamento_1)):
                                    $QtA = $QtA + 1;
                                endif;

                                if (!empty($id_auxiliar_treinamento_2)):
                                    $QtA = $QtA + 1;
                                endif;
                                ?>

                                <p>
                                    <button type="button" class="btn btn-primary m-r-sm"><?= $QtM ?></button> Total de membros
                                </p>

                                <p>
                                    <button type="button" class="btn btn-success m-r-sm"><?= $QtA ?></button> Total de auxiliares
                                </p>

                                <br>
                                <strong>Célula.</strong> <?= ($ativo) ? 'ativa' : 'inativa' ?><br>
                                <strong>Dirigente.</strong> <?= (strlen($dirigente) > 25) ? substr($dirigente, 0, 25) . "..." : $dirigente; ?><br>
                                <strong>Supervisor.</strong> <?= (strlen($supervisor) > 25) ? substr($supervisor, 0, 25) . "..." : $supervisor; ?><br>
                                <strong>Area.</strong> <?= (strlen($area) > 25) ? substr($area, 0, 25) . "..." : $area; ?><br><br>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>        
        </div>
        <?php
    else:
        echo Erro("<span class='al_center icon-notification'>Ainda não existem células lançados!</span>", E_USER_NOTICE);
    endif;
    ?>
</div>