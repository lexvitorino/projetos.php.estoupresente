<?php
extract($viewData);

if (!$Celulas):
    echo Erro("<span class='al_center icon-notification'>Ainda não existem células lançados!</span>", E_USER_NOTICE);
endif;
?>

<?php if (!empty($Celulas)): ?>
    <div class="ibox-title">
        <h5>Gráficos do Ano</h5>
    </div>

    <div class="ibox-content">
        <form method="POST">
            <div class="col-sm-12 form-group">
                <label for="id_celula">Célula</label>
                <select name="id_celula" class="form-control">
                    <option value="">Selecione um</option>
                    <?php foreach ($Celulas as $item): ?>
                        <option value="<?= $item['id'] ?>" <?= ($item['id'] == (empty($_SESSION['id_celula']) ? '' : $_SESSION['id_celula'])) ? 'selected="selected"' : ''; ?>> <?= $item['nome']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input id="submit" name="SendPostFiltro" type="submit" class="btn btn-w-m btn-primary" value="Buscar"/>
        </form>   
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-content">
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <canvas id="grafic1"></canvas>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>    

<script type="text/javascript">
    var noAno = <?= json_encode($NoAno); ?>;
    var dataSets = <?= json_encode($DataSets); ?>;
</script>