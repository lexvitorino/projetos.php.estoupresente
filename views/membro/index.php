<?php
extract($viewData);
?>

<a class="btn btn-w-m btn-info" href="<?= BASE; ?>/membro/create">Adicionar</a><br/><br/>

<div class="ibox-content">
    <form method="POST">
        <div class="col-sm-12 form-group">
            <label for="id_lider">Lider</label>
            <select name="id_lider" class="form-control">
                <option value="">Selecione um</option>
                <?php
                    $ReadMembro = new Membro();            
                    $Membros = $ReadMembro->getMembrosPorEncargo(ENCARGO_SEL);
                    if ($Membros) {
                        foreach ($Membros as $Membro) {
                            echo "<option value='{$Membro["id"]}'>{$Membro["nome"]}</option>";    
                        }
                    }
                ?>
            </select>
        </div>

        <div class="clearfix"></div>

        <input id="submit" name="SendPostFiltro" type="submit" class="btn btn-w-m btn-primary" value="Buscar"/>
    </form>   
</div>


<div class="ibox float-e-margins">
    <?php
    $Read = new Read;
    
    $Data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    
    $filtro = "";
    if (!empty($Data["id_lider"])):
        $filtro = " AND m.id_lider = {$Data["id_lider"]} ";
    endif;
    
    $Read->FullRead("SELECT m.*, l.nome as lider, (select u.login from users u where u.chave = m.id LIMIT 1) as loginMembro, 
                            (SELECT c.nome FROM " . CELULA . " c  WHERE c.id_dirigente = m.id LIMIT 1 ) as celula 
                     FROM " . MEMBRO . " m " .
                    "  LEFT JOIN " . MEMBRO . " l on l.id = m.id_lider " .
                    "WHERE m.id_subscriber = :idSubscriber AND m.encargo = :encargo " . $filtro . LIDERES .
                    " ORDER BY m.nome DESC", "idSubscriber=" . SUBSCRIBER_ID . "&idMembro=" . MEMBRO_ID . "&encargo=" . ENCARGO_SEL);

    if ($Read->getResult()):
        ?> 
        <div class="ibox-title">
            <h5>Listagem de <?= $GetExeLb; ?></h5>        
        </div>
        <div class="ibox-content">
            <div class="row">
                <?php
                foreach ($Read->getResult() as $membro):
                    extract($membro);
                    ?>    
                    <div class="col-lg-6">
                        <div class="contact-box">
                            <div class="col-sm-8">
                                <h3><strong><?= ($id . ". ") ?> <?= $nome; ?></strong></h3>
                                <p><i class="fa fa-paper-plane-o"></i> <?= $email ?></p>
                                <p><strong>Data Nascimento.: </strong><?= date('d/m/Y', strtotime($data_nascimento)); ?></p>
                                <p><strong>Encargo.: </strong><?= $encargo ?></p>
                                <p><strong>Login.: </strong><?= $loginMembro ?></p>
                                <p><strong>Lider.: </strong><?= $lider ?></p><br/>
                            </div>
                            <div class="col-sm-4">
                                <p><?= $telefone ?></p>
                                <p><?= $celular ?></p>
                                <p><strong>Célula.: </strong><?= $celula ?></p><br/>
                            </div>
                            <div class="clearfix"></div>
                            <a class="btn btn-warning dim" title="Alterar" href="<?= BASE; ?>/membro/update/<?= $id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger dim " title="Excluir" href="<?= BASE; ?>/membro/delete/<?= $id; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')"><i class="fa fa-times"></i></a>
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
        echo Erro("<span class='al_center icon-notification'>Ainda não existem membros lançados!</span>", E_USER_NOTICE);
    endif;
    ?>
</div>