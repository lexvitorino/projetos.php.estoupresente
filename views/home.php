<?php
if (empty($Read)):
    $Read = new Read();
endif;

$Avisos = array();
$AvisosCount = 0;

$Read->ExeRead(AVISO, "WHERE  id_subscriber = :id_subscriber 
                       AND   (created_id_user = :idLogin OR id_membro = :idMembro OR publico = 'S') 
                       AND    ativo = 'S'
                       AND    inicio <= Now() 
                       AND    fim >= Now() 
                       ORDER BY inicio desc
                       LIMIT  10", "id_subscriber=" . SUBSCRIBER_ID . "&idLogin=" . USUARIO_ID . "&idMembro=" . MEMBRO_ID);
if ($Read->getResult()):
    $Avisos = $Read->getResult();
    $AvisosCount = $Read->getRowCount();
endif;

$Anexos = array();
$AnexosCount = 0;

$Read->FullRead("SELECT u.*, md.nome as membro
                 FROM   anexos u
                   LEFT JOIN membros md on md.id = u.id_membro
                 WHERE  u.id_subscriber = :id_subscriber 
                 AND    u.ativo = 'S'
                 ORDER BY u.created_date desc
                 LIMIT  10", "id_subscriber=" . SUBSCRIBER_ID);
if ($Read->getResult()):
    $Anexos = $Read->getResult();
    $AnexosCount = $Read->getRowCount();
endif;
?>

<div class="col-lg-12">
    <div class="ibox-content ibox-heading">
        <h3><i class="fa fa-envelope-o"></i> Novos Avisos</h3>
        <small><i class="fa fa-tim"></i> Você tem <?= $AvisosCount ?> mensagens.</small>
    </div>
    <div class="ibox-content">
        <div class="feed-activity-list">
            <?php
            foreach ($Avisos as $aviso):
                extract($aviso)
                ?>
                <div class="feed-element">
                    <div>
                        <small class="pull-right text-navy"><?= date('d/m/Y', strtotime($inicio)); ?></small>
                        <strong><?= $titulo; ?></strong>
                        <div><?= $mensagem; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <br/>
</div>

<div class="col-lg-12">
    <div class="ibox-content ibox-heading">
        <h3><i class="fa fa-floppy-o"></i> Novos Anexos</h3>
        <small><i class="fa fa-tim"></i> Você tem <?= $AnexosCount ?> anexos.</small>
    </div>
    <div class="ibox-content">
        <div class="feed-activity-list">
            <?php
            foreach ($Anexos as $anexo):
                extract($anexo)
                ?>
                <div class="feed-element">
                    <a href="_uploads/<?= $caminho; ?>" target="_blank">
                        <div>
                            <small class="pull-right text-navy"><?= date('d/m/Y', strtotime($created_date)); ?></small>
                            <strong>
                                <?php if ($tipo == 'application/msword'): ?>
                                    <i class="fa fa-file-word-o"></i>
                                <?php elseif ($tipo == 'application/pdf'): ?>
                                    <i class="fa fa-file-pdf-o"></i>
                                <?php else: ?>
                                    <i class="fa fa-file-o"></i>
                                <?php endif; ?>
                                &nbsp;&nbsp;&nbsp;<?= $nome ?>
                            </strong>
                            <div><?= $comentario ?></div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="col-lg-12">
    <br/>
</div>

<?php if (!empty($viewData["Celulas"])): ?>

    <?php
    foreach ($viewData["Celulas"] as $celula):
        extract($celula)
        ?>

        <div class="col-lg-4">
            <div class="ibox-title">
        <?= $celula ?> ( <?= date('d/m/Y', strtotime($data)); ?> )
            </div>
            <div class="ibox-content">
                <div>
                    <span>Encontro</span>
                    <small class="pull-right"><?= $encontro ?>/3</small>
                </div>
                <div class="progress progress-small">
                    <?php if ($encontro == 1): ?>
                        <div style="width: 33%;" class="progress-bar progress-bar-danger"></div>
                    <?php elseif ($encontro == 2): ?>
                        <div style="width: 66%;" class="progress-bar progress-bar-warning"></div>
                    <?php elseif ($encontro == 3): ?>
                        <div style="width: 100%;" class="progress-bar"></div>
                    <?php else: ?>
                        <div style="width: 0;" class="progress-bar"></div>
        <?php endif; ?>
                </div>

                <div>
                    <span>Exaltação</span>
                    <small class="pull-right"><?= $exaltacao ?>/3</small>
                </div>
                <div class="progress progress-small">
                    <?php if ($exaltacao == 1): ?>
                        <div style="width: 33%;" class="progress-bar progress-bar-danger"></div>
                    <?php elseif ($exaltacao == 2): ?>
                        <div style="width: 66%;" class="progress-bar progress-bar-warning"></div>
                    <?php elseif ($exaltacao == 3): ?>
                        <div style="width: 100%;" class="progress-bar"></div>
                    <?php else: ?>
                        <div style="width: 0%;" class="progress-bar"></div>
        <?php endif; ?>
                </div>

                <div>
                    <span>Edificação</span>
                    <small class="pull-right"><?= $edificacao ?>/3</small>
                </div>
                <div class="progress progress-small">
                    <?php if ($edificacao == 1): ?>
                        <div style="width: 33%;" class="progress-bar progress-bar-danger"></div>
                    <?php elseif ($edificacao == 2): ?>
                        <div style="width: 66%;" class="progress-bar progress-bar-warning"></div>
                    <?php elseif ($edificacao == 3): ?>
                        <div style="width: 100%;" class="progress-bar"></div>
                    <?php else: ?>
                        <div style="width: 0%;" class="progress-bar"></div>
        <?php endif; ?>
                </div>

                <div>
                    <span>Evangelismo</span>
                    <small class="pull-right"><?= $evangelismo ?>/3</small>
                </div>
                <div class="progress progress-small">
                    <?php if ($evangelismo == 1): ?>
                        <div style="width: 33%;" class="progress-bar progress-bar-danger"></div>
                    <?php elseif ($evangelismo == 2): ?>
                        <div style="width: 66%;" class="progress-bar progress-bar-warning"></div>
                    <?php elseif ($evangelismo == 3): ?>
                        <div style="width: 100%;" class="progress-bar"></div>
                    <?php else: ?>
                        <div style="width: 0%;" class="progress-bar"></div>
        <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

<?php endif; ?> 

<div class="col-lg-12">
    <br/>
</div>

<hr/>