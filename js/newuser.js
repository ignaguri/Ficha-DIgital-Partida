$( document ).ready(function() {
    $('#password2').keyup(function () {
        if($('#password').val() === $('#password2').val())
        {
            $('#password')[0].setCustomValidity('');
        }
        else
        {
            //$('#pwd_msg').val("Las contraseñas no son iguales.");
            $('#password')[0].setCustomValidity('Las contraseñas no son iguales.');
        }
    });
});

// Variable to hold request
var request;

// Bind to the submit event of our form
$("#form_persona").submit(function(event){

    // Prevent default posting of form - put here to work in case of errors
    event.preventDefault();

    // Abort any pending request
    if (request) {
        request.abort();
    }
    // setup some local variables
    var $form = $(this);

    // Let's select and cache all the fields
    var $inputs = $form.find("input, select, button, textarea");

    // Serialize the data in the form
    var serializedData = $form.serialize();

    // Let's disable the inputs for the duration of the Ajax request.
    // Note: we disable elements AFTER the form data has been serialized.
    // Disabled form elements will not be serialized.
    $inputs.prop("disabled", true);

    // Fire off the request to /form.php
    request = $.ajax({
        url: location.href,
        type: "post",
        data: serializedData
    });

/*    // Callback handler that will be called on success
    request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log("Hooray, it worked!");
    });

    // Callback handler that will be called on failure
    request.fail(function (jqXHR, textStatus, errorThrown){
        // Log the error to the console
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
    });*/

    // Callback handler that will be called regardless
    // if the request failed or succeeded
    request.always(function () {
        // Reenable the inputs
        $inputs.prop("disabled", false);
    });

});

