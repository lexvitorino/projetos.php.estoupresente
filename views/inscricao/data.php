<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($InscricaoData)):
    extract($InscricaoData);
endif;

?>

<div id="disabled" style="display: none"><?= $disable ?></div>

<section id="top" class="mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 text-center">
		<img src="https://www.comuna.com.br/templates/rt_myriad/images/icons/logo-comuna.png" alt="" style="padding-top: 35px; background-color: #666666;">
            </div>
            <div class="col-lg-9 col-sm-6">
                <h1 class="display-4">Acamp Jovens Solteiros 2020</h1>
                <?php if (!empty($id)): ?>
                    <p class="lead"><span>Olá, <?= $nome ?> <?= $sobrenome ?></span> <span class="float-right border-bottom border-danger"><strong>INSCRIÇÂO Nº <?= $id ?></strong></span></p>
                <?php else: ?>
                    <p class="lead">Reserve já sua inscrição</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section> 

<div class="container">

    <?php if(!empty($Message)): ?>
        <div class="alert alert-<?= $Message[1]; ?>" role="alert">
          <?= $Message[0]; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>

        <div class="row">
            <div class="col-sm-12 form-group">
                <label for="email">E-mail</label>
                <input id="email" type="email" name="email" class="form-control form-control-sm" value="<?= (!empty($email)) ? $email : ''; ?>" required readonly/>
            </div>
        </div>

        <div class="row">                
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="nome">Nome</label>
                        <input id="nome" type="text" name="nome" class="form-control form-control-sm" value="<?= (!empty($nome)) ? $nome : ''; ?>" required autofocus <?= ($disable ? 'readonly' : '' ) ?>/>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="sobrenome">Sobrenome</label>
                        <input  id="sobrenome" type="text" name="sobrenome" class="form-control form-control-sm" value="<?= (!empty($sobrenome)) ? $sobrenome : ''; ?>" required <?= ($disable ? 'readonly' : '' ) ?>/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="rg">RG</label>
                        <input  id="rg" type="text" name="rg" class="form-control form-control-sm" value="<?= (!empty($rg)) ? $rg : ''; ?>" required <?= ($disable ? 'readonly' : '' ) ?>/>
                    </div>
                    <div class="col-sm-6 form-group">
                        <label for="data_nascimento">Data Nascimento</label>
                        <input id="data_nascimento" type="date" name="data_nascimento" class="form-control form-control-sm" value="<?= (!empty($data_nascimento)) ? $data_nascimento : ''; ?>" required <?= ($disable ? 'readonly' : '' ) ?>/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label for="sexo">Sexo</label>
                        <select id=""sexo name="sexo" class="form-control form-control-sm" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="" <?= ($disable ? 'disabled' : '' ) ?>>Selecione um</option>
                            <option value="Masculino" <?= ($disable ? 'disabled' : '' ) ?> <?= ('Masculino' == ((empty($sexo))?'':$sexo)) ? 'selected="selected"' : ''; ?>>Masculino</option>
                            <option value="Feminino" <?= ($disable ? 'disabled' : '' ) ?> <?= ('Feminino' == ((empty($sexo))?'':$sexo)) ? 'selected="selected"' : ''; ?>>Feminino</option>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="tipo_transporte">Tipo de Transporte</label>
                        <select id="tipo_transporte" name="tipo_transporte" class="form-control form-control-sm" data-id="<?= (!empty($tipo_transporte)) ? $tipo_transporte : ''; ?>" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="" <?= ($disable ? 'disabled' : '' ) ?>>Selecione um</option>
                            <?php foreach (getTipoTransporte() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($disable ? 'disabled' : '' ) ?> <?= ($StatusId == (empty($tipo_transporte) ? '' : $tipo_transporte)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-4 form-group">
                        <label for="tipo_acomodacao">Tipo de Acomodação</label>
                        <select id="tipo_acomodacao" name="tipo_acomodacao" class="form-control form-control-sm" data-id="<?= (!empty($tipo_acomodacao)) ? $tipo_acomodacao : 'Quarto'; ?>" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="" <?= ($disable ? 'disabled' : '' ) ?>>Selecione um</option>
                            <?php foreach (getTipoAcomodacao() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($disable ? 'disabled' : '' ) ?> <?= ($StatusId == (empty($tipo_acomodacao) ? '' : $tipo_acomodacao)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label for="id_area">Area</label>
                        <select id="id_area" name="id_area" class="form-control form-control-sm area" data-id="<?= (!empty($id_area)) ? $id_area : '0'; ?>" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="">Selecione um</option>
                            <?php foreach ($Areas as $item): ?>
                                <option value="<?= $item ?>" <?= ($disable ? 'disabled' : '' ) ?> <?= ($item == (empty($id_area) ? '' : $id_area)) ? 'selected="selected"' : ''; ?>> <?= $item; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="id_supervisor">Supervisor</label>
                        <select id="id_supervisor" name="id_supervisor" class="form-control form-control-sm supervisor" data-id="<?= (!empty($id_supervisor)) ? $id_supervisor : '0'; ?>" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="" <?= ($disable ? 'disabled' : '' ) ?>>Selecione um</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="dirigente">Dirigente</label>
                        <select id="dirigente" name="dirigente" class="form-control form-control-sm dirigente" data-id="<?= (!empty($dirigente)) ? $dirigente : '0'; ?>" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="" <?= ($disable ? 'disabled' : '' ) ?>>Selecione um</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="forma_pagamento">Forma de Pagamento</label>
                        <select id="forma_pagamento" name="forma_pagamento" class="form-control form-control-sm" required <?= ($disable ? 'readonly' : '' ) ?>>
                            <option value="" <?= ($disable ? 'disabled' : '' ) ?>>Selecione um</option>
                            <?php foreach (getFormaPagamento() as $StatusId => $StatusName): ?>
                                <option value="<?= $StatusId; ?>" <?= ($disable ? 'disabled' : '' ) ?> <?= ($StatusId == (empty($forma_pagamento) ? '' : $forma_pagamento)) ? 'selected="selected"' : ''; ?>> <?= $StatusName; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="card bg-danger">
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span>Quarto</span>
                                <span id="quarto" class="float-right">R$ 360,00</span>
                            </li>
                            <li class="list-group-item">
                                <span>Tenda</span>
                                <span id="tenda" class="float-right">R$ 360,00</span>
                            </li>
                            <li class="list-group-item">
                                <span>Barraca</span>
                                <span id="barraca" class="float-right">R$ 305,00</span>
                            </li>
                            <li class="list-group-item">
                                <span>Ônibus</span>
                                <span id="onibus" class="float-right">R$ 0,00</span>
                            </li>
                            <li class="list-group-item">
                                <span>Total</span>
                                <span id="total" class="float-right">R$ 360,00</span>
                            </li>
                          </ul>
                        </div>
                    </div>
                </div>      
                <input id="btnSubmit" type="submit" name="SendPostForm" class="btn btn-success btn-lg btn-block" value="Salvar" />
                <?php if(!empty($id)): ?>
                <a class="btn btn-success btn-lg btn-block mb-3" href="<?= BASE; ?>/inscricao/confirmacao/<?= $id; ?>">Imprimir</a>
                <?php endif; ?>
                <a class="btn btn-secondary btn-lg btn-block mb-3" href="<?= BASE; ?>/inscricao">Voltar</a>
            </div>
        </div>
    </form>
</div>