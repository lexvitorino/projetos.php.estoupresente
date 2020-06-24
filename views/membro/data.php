<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($MembroData)):
    extract($MembroData);
endif;

if(empty($anfitriao)):
    $anfitriao = 'N';
endif;
if(empty($dirigente)):
    $dirigente = 'N';
endif;

?>

<div class="ibox float-e-margins">
    <form method="POST" class="f-membro">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/membro" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <div class="col-sm-12 form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= (!empty($nome)) ? $nome : ''; ?>" required/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="email">E-mail</label>
                        <input type="text" name="email" class="form-control" value="<?= (!empty($email)) ? $email : ''; ?>" />
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="email_copia">E-mail Cópia</label>
                        <input type="text" name="email_copia" class="form-control" value="<?= (!empty($email_copia)) ? $email_copia : ''; ?>" />
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="telefone">Telefone</label>
                        <input type="text" name="telefone" class="form-control" value="<?= (!empty($telefone)) ? $telefone : ''; ?>" data-mask="(99) 9999-9999"/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="celular">Celular</label>
                        <input type="text" name="celular" class="form-control" value="<?= (!empty($telefone)) ? $celular : ''; ?>" data-mask="(99) 9-9999-9999"/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="data_nascimento">Data Nasmimento</label>
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="date" class="form-control" name="data_nascimento" value="<?= (!empty($data_nascimento)) ? $data_nascimento : ''; ?>">
                        </div>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="id_group">Encargo</label>
                        <select name="encargo" class="form-control encargo" required>
                            <option value="">Selecione um</option>
                            <?php foreach (getEncargos() as $StatusId => $StatusName): ?>
                            <option value="<?= $StatusName; ?>" <?= ($StatusName == (empty($encargo) ? '' : $encargo)) ? 'selected="selected"' : ''; ?>> <?= Check::NomeProprio($StatusName); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="id_lider">Lider</label>
                        <select name="id_lider" class="form-control lider" required data-id="<?= (!empty($id_lider)) ? $id_lider : '0'; ?>">
                            <option value="">Selecione um</option>
                        </select>
                    </div>

                    <div class="col-sm-2 form-group">
                        <div class="i-checks">
                            <label for="anfitriao" >
                                <input type="checkbox" class="form-control" name="anfitriao" value="S" <?= $anfitriao=='S' ? 'checked' : ''; ?> />	
                                &nbsp;&nbsp;&nbsp;Anfitrião
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-2 form-group">
                        <div class="i-checks">
                            <label for="dirigente" >
                                <input type="checkbox" class="form-control" name="dirigente" value="S" <?= $dirigente=='S' ? 'checked' : ''; ?> />	
                                &nbsp;&nbsp;&nbsp;Dirigente
                            </label>
                        </div>
                    </div>              
                </div>
            </div>
        </div>
    </form>  
</div>