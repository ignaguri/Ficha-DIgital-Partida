//var body = document.getElementsByTagName("body")[0];
$('body').load(document.getElementById('dni').focus());

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
})

//var btn_firstTime = document.getElementById("btn_firstTime");
$('#btn_firstTime').click(function () {
    $('#dni').hide();
    $('#dni')[0].value = '';
    $('#btn_firstTime').hide();
    var $newBtn = $('<button id="btn_2nd" class="btn btn-info btn-lg btn-block" type="button">Mi DNI ya está registrado</button>');
    $('#botones').append($newBtn);

    $('#btn_2nd').click(function () {
        $('#dni').show();
        $('#btn_firstTime').show();
        $('#btn_2nd').remove();
    })
})
