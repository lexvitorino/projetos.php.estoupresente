<?php
if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if (!empty($CelulaData)):
    extract($CelulaData);
endif;

$Areas = array();
$Read->ExeRead(MEMBRO, "WHERE encargo = :encargo ORDER BY nome ASC", "encargo=" . ENCARGO_AREA);
if ($Read->getResult()):
    $Areas = $Read->getResult();
endif;
?>

<div class="ibox float-e-margins">
    <form method="POST" class="f-celula">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/celula" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>

                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Dados</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-2"> Endereço</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-3"> Visualizar</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <div class="col-sm-12 form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" class="form-control" value="<?= (!empty($nome)) ? $nome : ''; ?>" required/>
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label for="id_area">Area</label>
                                        <select name="id_area" class="form-control area" data-id="<?= (!empty($id_area)) ? $id_area : '0'; ?>" required>
                                            <option value="">Selecione um</option>
                                            <?php foreach ($Areas as $item): ?>
                                                <option value="<?= $item['id'] ?>" <?= ($item['id'] == (empty($id_area) ? '' : $id_area)) ? 'selected="selected"' : ''; ?>> <?= $item['nome']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label for="id_supervisor">Supervisor</label>
                                        <select name="id_supervisor" class="form-control supervisor" data-id="<?= (!empty($id_supervisor)) ? $id_supervisor : '0'; ?>" required>
                                            <option value="">Selecione um supervisor de Área</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-8 form-group">
                                        <label for="id_dirigente">Dirigente</label>
                                        <select name="id_dirigente" class="form-control dirigente" data-id="<?= (!empty($id_dirigente)) ? $id_dirigente : '0'; ?>" required>
                                            <option value="">Selecione um supervisor</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-2 form-group">
                                        <label for="dia">Dia da Reunião</label>
                                        <input type="text" name="dia" class="form-control" value="<?= (!empty($dia)) ? $dia : ''; ?>" required/>
                                    </div>

                                    <div class="col-sm-2 form-group">
                                        <label for="horario">Horário</label>
                                        <input type="text" name="horario" class="form-control" value="<?= (!empty($horario)) ? $horario : ''; ?>" data-mask="99 hs" required/>
                                    </div>

                                    <input id="dirigenteCrianca1" type="hidden" name="id_dirigente_crianca_1" value="<?= (!empty($id_dirigente_crianca_1)) ? $id_dirigente_crianca_1 : '0'; ?>"/>
                                    <div class="col-sm-4 form-group">
                                        <label for="id_dirigente_crianca_1">Dirigente – CÉLULA DE CRIANÇA (1)</label>
                                        <select name="id_dirigente_crianca_1" class="form-control dirigenteCrianca1">
                                            <option value="">Selecione um supervisor</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="">Dirigente – CÉLULA DE CRIANÇA (2)</label>
                                        <select name="id_dirigente_crianca_2" class="form-control dirigenteCrianca2" data-id="<?= (!empty($id_dirigente_crianca_2)) ? $id_dirigente_crianca_2 : '0'; ?>">
                                            <option value="">Selecione um supervisor</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="id_anfitriao">Anfitrião</label>
                                        <select name="id_anfitriao" class="form-control anfitriao" data-id="<?= (!empty($id_anfitriao)) ? $id_anfitriao : '0'; ?>" required>
                                            <option value="">Selecione o dirigente da celula</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="id_auxiliar">Auxiliar</label>
                                        <select name="id_auxiliar" class="form-control auxiliar" data-id="<?= (!empty($id_auxiliar)) ? $id_auxiliar : '0'; ?>">
                                            <option value="">Selecione o dirigente da celula</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="id_auxiliar_treinamento_1">Auxiliar Treinamento 1</label>
                                        <select name="id_auxiliar_treinamento_1" class="form-control auxiliar1" data-id="<?= (!empty($id_auxiliar_treinamento_1)) ? $id_auxiliar_treinamento_1 : '0'; ?>">
                                            <option value="">Selecione o dirigente da celula</option>
                                        </select>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="id_auxiliar_treinamento_2">Auxiliar Treinamento 2</label>
                                        <select name="id_auxiliar_treinamento_2" class="form-control auxiliar2" data-id="<?= (!empty($id_auxiliar_treinamento_2)) ? $id_auxiliar_treinamento_2 : '0'; ?>">
                                            <option value="">Selecione o dirigente da celula</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-sm-4 form-group">
                                        <label for="cep">CEP</label>
                                        <input type="text" name="cep" class="form-control" value="<?= (!empty($cep)) ? $cep : ''; ?>" required/>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-sm-10 form-group">
                                        <label for="endereco">Endereco</label>
                                        <input type="text" name="endereco" class="form-control" value="<?= (!empty($endereco)) ? $endereco : ''; ?>" required/>
                                    </div>

                                    <div class="col-sm-2 form-group">
                                        <label for="numero">Número</label>
                                        <input type="text" name="numero" class="form-control" value="<?= (!empty($numero)) ? $numero : ''; ?>" required/>
                                    </div>

                                    <div class="col-sm-12 form-group">
                                        <label for="complemento">Complemento</label>
                                        <input type="text" name="complemento" class="form-control" value="<?= (!empty($complemento)) ? $complemento : ''; ?>"/>
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label for="bairro">Bairro</label>
                                        <input type="text" name="bairro" class="form-control" value="<?= (!empty($bairro)) ? $bairro : ''; ?>" required/>
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" name="cidade" class="form-control" value="<?= (!empty($cidade)) ? $cidade : ''; ?>" required/>
                                    </div>
                                </div>
                            </div>                            
                            <div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <div class="col-sm-6 form-group">
                                        <label for="id_auxiliar_treinamento_2">Habilitar/Desabilitar Colunas da Lista de Presença</label>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_tot_mensal" value="S" <?= $ver_tot_mensal == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_tot_mensal">Ver Total</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_ate11" value="S" <?= $ver_ate11 == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_ate11">Ver Até 11 anos</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_de12a14" value="S" <?= $ver_de12a14 == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_de12a14">Ver De 12 à 14</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_de15a17" value="S" <?= $ver_de15a17 == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_de15a17">Ver De 15 à 17</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_hs" value="S" <?= $ver_hs == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_hs">Ver Homens Solteiros</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_hc" value="S" <?= $ver_hc == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_hc">Ver Homens Casados</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_ms" value="S" <?= $ver_ms == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_ms">Ver Mulheres Solteiras</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ver_mc" value="S" <?= $ver_mc == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ver_mc">Ver Mulheres Casadas</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <label for="universidade">Sobre a célula</label>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" id="ativo" name="ativo" value="1" <?= $ativo == 1 ? 'checked' : ''; ?> />	
                                            <label for="ativo">É uma célula ativa</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="universidade" value="S" <?= $universidade == 'S' ? 'checked' : ''; ?> />	
                                            <label for="universidade">É uma célula universitária</label>
                                        </div>
                                        <div class="i-checks">
                                            <input type="checkbox" class="form-control" name="ge" value="S" <?= $ge == 'S' ? 'checked' : ''; ?> />	
                                            <label for="ge">É um grupo de evangelismo (GE)</label>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>                
                </div>
            </div>
        </div>          
    </form>      
</div>