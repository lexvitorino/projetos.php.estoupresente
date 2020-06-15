$(document).ready(function () {

    var area = $('.encargo').attr('data-id');
    var area = $('.area').attr('data-id');
    var supervisor = $('.supervisor').attr('data-id');
    var dirigente = $('.dirigente').attr('data-id');
    var dirigenteCrianca1 = $('.dirigenteCrianca1').attr('data-id');
    var dirigenteCrianca2 = $('.dirigenteCrianca').attr('data-id');
    var anfitriao = $('.anfitriao').attr('data-id');
    var auxiliar = $('.auxiliar').attr('data-id');
    var auxiliar1 = $('.auxiliar1').attr('data-id');
    var auxiliar2 = $('.auxiliar2').attr('data-id');
    var lider = $('.lider').attr('data-id');

    function getLideres() {
        encargo = $('.encargo').val();
        $.ajax({
            url: BASE + '/membro/getMembrosPorEncargo/' + encargo,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (lider == key ? ' selected="selected" ' : '') + '>' + value + '</option>';
                    }
                }
                $('.lider').html(html);
            }
        });
    }

    function getSupervisor() {
        idArea = (area && area > 0) ? area : $('.area').val();
        $.ajax({
            url: BASE + '/membro/getMembrosPorLiderEEncargo/' + idArea + '/Supervisor',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (supervisor == key ? ' selected="selected" ' : '') + '>' + value + '</option>';
                    }
                }
                $('.supervisor').html(html);
            }
        });
    }

    function getDirigente() {
        idSupervisor = (supervisor && supervisor > 0) ? supervisor : $('.supervisor').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getDirigentePorSupervisor/' + idSupervisor,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (dirigente == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.dirigente').html(html);
            }
        });
    }

    function getDirigenteCrianca1() {
        idSupervisor = (supervisor && supervisor > 0) ? supervisor : $('.supervisor').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getDirigentePorSupervisor/' + idSupervisor,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (dirigenteCrianca1 == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.dirigenteCrianca1').html(html);
            }
        });
    }

    function getDirigenteCrianca2() {
        idSupervisor = (supervisor && supervisor > 0) ? supervisor : $('.supervisor').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getDirigentePorSupervisor/' + idSupervisor,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (dirigenteCrianca2 == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.dirigenteCrianca2').html(html);
            }
        });
    }

    function getAnfitrioes() {
        idDirigente = (dirigente && dirigente > 0) ? dirigente : $('.dirigente').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getAnfitrioesPorDirigente/' + idDirigente,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (anfitriao == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.anfitriao').html(html);
            }
        });
    }

    function getAuxiliar() {
        idDirigente = (dirigente && dirigente > 0) ? dirigente : $('.dirigente').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getMembrosPorDirigente/' + idDirigente,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (auxiliar == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.auxiliar').html(html);
            }
        });
    }

    function getAuxiliar1() {
        idDirigente = (dirigente && dirigente > 0) ? dirigente : $('.dirigente').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getMembrosPorDirigente/' + idDirigente,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (auxiliar1 == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.auxiliar1').html(html);
            }
        });
    }

    function getAuxiliar2() {
        idDirigente = (dirigente && dirigente > 0) ? dirigente : $('.dirigente').val();
        var html = '';
        $.ajax({
            url: BASE + '/membro/getMembrosPorDirigente/' + idDirigente,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '<option value="">Selecione um</option>';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].nome;
                        html += '<option value="' + key + '"' + (auxiliar2 == key ? ' selected=selected ' : '') + '">' + value + '</option>';
                    }
                }
                $('.auxiliar2').html(html);
            }
        });
    }

    $(window).on('load', function () {
        var fclass = $('form');
        if (fclass.hasClass('f-celula')) {
            getSupervisor();
            getDirigente();
            getDirigenteCrianca1();
            getDirigenteCrianca2();
            getAnfitrioes();
            getAuxiliar();
            getAuxiliar1();
            getAuxiliar2();
        }
        
        if (fclass.hasClass('f-membro')) {
            getLideres();
        }
    });

    $('.encargo').on('change', function () {
        getLideres();
    });

    $('.area').on('change', function () {
        getSupervisor();
    });

    $('.supervisor').on('change', function () {
        getDirigente();
        getDirigenteCrianca1();
        getDirigenteCrianca2();
    });

    $('.dirigente').on('change', function () {
        getAnfitrioes();
        getAuxiliar();
        getAuxiliar1();
        getAuxiliar2();
    });

    $('.encargoSel').on('change', function () {
        encargoSel = $(this).val();
        $.ajax({
            url: BASE + '/membro/getEncargoSel/' + encargoSel,
            type: 'GET',
            success: function (data) {
                var url = document.URL;
                var page = url.indexOf('?page=');
                if(page>0){
                    location.href = document.URL.substring(0,page);;
                } else {
                    location.reload();
                }
            }
        });
    });

});

