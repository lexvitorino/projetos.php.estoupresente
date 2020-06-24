<?php
extract($viewData);
if (!empty($UsuarioData)):
    extract($UsuarioData);
endif;

$id_group = empty($id_group) ? 0 : $id_group;

$Read = new Read;
$Read->ExeRead(PERMISSION_GRUPO);
if ($Read->getResult()):
    $Grupos = $Read->getResult();
endif;
?>

<div class="ibox float-e-margins">
    <form method="POST">
        <div class="ibox-title">
            <input type="submit" name="SendPostForm" class="btn btn-w-m btn-primary" value="Salvar" />
            <a href="<?= BASE; ?>/usuario" class="btn btn-w-m btn-default">Voltar</a> 
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-12 b-r">
                    <div class="col-sm-12 form-group">
                        <label for="name">Nome</label>
                        <input type="text" name="name" class="form-control" value="<?= (!empty($name)) ? $name : ''; ?>" required/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="login">Login</label>
                        <input type="text" name="login" class="form-control" value="<?= (!empty($login)) ? $login : ''; ?>" required/>
                    </div>  

                    <div class="col-sm-3 form-group">
                        <label for="password">Senha</label>
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               title="Informe sua senha [ de 6 a 12 caracteres! ]" 
                               pattern=".{6,12}"/>
                    </div>

                    <div class="col-sm-3 form-group">
                        <label for="repassword">Repetir a senha</label>
                        <input type="password" 
                               name="repassword" 
                               class="form-control" 
                               title="Repita sua senha [ de 6 a 12 caracteres! ]" 
                               pattern=".{6,12}" />
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="login">Chave</label>
                        <input type="text" name="chave" class="form-control" value="<?= (!empty($chave)) ? $chave : ''; ?>" required/>
                    </div>

                    <div class="col-sm-6 form-group">
                        <label for="id_group">Grupo de Permissões</label>

                        <select name="id_group" class="form-control" required>
                            <option value="">Selecione um</option>
                            <?php foreach ($Grupos as $Grupo): ?>
                                <option value="<?= $Grupo['id'] ?>" <?= $Grupo['id'] == $id_group ? 'selected="selected"' : ''; ?>> <?= $Grupo['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-6 form-group">
                        <div class="i-checks">
                            <input type="checkbox" class="form-control" name="altera_senha" value="1" <?= $altera_senha == 1 ? 'checked' : ''; ?> />	
                            <label for="altera_senha">Alterar Senha</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form> 
</div>