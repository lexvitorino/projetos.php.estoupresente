<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($FichaVVitoriosaData)):
    extract($FichaVVitoriosaData);
endif;

$Areas = array();
$Read->ExeRead(MEMBRO, "WHERE encargo = :encargo ORDER BY nome ASC", "encargo=".ENCARGO_AREA);
if ($Read->getResult()):
    $Areas = $Read->getResult();
endif;

?>

<div class="ibox float-e-margins">
    <form method="POST" enctype="multipart/form-data">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/fichaVVitoriosa" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>

                    <div class="col-sm-12 form-group">
                        <label for="titulo">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= (!empty($nome)) ? $nome : ''; ?>" required/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="sexo">Sexo</label>
                        <select name="sexo" class="form-control" required>
                            <option value="">Selecione um</option>
                            <option value="M" <?= ('M' == ((empty($sexo))?'':$sexo)) ? 'selected="selected"' : ''; ?>>Masculino</option>
                            <option value="F" <?= ('F' == ((empty($sexo))?'':$sexo)) ? 'selected="selected"' : ''; ?>>Feminino</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="cadastro_para">Cadastro para</label>
                        <select name="cadastro_para" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getTipoVVitoriosa() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($cadastro_civil) ? '' : $cadastro_civil)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="id_area">Area</label>
                        <select name="id_area" class="form-control area" required>
                            <option value="">Selecione um</option>
                            <?php foreach ($Areas as $item): ?>
                                <option value="<?= $item['id'] ?>" <?= ($item['id'] == (empty($id_area) ? '' : $id_area)) ? 'selected="selected"' : ''; ?>> <?= $item['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="id_supervisor">Supervisor</label>
                        <select name="id_supervisor" class="form-control supervisor" required>
                            <option value="">Selecione um</option>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="id_dirigente">Dirigente</label>
                        <select name="id_dirigente" class="form-control lider" required>
                            <option value="">Selecione um</option>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="data_nascimento">Data de Nascimento</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="data_nascimento" value="<?= (!empty($data_nascimento)) ? $data_nascimento : ''; ?>" require>
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="estado_civil">Estado Civil</label>
                        <select name="estado_civil" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getEstadoCivil() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($StatusId == (empty($estado_civil) ? '' : $estado_civil)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="conjuge">Nome do Cônjuge</label>
                        <input type="text" name="conjuge" class="form-control" value="<?= (!empty($conjuge)) ? $conjuge : ''; ?>" />
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="cep">CEP</label>
                        <input type="text" name="cep" class="form-control" value="<?= (!empty($cep)) ? $cep : ''; ?>"/>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-sm-10 form-group">
                        <label for="endereco">Endereco</label>
                        <input type="text" name="endereco" class="form-control" value="<?= (!empty($endereco)) ? $endereco : ''; ?>"/>
                    </div>

                    <div class="col-sm-2 form-group">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" class="form-control" value="<?= (!empty($numero)) ? $numero : ''; ?>"/>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" class="form-control" value="<?= (!empty($complemento)) ? $complemento : ''; ?>"/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" class="form-control" value="<?= (!empty($bairro)) ? $bairro : ''; ?>"/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" class="form-control" value="<?= (!empty($cidade)) ? $cidade : ''; ?>"/>
                    </div>               
                </div>
            </div>
        </div>
    </form> 
</div>