/*
//TODO: usar .html's como templates en vez de strings eternos
function desea_continuar() {
    $('#form_persona').hide();

    $('#form-holder').load('templates/modal_continuar.html');

    $('#btn_no').click(function (e) {
        window.location.href = "<?php echo $_SERVER['PHP_SELF']; ?>" + "?status=loggedout";
    });
    $('#btn_si').click(function (e) {
        var rol = "<?php echo $_SESSION['rol']; ?>";
        //var persona = "<?php echo $_SESSION['persona']; ?>";
        nuevo_rol(rol);
    });
}

//TODO: cambiar llamadas a funcion por metodo
function nuevo_rol(rol) {
    switch (rol) {
        case 2:
            $('#opt_holder').remove();
            formulario_secre();
            break;
        case 3:
            $('#opt_holder').remove();
            formulario_padrino();
            break;
        case 4:
            $('#opt_holder').remove();
            formulario_partidista();
            break;
    }
}
function formulario_secre() {

/!*    var formulario = '<form id="form_secre" name="form_secre" class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER[\'PHP_SELF\']); ?>"> \
                    <label for="dni">DNI</label><input type="text" name="dni" id="dni" /> \
                    <br class="clear" /> \
                    <label for="comentarios">Comentarios</label><textarea name="comentarios" id="comentarios" cols="45" rows="5">\
                    </textarea><br class="clear" /></form>';*!/

    //$('#form-holder').append(formulario);
    $('#form-holder').load('templates/form_secre.html');
}
function formulario_padrino() {

/!*    var formulario = '<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER[\'PHP_SELF\']); ?>"> \
                    <label for="dni">DNI</label><input type="text" name="dni" id="dni" /> \
                    <br class="clear" /><label for="prepartida1">Prepartida1</label><input type="text" name="prepartida1" id="prepartida1" /> \
                    <br class="clear" /><label for="prepartida2">Prepartida2</label><input type="text" name="prepartida2" id="prepartida2" /> \
                    <br class="clear" /><label for="prepartida3">Prepartida3</label><input type="text" name="prepartida3" id="prepartida3" /> \
                    <br class="clear" /><label for="prepartida4">Prepartida4</label><input type="text" name="prepartida4" id="prepartida4" /> \
                    <br class="clear" /><label for="partida1">Partida1</label><input type="text" name="partida1" id="partida1" /> \
                    <br class="clear" /><label for="partida2">Partida2</label><input type="text" name="partida2" id="partida2" /> \
                    <br class="clear" /><label for="personalidad1">Personalidad1</label><input type="text" name="personalidad1" id="personalidad1" /> \
                    <br class="clear" /><label for="personalidad2">Personalidad2</label><input type="text" name="personalidad2" id="personalidad2" /> \
                    <br class="clear" /><label for="ambiente1">Ambiente1</label><input type="text" name="ambiente1" id="ambiente1" /> \
                    <br class="clear" /><label for="ambiente2">Ambiente2</label><input type="text" name="ambiente2" id="ambiente2" /> \
                    <br class="clear" /><label for="ambiente3">Ambiente3</label><input type="text" name="ambiente3" id="ambiente3" /> \
                    <br class="clear" /><label for="ambiente4">Ambiente4</label><input type="text" name="ambiente4" id="ambiente4" /> \
                    <br class="clear" /><label for="ambiente5">Ambiente5</label><input type="text" name="ambiente5" id="ambiente5" /> \
                    <br class="clear" /><label for="ambiente6">Ambiente6</label><input type="text" name="ambiente6" id="ambiente6" /> \
                    <br class="clear" /><label for="ambiente7">Ambiente7</label><input type="text" name="ambiente7" id="ambiente7" /> \
                    <br class="clear" /><label for="religiosidad1">Religiosidad1</label><input type="text" name="religiosidad1" id="religiosidad1" /> \
                    <br class="clear" /><label for="religiosidad2">Religiosidad2</label><input type="text" name="religiosidad2" id="religiosidad2" /> \
                    <br class="clear" /></form>';*!/
   // $('#form-holder').append(formulario);
    $('#form-holder').load('templates/form_padrino.html');
}
function formulario_partidista() {
/!*    var formulario = '<form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER[\'PHP_SELF\']); ?>"> \
                    <label for="dni">DNI</label><input type="text" name="dni" id="dni" /><br class="clear" /> \
                    <label for="apodo">Apodo</label><input type="text" name="apodo" id="apodo" /><br class="clear" /> \
                    <label for="facultad">Facultad</label><input type="text" name="facultad" id="facultad" /><br class="clear" /> \
                    <label for="serv_emergencia">Serv Emergencia</label><input type="text" name="serv_emergencia" id="serv_emergencia" /> \
                    <br class="clear" /><label for="aspecto_personal1">Aspecto Personal1</label><input type="text" name="aspecto_personal1" id="aspecto_personal1" /> \
                    <br class="clear" /><label for="aspecto_personal2">Aspecto Personal2</label><input type="text" name="aspecto_personal2" id="aspecto_personal2" /> \
                    <br class="clear" /><label for="aspecto_personal3">Aspecto Personal3</label><input type="text" name="aspecto_personal3" id="aspecto_personal3" /> \
                    <br class="clear" /><label for="aspecto_personal4">Aspecto Personal4</label><input type="text" name="aspecto_personal4" id="aspecto_personal4" /> \
                    <br class="clear" /><label for="aspecto_personal5">Aspecto Personal5</label><input type="text" name="aspecto_personal5" id="aspecto_personal5" /> \
                    <br class="clear" /><label for="relacion_con_demas1">Relacion Con Demas1</label><input type="text" name="relacion_con_demas1" id="relacion_con_demas1" /> \
                    <br class="clear" /><label for="relacion_con_demas2">Relacion Con Demas2</label><input type="text" name="relacion_con_demas2" id="relacion_con_demas2" /> \
                    <br class="clear" /><label for="relacion_con_demas3">Relacion Con Demas3</label><input type="text" name="relacion_con_demas3" id="relacion_con_demas3" /> \
                    <br class="clear" /><label for="relacion_con_demas4">Relacion Con Demas4</label><input type="text" name="relacion_con_demas4" id="relacion_con_demas4" /> \
                    <br class="clear" /><label for="relacion_con_demas5">Relacion Con Demas5</label><input type="text" name="relacion_con_demas5" id="relacion_con_demas5" /> \
                    <br class="clear" /><label for="relacion_con_demas6">Relacion Con Demas6</label><input type="text" name="relacion_con_demas6" id="relacion_con_demas6" /> \
                    <br class="clear" /><label for="relacion_con_dios1">Relacion Con Dios1</label><input type="text" name="relacion_con_dios1" id="relacion_con_dios1" /> \
                    <br class="clear" /><label for="relacion_con_dios2">Relacion Con Dios2</label><input type="text" name="relacion_con_dios2" id="relacion_con_dios2" /> \
                    <br class="clear" /><label for="relacion_con_dios3">Relacion Con Dios3</label><input type="text" name="relacion_con_dios3" id="relacion_con_dios3" /> \
                    <br class="clear" /><label for="relacion_con_dios4">Relacion Con Dios4</label><input type="text" name="relacion_con_dios4" id="relacion_con_dios4" /> \
                    <br class="clear" /><label for="relacion_con_dios5">Relacion Con Dios5</label><input type="text" name="relacion_con_dios5" id="relacion_con_dios5" /> \
                    <br class="clear" /><label for="relacion_con_dios6">Relacion Con Dios6</label><input type="text" name="relacion_con_dios6" id="relacion_con_dios6" /> \
                    <br class="clear" /><label for="relacion_con_dios7">Relacion Con Dios7</label><input type="text" name="relacion_con_dios7" id="relacion_con_dios7" /> \
                    <br class="clear" /></form>';*!/
 //   $('#form-holder').append(formulario);
    $('#form-holder').load('templates/form_partidista.html');
}
*/

/* leer variables php
 var val = "<?php echo $var ?>";
 */