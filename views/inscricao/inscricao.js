$(document).ready(function () {

    var area = $('.area').attr('data-id');
    var supervisor = $('.supervisor').attr('data-id');
    var dirigente = $('.dirigente').attr('data-id');
    var tipoTransporte = $('#tipo_transporte').attr('data-id');
    var tipoAcomodacao = $('#tipo_acomodacao').attr('data-id');
    var disabled = $('#disabled')[0].innerHTML === '0' ? false : true;

    $('.area').on('change', function () {
        area = $(this).val();
        carregaSupervisores(area);
    });

    $('.supervisor').on('change', function () {
        area = $('.area').val();
        supervisor = $(this).val();
        carregaDirigentes(area, supervisor);
    });

    $(window).on('load', function () {
        carregaSupervisores(area);
        carregaDirigentes(area, supervisor);
        carregaPrecos();

        $('#modalExemplo').modal('show');
    });

    $('#tipo_transporte').on('change', function () {
        tipoTransporte = $(this).val();
        carregaPrecos();
    });

    $('#tipo_acomodacao').on('change', function () {
        tipoAcomodacao = $(this).val();
        carregaPrecos();
    });

    function carregaPrecos() {
		if (!tipoAcomodacao) { 
			tipoAcomodacao = 'Quarto';
		}
		
		var vlAcomodacao = 0;
		if (tipoAcomodacao === 'Tenda') {
			vlAcomodacao = 360;
		} else if (tipoAcomodacao === 'Barraca') {
			vlAcomodacao = 305;
		} else {
			vlAcomodacao = 360;
		}
		
		var vlOnibus = 0;
		if (tipoTransporte === 'Ônibus') {
			vlOnibus = 55;
		}
		
		$('#quarto').html('R$ ' + (tipoAcomodacao === 'Quarto' ? vlAcomodacao : 0) + ',00');
		$('#tenda').html('R$ ' + (tipoAcomodacao === 'Tenda' ? vlAcomodacao : 0) + ',00');
		$('#barraca').html('R$ ' + (tipoAcomodacao === 'Barraca' ? vlAcomodacao : 0) + ',00');
		$('#onibus').html('R$ ' + (tipoTransporte === 'Ônibus' ? vlOnibus : 0) + ',00');
        $('#total').html('R$ ' + (vlAcomodacao + vlOnibus) + ',00');
    }

    function carregaSupervisores(idArea) {
        $.ajax({
            url: BASE + '/inscricao/membros',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="" ' + (disabled ? 'disabled' : '') + '>Selecione um</option>';
                if (data && data.length > 0) {
                    var t = '';
                    data.forEach(e => {
                        if (e.area === idArea && t !== e.supervisor) {
                            html += '<option ' + (disabled ? 'disabled' : '') + ' value="' + e.supervisor + '"' + (supervisor == e.supervisor ? ' selected="selected" ' : '') + '>' + e.supervisor + '</option>';
                            t = e.supervisor;
                        }
                    });
                }
                $('.supervisor').html(html);
            }
        });
    }

    function carregaDirigentes(idArea, idSupervisor) {
        $.ajax({
            url: BASE + '/inscricao/membros',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="" ' + (disabled ? 'disabled' : '') + '>Selecione um</option>';
                html += '<option ' + (disabled ? 'disabled' : '') + ' value="Sou Supervisor"' + (dirigente == 'Sou Supervisor' ? ' selected="selected" ' : '') + '>Sou Supervisor</option>';
                if (data && data.length > 0) {
                    var t = '';
                    data.forEach(e => {
                        if (e.area === idArea && e.supervisor === idSupervisor && t !== e.dirigente) {
                            html += '<option ' + (disabled ? 'disabled' : '') + ' value="' + e.dirigente + '"' + (dirigente == e.dirigente ? ' selected="selected" ' : '') + '>' + e.dirigente + '</option>';
                            t = e.dirigente;
                        }
                    });
                }
                $('.dirigente').html(html);
            }
        });
    }
});

function printpage() {
    window.print()
}

