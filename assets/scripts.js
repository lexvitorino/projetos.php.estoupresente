$(document).ready(function () {

    if ((typeof msgToastr != 'undefined') && msgToastr !== '') {
        if (tipToastr === 'success') {
            toastr.success(titToastr, msgToastr);
        } else if (tipToastr === 'info') {
            toastr.info(titToastr, msgToastr);
        } else if (tipToastr === 'warning') {
            toastr.warning(titToastr, msgToastr);
        } else if (tipToastr === 'error') {
            toastr.error(titToastr, msgToastr);
        }
        msgToastr = '';
    }

    $.ajax({url: BASE + '/ajax/delAlert', type: 'POST'});

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    $('input[name=cep]').on('blur', function () {
        var cep = $(this).val();
        $.ajax({
            url: 'http://api.postmon.com.br/v1/cep/' + cep,
            type: 'GET',
            dataType: 'json',
            success: function (json) {
                if (typeof json.cep != 'undefined') {
                    $('input[name=endereco]').val(json.logradouro);
                    $('input[name=bairro]').val(json.bairro);
                    $('input[name=cidade]').val(json.cidade);
                    $('input[name=estado]').val(json.estado);
                }
            }
        });
    });

    $('.scroll_content').slimscroll({
        height: '200px'
    });

    $('.clockpicker').clockpicker();
    
    $('#datatables').DataTable();
    
});

