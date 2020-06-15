$(document).ready(function () {

    function getPermissionsIn() {
        var params = $('.permissao-sel-in').val();
        $.ajax({
            url: BASE + '/grupoPermissao/getPermissionByIds/' + params,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].name;
                        html += '<option value="' + key + '">' + value + '</option>';
                    }
                }
                $('.permissao-sel-out').append(html);
                $('.permissao-sel-in option').filter(function () {
                    return $.inArray(this.value, params) !== -1;
                }).remove();
            }
        });
    }

    function getPermissionsOut() {
        var params = $('.permissao-sel-out').val();
        $.ajax({
            url: BASE + '/grupoPermissao/getPermissionByIds/' + params,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                html = '';
                if (data && data.length > 0) {
                    for (var i in data) {
                        var key = data[i].id;
                        var value = data[i].name;
                        html += '<option value="' + key + '">' + value + '</option>';
                    }
                }
                $('.permissao-sel-in').append(html);
                $('.permissao-sel-out option').filter(function () {
                    return $.inArray(this.value, params) !== -1;
                }).remove();
            }
        });
    }

    $('.permissao-sel-in').on('dblclick', function () {
        getPermissionsIn();
    });

    $('.permissao-sel-out').on('dblclick', function () {
        getPermissionsOut();
    });

    $('.permissao-sel-in-click').on('click', function () {
        getPermissionsIn();
    });

    $('.permissao-sel-out-click').on('click', function () {
        getPermissionsOut();
    });

    $('.f-permissao').on('click', function () {
        var params = [];
        $(".permissao-sel-out option").each(function () {
            params.push($(this).val());
        });
        $('.permissao-sel').val(params);
    });

});

