// Funcion que se ejecuta para ver el mensaje de cargando
function espereshow ()
{
    $('.espere').fadeIn('fast');
    //cargarNotificaciones();
    // validaPausas();
}
//  Función que se ejecuta para ocultar el mensaje de cargando
function esperehide() {
    $('.espere').fadeOut('slow');
}

function quitarlista (datos) {
    espereshow ();
    var email = $("#email").val();
    if(email !== ''){
        $.ajax({
            url:"../php/unsubscribe.php",
            cache:false,
            type:"POST",
            data:"email="+email,
            success: function(datos){
                // alert("tipo " + datos);
                if(datos === ''){
                    esperehide();
                    swal({
                        title: "Error!",
                        text: "¡No se ha encontrado un usuario registrado con la dirección de correo digitada!",
                        type: "error",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#E25856"
                    },
                    function(){
                        $("#email").focus();
                        return;
                    });
                }
                else{
                    window.location = 'pausas_confirm.html';
                }
            }
        });
    }
    else{
        swal({
            title: "Error!",
            text: "¡Debe ingresar un correo electrónico valido!",
            type: "error",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#E25856"
        },
        function(){
            $("#email").focus();
            return;
        });
    }
}

$("#Aceptar").on("click", quitarlista);
$(document).on('ready', esperehide);