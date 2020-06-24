<?php
extract($viewData['InscricaoData']);
?>

<div class="container mt-4">
    <div class="row mb-4">
        <div class="col-lg-6">
            <button class="btn btn-secondary btn-lg btn-block mb-3" onclick="printpage()">Imprimir</button>
        </div>
        <div class="col-lg-6">
            <a class="btn btn-success btn-lg btn-block mb-3" href="<?= BASE; ?>/inscricao">Voltar</a>
        </div>
    </div>
    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="row">
            <div class="col-lg-12">
                <h3>Ficha de Inscri&ccedil;&atilde;o N&ordm;  <?= $id ?>&nbsp;</h3>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="row">
            <div class="col-lg-12">
                <h5>Evento.: Acamp Jovens Solteiros 2020</h5>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="row">
            <div class="col-lg-12">
                <h6 style="color: red">Validade.: <?= date('d/m/Y', strtotime('+7 days', strtotime('today'))) ?></h6>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="row">
            <div class="col-lg-4">
                <p>E-mail.:  <?= $email ?></p>
                <p>Nome.:  <?= $nome ?></p>
                <p>Data de Nascimento.:  <?= date("d/m/Y", strtotime($data_nascimento)) ?></p>
            </div>
            <div class="col-lg-8">
                <p>RG.:  <?= $rg ?></p>
                <p>Sobrenome.: <?= $sobrenome ?></p>
                <p>Sexo.:  <?= $sexo ?></p>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="row">
            <div class="col-lg-4">
                Dirigente.:  <?= $dirigente ?>
            </div>
            <div class="col-lg-4">
                Supervidor.:  <?= $id_supervisor ?>
            </div>
            <div class="col-lg-4">
                &Aacute;rea.:  <?= $id_area ?>
            </div>
        </div>
    </div>
    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="row">
            <div class="col-lg-4">
                <p>Tipo de Transporte.:  <?= $tipo_transporte ?></p>
                <p>Forma de Pagamento.:  <?= $forma_pagamento ?></p>
            </div>
            <div class="col-lg-4">
                <p><span style='color:#ff0000;'>Quarto.: R$ <?= ($tipo_acomodacao == 'Quarto') ? '360,00' : '0,00'  ?></span></p>
                <p><span style='color:#ff0000;'>Tenda.: R$ <?= ($tipo_acomodacao == 'Tenda') ? '360,00' : '0,00'  ?></span></p>
                <p><span style='color:#ff0000;'>Barraca.: R$ <?= ($tipo_acomodacao == 'Barraca') ? '305,00' : '0,00'  ?></span></p>
                <p><span style='color:#ff0000;'>Ônibus.: R$ <?= ($tipo_transporte == 'Ônibus') ? '55,00' : '0,00'  ?></span></p>
		<?php
			if (!$tipo_acomodacao) { 
				$tipo_acomodacao = 'Quarto';
			}
			
			$vlAcomodacao = 0;
			if ($tipo_acomodacao === 'Tenda') {
				echo "<p><span style='color:#ff0000;'>Total.: R$ " . (360 + ($tipo_transporte == 'Ônibus' ? 55 : 0)) . ",00 </span></p>";
			} else if ($tipo_acomodacao === 'Barraca') {
				echo "<p><span style='color:#ff0000;'>Total.: R$ " . (305+ ($tipo_transporte == 'Ônibus' ? 55 : 0)) . ",00 </span></p>";
			} else {
				echo "<p><span style='color:#ff0000;'>Total.: R$ " . (360 + ($tipo_transporte == 'Ônibus' ? 55 : 0)) . ",00 </span></p>";
			}
		?>
            </div>
            <div class="col-lg-4">
                <?php if($forma_pagamento == 'Depósito'): ?>
                <p><strong>Deposito</strong></p>
                <p>Bradesco</p>
                <p>Agência: 1495-8</p>
                <p>Conta: 36.533-5</p>
                <p>CNPJ: 08.316.293/0001-22</p>
                <?php endif; ?>
                
                <?php if($forma_pagamento == 'Cartão'): ?>
                <p><strong>Cartão</strong></p>
                <p>Somente na igreja</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="card" style="padding: 6px 5px 5px 5px; border: 0px solid #fff;">
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <div class="row">
           <div class="col-lg-12">
                <p><strong>SUA INSCRIÇÃO NÃO ESTA EFETIVADA!!!</strong></p>
                <p><strong>Você precisa efetivar o pagamento no balcão de inscrição da igreja!</strong>.</p>
                <div class="clearfix">&nbsp;</div>
                <p><strong style="color: red;">Caso isso não aconteça sua inscrição será cancelada automaticamente!!!</strong></p>
           </div>
        </div>
    </div>      
    
    
    <?php 

    $dataNascimento = strtotime($data_nascimento);
    $dataAtual = strtotime(date("Y-m-d"));
    $difAnos = floor(abs($dataNascimento - $dataAtual) / (365*60*60*24));

    if($difAnos < 18): 
    ?>
    <div class="card" style="padding: 6px 5px 5px 5px">
        <div class="clearfix">&nbsp;</div>
        <div class="clearfix">&nbsp;</div>
        <div class="row">
           <div class="col-lg-12">
                <p>AUTORIZAÇÃO</p>
                <p>Eu, __________________________________________________________, <small>(Nome do responsável – Nome legível)</small> do RG n.º_______________________________________  <small>(RG do responsável)</small> responsável pelo menor __________________________________________________________ <small>(Nome do menor que vai ao acampamento)</small> portador do RG n.º_______________________________________ <small>(RG do menor)</small> sua ida ao</p> 
                <p class="text-center">Acampamento de  Adolescentes da Comunidade da Graça em Ermelino Matarazzo, que acontecerá na Estância Árvore da Vida, situado a Estrada <strong>Estância Árvore da Vida</strong>, sn - Estância Árvore da Vida, Sumaré - SP - acontecerá nos dias 
                <strong>28 a 30 de Junho de 2019</strong>.
                </p>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <p>São Paulo, ______ de   ___________________ de 2019.</p>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <div class="clearfix">&nbsp;</div>
                <p>--------------------------------------------------------------------------------------</p>
                <p>Assinatura do responsável</p>
           </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div id="modalExemplo" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <p><strong>Essa é uma pré inscrição!</strong></p>
        <p>É necessário você imprima essa pré inscrição e entregue na igreja para efetivar a sua vaga.</p>
      </div>
    </div>
  </div>
</div>