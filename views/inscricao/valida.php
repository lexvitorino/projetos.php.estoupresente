<?php

if (empty($Read)):
    $Read = new Read;
endif;

extract($viewData);
if(!empty($InscricaoData)):
    extract($InscricaoData);
endif;

?>
<section id="top" class="mb-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-sm-6 text-center">
                <img src="https://www.comuna.com.br/templates/rt_myriad/images/icons/logo-comuna.png" alt="" style="padding-top: 35px; background-color: #666666;">
            </div>
            <div class="col-lg-9 col-sm-6">
                <h1 class="display-4">Acamp Jovens Solteiros 2020</h1>
                <p class="lead">Reserve já sua inscrição</p>
            </div>
        </div>
    </div>
</section> 

<div class="container">

    <?php if(!empty($Message)): ?>
        <div class="alert alert-<?= $Message[1] ?>" role="alert">
          <?= $Message[0]; ?>
        </div>
    <?php endif; ?>

    <div class="row mb-3">
        <div class="col-lg-12">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (!empty($id)) ? $id : '0'; ?>"/>

                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input id="email" type="email" name="email" class="form-control form-control-lg" value="<?= (!empty($email)) ? $email : ''; ?>" required autofocus placeholder="E-mail"/>
                    </div>
                </div>

                <input type="submit" name="SendPostValid" class="btn btn-secondary btn-lg btn-block mb-3" value="Validar Inscrição" />
            </form>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <p class="card-text"><strong>Quarto:</strong> R$ 360,00</p>
                <p class="card-text"><strong>Tenda:</strong> R$ 360,00</p>
                <p class="card-text"><strong>Barraca:</strong> R$ 305,00</p>
                <p class="card-text"><strong>Ônibus:</strong> R$ 55,00</p>
              </div>
          </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <p class="card-text"><strong>Depósito</strong></p>
                <p class="card-text">Bradesco</p>
                <p class="card-text">Agência: 1495-8</p>
                <p class="card-text">Conta: 36.533-5</p>
                <p class="card-text">CNPJ: 08.316.293/0001-22</p>
                <p class="card-text"><strong>Cartão</strong></p>
                <p class="card-text">Somente na igreja</p>
              </div>
          </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <p class="card-text"><strong>Idade:</strong> Acima de 18 anos e solteiro</p>
                <p class="card-text"><strong>Data:</strong> 30 de abril a 03 de maio</p>
                <p class="card-text"><strong>Local:</strong> Acamp Jovens Solteiros 2020</p>
              </div>
          </div>
        </div>
    </div>
</div>

<div id="modalExemplo" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p><strong>Atenção....</strong></p>
        <p>não é permitido menores de 14 anos</p>
        <p>menores de 17 anos é necessário autorização assinada pelo responsável</p>
      </div>
    </div>
  </div>
</div>