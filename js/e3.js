// variables globales
var sess_id   = $("#user_id").val();
var sess_perf = $("#sess_user_perf").val();
var sess_mail = $("#sess_user_mail").val();
var sess_mod_1 = $("#perm_mod_1").val();
var sess_mod_2 = $("#perm_mod_2").val();
var sess_mod_3 = $("#perm_mod_3").val();
var sess_mod_4 = $("#perm_mod_4").val();
var sess_mod_5 = $("#perm_mod_5").val();
var sess_mod_6 = $("#perm_mod_6").val();
var sess_mod_7 = $("#perm_mod_7").val();
var sess_mod_8 = $("#perm_mod_8").val();
var sess_mod_9 = $("#perm_mod_9").val();

// if el usuario es el desarrollador del sistema inicia esta funcion
if(sess_perf === '1'){
    relojPausas();
}

// Funcion que se ejecuta para ver el mensaje de cargando
function espereshow ()
{
    $('.espere').fadeIn('fast');
    validaSession();
    //cargarNotificaciones();
    // validaPausas();
}
//  Función que se ejecuta para ocultar el mensaje de cargando
function esperehide() {
    $('.espere').fadeOut('slow');
}
// funcion que valida que el usuario que esta navegando no lo este haciendo en diferetes sitio simultaneamente
function validaSession(){
    $.ajax({
        url:"../php/sess_user.php",
        cache:false,
        type:"POST",
        success: function(datos){
            if(datos === ''){
                swal({
                    title: "Error!",
                    text: "¡La sessión actual se cerrará por inactividad!",
                    type: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#E25856"
                },
                function(){
                    window.location = '../';
                    return;
                });
            }
        }
    });
    // setTimeout(esperehide, 1000);
}
// funcion que valida que el usuario que esta navegando no lo este haciendo en diferetes sitio simultaneamente
function validaPausas(tipo){
    $.ajax({
        url:"../php/pausas_user.php",
        cache:false,
        type:"POST",
        data:"tipo="+tipo,
        success: function(datos){
            // alert("tipo " + datos);
            if(datos === ''){
                swal({
                    title: "Error!",
                    text: "¡No se ha enviado el recordatorio de la pausa activa!",
                    type: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#E25856"
                },
                function(){
                    window.location = './';
                    return;
                });
            }
            else{
                relojPausas();
                return;
            }
        }
    });
}
// funcion que se ejecuta al cargar la pagina y hace un bucle infinito por tiempo para recordar de las pausas activas
function relojPausas () {
    var msg = "No hace nada";
    // Inicializamos la variable por default sera un hora 3600000
    var time = 3600000;
    // Obtenemos la fecha actual
    var f = new Date();
    // obtenemos la hora actual en formato unix
    var cad = f.getTime();
    // determinamos la hora de inicio desde la cual se van a enviar las notificaciones de la pausa 1
    var hora0 = f.setHours(6, 55, 0, 0);
    // determinamos la hora maxima desde la cual se va a enviar las notificaciones de la pausa 1
    var hora1 = f.setHours(7, 0, 0, 0);
    // determinamos la hora inicial para la segunda pausa activa
    var hora2 = f.setHours(9, 25, 0, 0);
    // determinamos la hora limite para la segunda pausa activa
    var hora3= f.setHours(9, 30, 0, 0);
    // determinamos la hora inicial para la tercera y ultima pausa activa
    var hora4 = f.setHours(15, 25, 0, 0);
    // determinamos la hora limite para la tercera y ultima pausa activa
    var hora5 = f.setHours(15, 30, 0, 0);
    // si la hora actual es menor a la hora inicial de la primera pausa activa hace esto
    if(cad < hora0){
        time = parseInt(hora0 - cad);
    }
    // si la hora actual es mayor a la hora inicial y menor a la hora limite de la primera pausa activa hace esto
    else if((cad > hora0) && (cad < hora1)){
        validaPausas(1);
        time = parseInt(hora2 - cad);
    }
    // si la hora actual es mayor a la hora limite de la pausa 1 y menor a la hora inicial de la pausa 2 hace esto
    else if((cad > hora1) && (cad < hora2)){
        time = parseInt(hora2 - cad);
    }
    // si la hora actual es mayor a la hora inicial de la segunda pausa activa y menor a la hora limite de la segunda pausa activa hace esto
    else if((cad > hora2) && (cad < hora3)){
        validaPausas(2);
        time = parseInt(hora4 - cad);
    }
    // si la hora actual es mayor a la hora limite de la pausa 2 y menor a la hora inicial de la pausa 3 hace esto
    else if((cad > hora3) && (cad < hora4)){
        time = parseInt(hora4 - cad);
    }
    // si la hora actual es mayor a la hora inicial de la tercera pausa activa y menor a la hora limite de la tercera pausa activa hace esto
    else if((cad > hora4) && (cad < hora5)){
        validaPausas(3);
    }
    setTimeout(function(){relojPausas();}, time);
    // alert(msg + " siguiente en " + parseFloat(time / (1000 * 60)).toFixed(2) + " minutos");
}
// funcion que recarga las notificaciones de la parte izquierda
function cargarNotificaciones (argument) {
    $(".notifications").load("notificaciones.php");
}
//funcion para pre cargar la imagen seleccionada en campo tipo file imagen
function PreImagen(campo, e){
   var Lector, oFileInput = campo;
   if (oFileInput.files.length !== 0) {
      Lector = new FileReader();
      Lector.onloadend = function(e) {
         jQuery('#vistaPrevia').attr('src', e.target.result);
         jQuery('#vistaPrevia').attr('width', "200px");
         jQuery('#vistaPrevia').attr('height', "180px");          
         };
      Lector.readAsDataURL(oFileInput.files[0]);
   }      
}
// funcion que se dispara cuando se hace clic en ver, editar o eliminar contacto
function opcionContacto (datos){
    espereshow();
    var cont_id_div = $(this).parent('div').attr('id');
    var cont_id_part = cont_id_div.split("_");
    var cont_id = cont_id_part[1];
    var html_opc = $(this).children('i').attr("class");
    switch(html_opc){
        case "glyphicon glyphicon-remove":
            setTimeout(esperehide, 1000);
            swal({
                title: "¿Esta Seguro?",
                text: "Se borrará el registro # " + cont_id,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#F8BB86",
                confirmButtonText: "Eliminar!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url:"../php/ins_upd_user.php",
                    cache:false,
                    type:"POST",
                    data:"id_sup="+cont_id,
                    success: function(datos){
                        if(datos !== ''){
                            $("#col-md-12").load("./contactos.php?emp_id=" + sess_id + "&perm_mod=" + sess_mod_3);
                            swal({
                                title: "Eliminado!",
                                text: "El registro se ha eliminado correctamente!",
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#94B86E"
                            });
                        }
                        else{
                            swal({
                                title: "Error!",
                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                            return;
                        }
                    }
                });
            });
            $(".detalle_contacto").html('');
            $(".detalle_contacto").removeClass('btblue');
            $(".tr_cont").removeClass('btblue');
            setTimeout(esperehide, 1000);
            break;
        case "glyphicon glyphicon-eye-open":          
            $("#col-md-12").load("./cont_det.php?cont_id="+cont_id);
            break;
        case "glyphicon glyphicon-pencil":
            $("#col-md-12").load("./cont_det_ed.php?cont_id="+cont_id);
            break;
        default:
            break;
    }
}
// Funcion que se desplega al cargar el documento
function ed_cont(){
    $("#new_cont").on("click", newContacto);
    $("#new_cont").on("touch", newContacto);
    $('.opc_cont div span').on('click', opcionContacto);
    setTimeout(esperehide, 1000);
}
// al hacer clic en las opciones del menu
function opcMenu(){
    espereshow();
    $("#col-md-12").load("./calendario.php?emp_id="+sess_id);
    $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Calendario');
    // cambianos el background y color de la letra del titulo del menu calendario
    $("#menu_calendario").parent("li").css("background", "none repeat scroll 0 0 rgb(126, 126, 126)");
    $("#menu_calendario").parent("li").children("a").css("color", "#E6E6E6");
    // escuchamos el menu para que cuando se haga clic en uno de los items este habra la pagina correspondiente.
    $(".navi li a").on("click", mostrarPagina);
    $(".navi li a").on("touch", mostrarPagina);
    $(".content").on("click", ocultaMenu);
    $(".content").on("touch", ocultaMenu);
    // obtenemos el ancho de la pagina para cargar o no el div derecho con el contenido del calendario
    var anchopag = window.innerWidth;
    // si el ancho de la pagina es mayor a 767 se carga el calendario de lo contrario no carga nada
    if(anchopag > 767){
        $("#col-md-12").removeClass('hidden');
        $("#menushort").addClass('hidden');
        
    }
    // escuchamos el menu movil para que cuendo se haga clic en uno de los items este habra la pagina correspondiente.
    $(".menu_movil").on("click", cargarPagina);
    $(".menu_movil").on("touch", cargarPagina);
    // escuchamos la etiqueta a de la foto de la barra superior
    $("#foto_usu").on("click", verHojaVida);
    $("#foto_usu").on("touch", verHojaVida);
    // escuchamos la etiquela i de la barrasuperior que cierra la sesion
    $(".nom-usu > i").on("click", cerrarSession);
    $(".nom-usu > i").on("touch", cerrarSession);
    // Escuchamos el li del menu movil que cierrar la session
    $("#menu_movil_cerrar").on("click", cerrarSession);
    $("#menu_movil_cerrar").on("touch", cerrarSession);
    // Escuchamos el div del menu inicial en movil que cierra la session
    $("#menu_perfil_carrar").on("click", cerrarSession);
    $("#menu_perfil_carrar").on("touch", cerrarSession);
    $('#nav-cerrar').tooltip();
    $('#foto_usu').tooltip();
    $('.ver-nom').tooltip();
    $('#reglamento a').tooltip();
    var regla = $("#regla").val();
    if(regla !== ''){
        $("html").addClass('sin-scroll');
        $(".div-regla").removeClass('hidden');
        var temp_docs = regla.split(',');
        var num_docs = temp_docs.length;
        for(var i = 0; i < num_docs; i++){
            $(".div-regla").load("./terminos.php?doc_id="+temp_docs[i]);
            return;
        }
    }
    $(".notifications").load("notificaciones.php");
    $(".notifications li").on("click", mostrarEvento);
    $(".sidebar-title .glyphicon").on("click", ocultarMenuNotificacion);
}
// Funcion que se ejecuta al cargar la pagina de notificaciones
function cargaNotificaciones () {
    $(".notifications li").on("click", mostrarEvento);
}
// Oculta y muestra el menu de la parte izquierda o las notificaciones de la parte izquierda
function ocultarMenuNotificacion (argument) {
    var nom_ul = $(this).attr('name');
    $("."+nom_ul).toggleClass('collapse');
    if($(this).hasClass('glyphicon-resize-small')){
        $(this).removeClass('glyphicon-resize-small');
        $(this).addClass('glyphicon-resize-full');
    }
    else{
        $(this).removeClass('glyphicon-resize-full');
        $(this).addClass('glyphicon-resize-small');
    }
}
// mostrar la pagina segun ela opcion del menu
function mostrarPagina(datos){
    $(".sidebar ul.navi li").css("background", "");
    $(".sidebar ul.navi li > a").css("color", "");
    $(this).parent("li").css("background", "none repeat scroll 0 0 rgb(126, 126, 126)");
    $(this).css("color", "#E6E6E6");
    $("#col-md-12").removeClass('btblue');
    var carp = $(this).attr("id");
    var pag = $(this).attr("name");
    if(pag.length){
        espereshow();
        if((pag !== 'solic')&&(pag !== 'rrhh')&&(pag !== 'ingreso')&&(pag !== 'emp_list_inactivo')){$("#rrhh").hide();}
        else if((pag !== 'reg_lab')&&(pag !== 'reg_pol')&&(pag !== 'reg_man')&&(pag !== 'reg_pau')){$("#reglamento").hide();}
        else{
            $("#rrhh").hide();
            $("#reglamento").hide();
            $("#pausas").hide();
            $(this).closest('li').css("background", "none repeat scroll 0 0 rgb(126, 126, 126)");
            $(this).closest('li').children("a").css("color", "#E6E6E6");
        }
        var dataget = "?emp_id="+sess_id+"&div_panel=calendario";
        // si el perfil de usuario es secretaria 3, administrador 4 o empleado 5
        if((sess_perf === '3') || (sess_perf === '4') || (sess_perf === '5')){
            if(pag === 'rrhh'){
                pag = "emp_det_temp";
            }
            else if(pag === 'solic'){
                pag = "solic_det_ed";
            }
            else if(pag === 'ingreso'){
                pag = "ing_reporte";
            }
            else if(pag === 'contactos'){
                dataget = dataget + "&perm_mod="+sess_mod_3;
            }
        }
        else{
            if(pag === 'rrhh'){
                dataget = dataget + "&perm_mod="+sess_mod_1;
            }
            else if(pag === 'calendario'){
                dataget = dataget + "&perm_mod="+sess_mod_2;
            }
            else if(pag === 'contactos'){
                dataget = dataget + "&perm_mod="+sess_mod_3;
            }
            else if(pag === 'inventario'){
                dataget = dataget + "&perm_mod="+sess_mod_4;
            }
            else if(pag === 'biblioteca'){
                dataget = dataget + "&perm_mod="+sess_mod_5;
            }
            else if(pag === 'correo'){
                dataget = dataget + "&perm_mod="+sess_mod_6;
            }
            else if(pag === 'chat'){
                dataget = dataget + "&perm_mod="+sess_mod_7;
            }
            else if(pag === 'configuracion'){
                dataget = dataget + "&perm_mod="+sess_mod_8;
            }
        }
        if(pag === 'pausas'){
            dataget = dataget + "&perm_mod="+sess_mod_8+"&dir="+carp;
        }
        $("#col-md-12").load("./" + pag + ".php"+dataget);
    }
    else{
        // $(".submenuizq").hide();
        $(this).parent("li").children('ul').toggle();
        setTimeout(esperehide, 1000);
    }
    $("#col-md-12").removeClass('hidden');
    $("#menushort").addClass('hidden');
    // Validamos el tipo de pagina para colocar el nombre en el mapa del sitio
    // si la pagina es empleados hace esto
    if(pag == 'rrhh'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Empleados');
    }
    // si la pagina es solicitudes hace esto
    if(pag == 'solic'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Solicitudes');
    }
    // si la pagina es ingresos hace esto
    if(pag == 'ingreso'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Ingresos');
    }
    // si la pagina es ingresos hace esto
    if(pag == 'emp_list_inactivo'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Empleados Inactivos');
    }
    // si la pagina es reglamento laboral hace esto
    if(pag == 'reg_lab'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Reglamento<span class="divider">></span>Laboral');
    }
    // si la pagina es Politicas hace esto
    if(pag == 'reg_pol'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Reglamento<span class="divider">></span>Politicas');
    }
    // si la pagina es pausas activas hace esto
    if(pag == 'pausas'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Pausas Activas<span class="divider">></span>Tronco');
    }
    // si la pagina es biblioteca hace esto
    if(pag == 'biblioteca'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Biblioteca');
    }
    // si la pagina es Calendartio hace esto
    if(pag == 'calendario'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Calendario');
    }
    // si la pagina es configuracion hace esto
    if(pag == 'configuracion'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Configuración');
    }
    // si la pagina es contactos hace esto
    if(pag == 'contactos'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Contactos');
    }
    // si la pagina es ver hoja de vida hace esto
    if(pag == 'emp_det_temp'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Hoja de Vida');
    }
    // si la pagina es cambiar contraseña hace esto
    if(pag == 'emp_det_passwd'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Cambiar Contraseña');
    }
}
// mostrar la pagina segun ela opcion del menu
function cargarPagina(datos){
    espereshow();
    $(".sidebar ul.navi li").css("background", "");
    $(".sidebar ul.navi li > a").css("color", "");
    $("#rrhh").hide();
    $("#reglamento").hide();
    $("#pausas").hide();
    var carp = $(this).attr("name");
    var pag = $(this).attr("href");
    var pagi = pag.split('#');
    var pagina = pagi[1];
    $("#col-md-12").removeClass('btblue');
    if(pagina.length){
        var dataget = "?emp_id="+sess_id+"&div_panel=calendario";
        // si el perfil de usuario es secretaria 3, administrador 4 o empleado 5
        if((sess_perf === '3') || (sess_perf === '4') || (sess_perf === '5')){
            if(pagina === 'rrhh'){
                pagina = "emp_det_temp";
            }
            else if(pagina === 'solic'){
                pagina = "solic_det_ed";
            }
            else if(pagina === 'ingreso'){
                pagina = "ing_reporte";
            }
            else if(pagina === 'contactos'){
                dataget = dataget + "&perm_mod="+sess_mod_3;
            }
        }
        else{
            if(pagina === 'rrhh'){
                dataget = dataget + "&perm_mod="+sess_mod_1;
            }
            else if(pagina === 'calendario'){
                dataget = dataget + "&perm_mod="+sess_mod_2;
            }
            else if(pagina === 'contactos'){
                dataget = dataget + "&perm_mod="+sess_mod_3;
            }
            else if(pagina === 'inventario'){
                dataget = dataget + "&perm_mod="+sess_mod_4;
            }
            else if(pagina === 'biblioteca'){
                dataget = dataget + "&perm_mod="+sess_mod_5;
            }
            else if(pagina === 'correo'){
                dataget = dataget + "&perm_mod="+sess_mod_6;
            }
            else if(pagina === 'chat'){
                dataget = dataget + "&perm_mod="+sess_mod_7;
            }
            else if(pagina === 'configuracion'){
                dataget = dataget + "&perm_mod="+sess_mod_8;
            }
        }
        if(pagina === 'pausas'){
            dataget = dataget + "&perm_mod="+sess_mod_3+"&dir="+carp;
        }
        $("#col-md-12").load("./" + pagina + ".php"+dataget);
    }
    else{
        setTimeout(esperehide, 1000);
    }
    $("#col-md-12").removeClass('hidden');
    $("#menushort").addClass('hidden');
    $("nav").removeClass('in');
    // Validamos el tipo de pagina para colocar el nombre en el mapa del sitio

    // si la pagina es empleados hace esto
    if(pagina == 'rrhh'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Empleados');
    }
    // si la pagina es solicitudes hace esto
    if(pagina == 'solic'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Solicitudes');
    }
    // si la pagina es ingresos hace esto
    if(pagina == 'ingreso'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Ingresos');
    }
    // si la pagina es ingresos hace esto
    if(pagina == 'emp_list_inactivo'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Recursos Humanos<span class="divider">></span>Empleados Inactivos');
    }
    // si la pagina es reglamento laboral hace esto
    if(pagina == 'reg_lab'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Reglamento<span class="divider">></span>Laboral');
    }
    // si la pagina es Politicas hace esto
    if(pagina == 'reg_pol'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Reglamento<span class="divider">></span>Politicas');
    }
    // si la pagina es pausas activas hace esto
    if(pagina == 'pausas'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Pausas Activas<span class="divider">></span>Tronco');
    }
    // si la pagina es biblioteca hace esto
    if(pagina == 'biblioteca'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Biblioteca');
    }
    // si la pagina es Calendartio hace esto
    if(pagina == 'calendario'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Calendario');
    }
    // si la pagina es configuracion hace esto
    if(pagina == 'configuracion'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Configuración');
    }
    // si la pagina es contactos hace esto
    if(pagina == 'contactos'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Contactos');
    }
    // si la pagina es ver hoja de vida hace esto
    if(pagina == 'emp_det_temp'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Hoja de Vida');
    }
    // si la pagina es cambiar contraseña hace esto
    if(pagina == 'emp_det_passwd'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Cambiar Contraseña');
    }
    // si la pagina es contactos hace esto
    if(pagina == 'cont_det_ed'){
        $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Contactos');
    }
}
// funcion que se ejecuta al hacer click en una notificacion del menu izquierdo
function mostrarEvento (datos) {
    var id = $(this).attr('name');
    var user = $(this).attr('li-user');
    if(user === sess_id){
        var esto = $(this);
        swal({
            title: "¿Que desea hacer?",
            text: "Eliminar el evento o editarlo",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Eliminar",
            confirmButtonColor: "#F89406",
            confirmButtonText: "Editar!",
            closeOnConfirm: true
        },
        function(isConfirm){
            if (isConfirm) {
                $(".ing-cal").load("cal_evento.php?id="+id);
                $(".ing-cal").removeClass('hidden');
            }
            else {
                $(esto).remove();
                $.ajax({
                    url:"../php/ins_upd_cal.php",
                    cache:false,
                    type:"POST",
                    data:"id_sup="+id,
                    success: function(datos){
                        if(datos !== ''){
                            swal({
                                title: "Felicidades!",
                                text: "El registro se ha eliminado correctamente!",
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#94B86E"
                            });
                        }
                        else{
                            swal({
                                title: "Error!",
                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                            return;
                        }
                        $("#col-md-12").load("./calendario.php?emp_id="+sess_id);
                    }
                });
            }
        });
    }
    else{
        $(".ing-cal").load("cal_ver_evento.php?id="+id);
        $(".ing-cal").removeClass('hidden');
    }
}
// Funcion que muestra la hoja de vida al hacer click en la foto
function verHojaVida (datos) {
    espereshow();
    $(".sidebar ul.navi li").css("background", "");
    $(".sidebar ul.navi li > a").css("color", "");
    $("#rrhh").hide();
    $("#reglamento").hide();
    $("#pausas").hide();
    $("#col-md-12").addClass('btblue');
    $("#col-md-12").load("./emp_det_temp.php?div_panel=index&emp_id="+sess_id);
    $("#col-md-12").removeClass('hidden');
    $("#menushort").addClass('hidden');
    $("nav").removeClass('in');
    // si la pagina es ver hoja de vida hace esto
    $('.bread-crumb').html('<a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a><span class="divider">></span>Hoja de Vida');
}
// Funcion que cierra la session al hacer click en la x de la barra superior
function cerrarSession (datos) {
    var nom_usu = $('.ver-nom').html();
    swal({
        title: "¿Esta Seguro?",
        text: "Se cerrará la sessión",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#F8BB86",
        confirmButtonText: "Cerrar!",
        closeOnConfirm: false
    },
    function(){
        $.ajax({
            url:"../cerrar.php",
            cache:false,
            type:"POST",
            data:"",
            success: function(datos){
                if(datos){
                    swal({
                        title: "¡Hasta pronto "+ nom_usu +"!",
                        text: "Gracias por su visita!",
                        type: "success",
                        confirmButtonText: "Continuar",
                        confirmButtonColor: "#94B86E"
                    },
                    function(){
                        window.location = "../";
                    });
                }
            }
        });
    });
}
// Funcion que oculta el menu del titulo cuando se hace clic en otra parte de la pagina
function ocultaMenu (datos) {
    $(".bs-navbar-collapse").removeClass('in');
}
// Funcion que se desplega al cargar el documento
function ins_cont(){
    $(".sidebar-search .input-box span input").on("keyup", buscarContacto);
    $(".submit").on("click", buscarContacto);
    setTimeout(esperehide, 1000);
}
// funcion que se dispara cuando se hace clic en ver, editar o eliminar contacto
function newContacto(datos){
    espereshow();
    $("#col-md-12").load("./cont_det_ed.php");
}
// Funcion que se ejecuta para hacer una busqueda por termino y devuelve la lista con el resultado.
function buscarContacto(datos){
    var texto = $(this).val();
    var val = encodeURIComponent(texto);
    if(texto.length > 0)
    {
        $("#contenido_lista").load("./cont_list.php?text_bus="+val);
    }
    else
    {
        $("#contenido_lista").load("./cont_list.php");
    }
}
// Funcion que se desplega al cargar el documento
function ver_cont(){
    // escucha los titulos de bloque para mostrarlos u ocultarlos
    $(".widget-head").on("click", mostrarOtros);
    $(".btn-lg").on("click", regresarLista);
    $(".btn").on("click", regresarLista);
    // al seleccionar un valor en los select realiza una funcion
    $("#e3_tcont_id").on("change", cambioTipoPersona);
    $("#e3_tper_id").on("change", cambioTipoPersona);
    $("#e3_user_id").on("change", datosContactoPadre);
    $("#e3_user_nom").on("blur", buscarContactoExiste);
    $("#e3_user_ape").on("blur", buscarContactoExiste);
    $("#e3_user_tel").on("blur", buscarContactoExiste);
    $("#e3_user_cel").on("blur", buscarContactoExiste);
    $("#e3_user_email").on("blur", buscarContactoExiste);
    $("#e3_user_email2").on("blur", buscarContactoExiste);
    $('#e3_cal_emp_0').on("click", marcarEmpresas);
    cambioTipoPersona();
}
// funcion que se ejecuta al hacer clic en el titulo de mostrar Otros Datos
function mostrarOtros(datos){
    var nom_div = $(this).attr('name');
    $("#"+nom_div).toggleClass('widget-content');
    var class_icon = $(this).attr("class");
    var icono_acord = $(this).children("h4").children("i");
    if($(icono_acord).attr("class") == "glyphicon glyphicon-chevron-up")
    {
        icono_acord.removeClass("glyphicon glyphicon-chevron-up");
        icono_acord.addClass("glyphicon glyphicon-chevron-down");
    }
    else
    {
        icono_acord.removeClass("glyphicon glyphicon-chevron-down");
        icono_acord.addClass("glyphicon glyphicon-chevron-up");
    }
    return;
}
// al seleccionar el tipo de contacto en contactos
function cambioTipoPersona(datos){
    var tipocontacto = $("#e3_tcont_id").val();
    if(tipocontacto !== '2')
    {
        $("#e3_tper_id").parent("div").parent("div").css("display", "");
        $("#content_other").toggleClass('widget-content');
        $("#e3_perf_id").parent("div").html('<input id="e3_perf_id" type="hidden" name="e3_perf_id" value="6">Contacto');
        $("#e3_user_fnac").parent("div").parent("div").css("display", "none");
        $("#e3_carg_id").parent("div").parent("div").css("display", "none");
        $("#e3_area_id").parent("div").parent("div").css("display", "none");
        $("#e3_user_emerg_nom").parent("div").parent("div").css("display", "none");
        $("#e3_user_emerg_tel").parent("div").parent("div").css("display", "none");
        $("#content_other").toggleClass('widget-content');
        var tipopersona = $("#e3_tper_id").val();
        // si el tipo de persona es juridica hace esto
        if(tipopersona == '2')
        {
            /* Datos Basicos */
            $("label[for='e3_user_nom']").html("Razón Social: ");
            $("#e3_user_nom").attr("placeholder", "Razón Social");
            $("#e3_user_ape").parent("div").parent("div").css("display", "none");
            /* Asignar a otro contacto */
            $("#content_other-asig").toggleClass('widget-content');
            $("#e3_user_pad").parent("div").parent("div").css("display", "none");
            $("#content_other-asig").toggleClass('widget-content');
        }
        // si es persona natural hace esto
        else
        {
            $("label[for='e3_user_nom']").html("Nombre(s): ");
            $("#e3_user_nom").attr("placeholder", "Nombre(s)");
            $("#e3_user_ape").parent("div").parent("div").css("display", "");
            /* Asignar a otro contacto */
            $("#content_other-asig").toggleClass('widget-content');
            $("#e3_user_id").parent("div").parent("div").css("display", "inline-block");
            $("#content_other-asig").toggleClass('widget-content');
        }
    }
    else
    {
        $("#e3_tper_id").parent("div").parent("div").css("display", "none");
        $("label[for='e3_user_nom']").html("Nombre(s): ");
        $("#e3_user_nom").attr("placeholder", "Nombre(s)");
        $("#e3_user_ape").parent("div").parent("div").css("display", "block");
        /* Otros Datos*/
        $("#content_other").toggleClass('widget-content');
        $("#e3_perf_id").parent("div").parent("div").css("display", "block");
        $("#e3_user_fnac").parent("div").parent("div").css("display", "block");
        $("#e3_user_public").parent("div").parent("div").css("display", "none");
        $("#e3_carg_id").parent("div").parent("div").css("display", "block");
        $("#e3_area_id").parent("div").parent("div").css("display", "block");
        $("#e3_user_emerg_nom").parent("div").parent("div").css("display", "block");
        $("#e3_user_emerg_tel").parent("div").parent("div").css("display", "block");
        $("#content_other").toggleClass('widget-content');
        /* Asignar a otro contacto */
        $("#content_other-asig").toggleClass('widget-content');
        $("#e3_user_pad").parent("div").parent("div").css("display", "none");
        $("#content_other-asig").toggleClass('widget-content');
    }
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta cuando se selecciona un contacto para ser padre de otro
function datosContactoPadre(datos){
    espereshow();
    var id_cont = $(this).val();
    //Trer los datos del contacto padre y los dibujamos en el campo correspondiente
    $.ajax({
        url:"../php/val_cont.php",
        cache:false,
        type:"POST",
        data:"id_cont="+id_cont,
        success: function(datos){
            if(datos !== ''){
                user = datos.split(",");
                if(user[4] == '2')
                {
                    var label_nom_user = "<dt>Razón Social: </dt>";
                    var dat_nom_user = "<dd>" + user[0] + "</dd>";
                }
                else
                {
                    var label_nom_user = "<dt>Nombre(s) y Apellido(s): </dt>";
                    var dat_nom_user = "<dd>" + user[0]+ " " + user[1] + "</dd>";
                }
                $("#datos_padre").removeClass('widget-content');
                $("#datos_padre").append(label_nom_user);
                $("#datos_padre").append(dat_nom_user);
                if(user[3] !== '')
                {
                    $("#datos_padre").append('<dt>Teléfono fijo: </dt>');
                    $("#datos_padre").append('<dd>' + user[3] + '</dd>');
                }
                if(user[3] !== '')
                {
                    $("#datos_padre").append('<dt>Email principal: </dt>');
                    $("#datos_padre").append('<dd>' + user[2] + '</dd>');
                }
            }
            else{
                swal({
                    title: "Error!",
                    text: "Contacto no encontrado!",
                    type: "error",
                    confirmButtonText: "Aceptar",
                    confirmButtonColor: "#E25856"
                });
                return;
            }
        }
    });
    setTimeout(esperehide, 1000);
}
// Buscar un contacto por nombre, apellido, tel, cel, email o email2
function buscarContactoExiste(datos){
    espereshow();
    var texto = $(this).val();
    if(texto.length > 3)
    {
        // funcion que se activa al digitar una palabra en los campos del formulario de nuevo contacto
        //Trer los datos del contacto padre y los dibujamos en el campo correspondiente
        $.ajax({
            url:"../php/val_cont_existe.php",
            cache:false,
            type:"POST",
            data:"texto="+texto,
            success: function(datos){
                if(datos !== ''){
                    var mostrar_datos = "Existen contactos con datos similares a los digitados:\n";
                    users = datos.split("|");
                    for (var i = 0; i < users.length; i++) {
                        datos_user = users[i].split(",");
                        for (var j = 0; j < datos_user.length; j++) {
                            if(datos_user[j] !== '')
                            {
                                mostrar_datos += datos_user[j] + "\n";
                            }
                        }
                        mostrar_datos += "\n";
                    }                    
                    swal({
                        title: "Error!",
                        text: mostrar_datos,
                        type: "error",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#E25856"
                    });
                }
            }
        });
    }
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta al hacer click en el boton de regresar del detalle del contacto
function regresarLista (datos) {
    espereshow();
    $("#col-md-12").load("./contactos.php?emp_id=" + sess_id + "&perm_mod=" + sess_mod_3);
}
// funcion que se ejecuta al hacer clic en el boton ingresar / actualizar en contactos
function insertUpdate(){
    var campo = datos[0];
    //alert(campo);
    return;
}
// Se inicia al entrar en la pagina de configuracion
function cargaConfig(){
    $(".btn-block").on("click", mostrarLista);
    $(".btn-block").on("touch", mostrarLista);
    setTimeout(esperehide, 1000);
}
// Funcion que carga la lista de registros de la tabla indicada
function mostrarLista (datos) {
    espereshow();
    var tabla = encodeURIComponent($(this).attr('name'));
    var titulo = encodeURIComponent($(this).html());
    $("#col-md-12").load("./conf_lista.php?tbl_db="+tabla+"&tbl_title="+titulo);
}
// Funcion que se ejecuta cuando se carga la lista de registros
function editarConfig () {
    $('.opc_cont span').on('click', editarRegConfig);
    $('.opc_cont span').on('touch', editarRegConfig);
    $('.btn_regresar > .btn').on('click', regresaNuevo);
    $('.btn_regresar > .btn').on('touch', regresaNuevo);
    setTimeout(esperehide, 1000);
}
// funcion que se dispara cuando se hace clic en ver, editar o eliminar contacto
function editarRegConfig (datos){
    espereshow();
    var cont_id_div = $(this).parent('div').attr('id');
    var cont_id_part = cont_id_div.split("-");
    var tabla = cont_id_part[0];
    var cont_id = cont_id_part[1];
    var titulo = encodeURIComponent($("#titulo").val());
    var html_opc = $(this).children('i').attr("class");
    switch(html_opc){
        case "glyphicon glyphicon-remove":
            setTimeout(esperehide, 1000);
            swal({
                title: "¿Esta Seguro?",
                text: "Se borrará el registro # " + cont_id,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#F8BB86",
                confirmButtonText: "Eliminar!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url:"../php/ins_upd_conf.php",
                    cache:false,
                    type:"POST",
                    data:"id_sup="+cont_id+"&tabla="+tabla,
                    success: function(datos){
                        if(datos !== ''){
                            $("#col-md-12").load("./conf_lista.php?tbl_db="+tabla+"&tbl_title="+titulo);
                            swal({
                                title: "Eliminado!",
                                text: "El registro se ha eliminado correctamente!",
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#94B86E"
                            });
                        }
                        else{
                            swal({
                                title: "Error!",
                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                            return;
                        }
                    }
                });
            });
            break;
        case "glyphicon glyphicon-eye-open":
            $("#col-md-12").load("./conf_lista_ed.php?tbl_db="+tabla+"&conf_id_open="+cont_id+"&titulo="+titulo+"&conf_ver=1");
            break;
        case "glyphicon glyphicon-pencil":
            $("#col-md-12").load("./conf_lista_ed.php?tbl_db="+tabla+"&conf_id_open="+cont_id+"&titulo="+titulo);
            break;
        default:
            break;
    }
}
// Funcion que se ejecuta al hacer clic en el boton regresar o nuevo registro en el listado de configuración
function regresaNuevo (datos) {
    espereshow();
    var tabla = $("#tabla").val();
    var titulo = encodeURIComponent($("#titulo").val());
    var clase = $(this).children("i").attr('class');
    if(clase == 'glyphicon glyphicon-arrow-left'){
        $("#col-md-12").load("./configuracion.php");
    }
    else{
        $("#col-md-12").load("./conf_lista_ed.php?tbl_db="+tabla+"&titulo="+titulo);
    }
}
// funcion que se ejecuta al cargar el archivo conf_lista_ed.php
function editarListConfig (readonly) {  
    setTimeout(esperehide, 1000);
    $("#btn_cancelar").on("click", cancelarTareaConf);
    $("#btn_cancelar").on("touch", cancelarTareaConf);
    $('.fileimagen').on('change', function(e) {
        PreImagen(this, e);
    });
    if(readonly !== ''){
        $("input").attr('disabled', 'disabled');
        $("select").attr('disabled', 'disabled');
        $("textbox").attr('disabled', 'disabled');
    }
}
// Funcion que regresa a la lista de registros de la tabla correspondiente
// Funcion que se activa al hacer clic en el boton cancelar
function cancelarTareaConf (datos) {
    espereshow();
    var divpanel = $("#div_panel").val();
    var tipoaccion = $(this).children("i").attr("class");
    var tabla = $("#tabla").val();
    var titulo = encodeURIComponent($("#titulo").val());
    var varget = "";
    if((tabla !== '')&&(tabla !== undefined)){varget = varget + "?tbl_db="+tabla;}
    if((titulo !== '')&&(titulo !== undefined)){varget = varget + "&tbl_title="+titulo;}
    if(tipoaccion === 'glyphicon glyphicon-arrow-left'){
        $("#col-md-12").load("./conf_lista.php"+varget);
    }
    setTimeout(esperehide, 1000);
}
// cargar el listado de Empleados
function cargaListEmp(){
    $("#search_cont").on("keyup", buscarEmpleado);
    $("#search_cont").on("change", buscarEmpleado);
    $("#search_cont_icon").on("click", buscarEmpleado);
    $("#search_cont_icon").on("touch", buscarEmpleado);
    // $("#emp_det").load("./emp_det_ed.php");
    $("#new_emp").on("click", newEmpleado);
    $("#new_emp").on("touch", newEmpleado);
    setTimeout(esperehide, 1000);
}
// funcion que se dispara cuando se hace clic en ver, editar o eliminar contacto
function newEmpleado(datos){
    $("#emp_det").load("./emp_det_ed.php");
    $("#search_cont").val("");
    $("#emp_list").html("<div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><strong>Búsqueda!</strong> Realice una búsqueda del empleado para consultar su información, esta búsqueda se realiza por palabra clave en los campos nombre, correo electrónico, observación y número de documento.</div>");
}
// Buscar empleados en Recursos Humanos - empleados 
function buscarEmpleado(){
    var texto = $("#search_cont").val();
    var val = encodeURIComponent(texto);
    if(texto.length > 0)
    {
        $("#emp_list").load("./emp_list.php?text_bus="+val);
        $("#emp_det").html("");
    }
}
// Buscar empleados en Recursos Humanos - solicitudes 
function buscarEmpleadoSolic(){
    var texto = $("#search_cont").val();
    var val = encodeURIComponent(texto);
    if(texto.length > 0)
    {
        $("#emp_list").load("./emp_list_solic.php?text_bus="+val);
        $("#emp_det").html("");
    }
}
// Funcion que se desplega al cargar la pag empleados lista emp_list.php
function ed_empleado(){
    $(".opc_emp").on("click", opcionEmpleado);
    $(".opc_emp").on("touch", opcionEmpleado);
    setTimeout(esperehide, 1000);
}
// funcion que se dispara cuando se hace clic en ver, editar o eliminar contacto
function opcionEmpleado(datos){
    espereshow();
    var cont_id_div = $(this).attr('id');
    var cont_id_part = cont_id_div.split("_");
    var cont_id = cont_id_part[1];
    var html_opc = $(this).children('i').attr("class");
    // si el perfil de usuario es empleado 5
    if(sess_perf === '5'){
        var nom_div_pag = "emp_det";
    }
    else{
        var nom_div_pag = $("#nom_div_pag").val();
    }
    
    var nom_div = "#detalle_emp_"+cont_id;

    $(".detalle_ingreso").html("");
    $(".detalle_ingreso").addClass('hidden');
    $(".cam_ing").removeClass('btblue');

    switch(html_opc){
        case "glyphicon glyphicon-remove":
            swal({
                title: "¿Esta Seguro?",
                text: "Se borrará el registro # ",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#F8BB86",
                confirmButtonText: "Eliminar!",
                closeOnConfirm: false
            },
            function(){
                swal(
                    "Eliminado!",
                    "El registro se ha eliminado.",
                    "success"
                );
            });
            setTimeout(esperehide, 1000);
            break;
        case "glyphicon glyphicon-eye-open":
            $(nom_div).load("./"+nom_div_pag+"_temp.php?emp_id="+cont_id);
            $(nom_div).removeClass('hidden');
            $(nom_div).addClass('btblue');
            $(this).parent("div").parent("div").toggleClass('btblue');
            break;
        case "glyphicon glyphicon-pencil":
            $(nom_div).load("./"+nom_div_pag+"_ed.php?emp_id="+cont_id);
            $(nom_div).removeClass('hidden');
            $(nom_div).addClass('btblue');
            $(this).parent("div").parent("div").toggleClass('btblue');
            break;
        default:
            break;
    }
}
// Funion que muestra los datos del empleado al hacer clic en el boton datos basicos
function det_emp() {
    $(".panel-default > div > h4 > a").on("click", datosEmpleado);
    $(".panel-default > div > h4 > a").on("touch", datosEmpleado);
    setTimeout(esperehide, 1000);
}

function datosEmpleado(datos) {
    espereshow();
    var id_emp = $("#id_emp").val();
    $(".panel").children(".panel-collapse").html('');
    var pagina = $(this).attr("href");
    var pag = pagina.replace("#", "");
    if((!id_emp.length)&&(pag !== "emp_basicos")){
        setTimeout(esperehide, 1000);
        swal({
            title: "Error!",
            text: "Debe diligenciar los datos básicos del empleado!",
            type: "error",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#E25856"
        });
        // type: "error",confirmButtonColor: "#E25856"
        // type: "success",confirmButtonColor: "#94B86E"
        // type: "warning",confirmButtonColor: "#F8BB86"
        // type: "info",confirmButtonColor: "#C9DAE1"
        // $(".panel").children(".panel-collapse").html('');
    }
    else{
        $(pagina).load("./" + pag + ".php?id_emp="+id_emp);
    }
    // setTimeout(esperehide, 1000);
}
// funcion que se ejecuta al cargar la pagina de ver detalle del empleado
function det_emp_ver() {
    $(".panel-default > div > h4 > a").on("click", datosEmpleadoVer);
    $(".panel-default > div > h4 > a").on("touch", datosEmpleadoVer);
    setTimeout(esperehide, 1000);
}

function datosEmpleadoVer(datos) {
    espereshow();
    var id_emp = $("#id_emp").val();
    var pagina = $(this).attr("href");
    var pag = pagina.replace("#", "");
    setTimeout(esperehide, 1000);
}

function empEstudios() {
    $(".btn_est > .input-group-addon").on("click", datosEstudios);
    $(".btn_est > .input-group-addon").on("touch", datosEstudios);
    setTimeout(esperehide, 1000);
}

function datosEstudios (datos) {
    espereshow();
    var tipoaccion = $(this).children("i").attr("class");
    var divpanel = $("#div_panel").val();
    var id_exp = $(this).parent("div").attr("name");
    var id_emp = $("#id_emp").val();
    var pag_upd = $("#input-pagina").val();
    switch(tipoaccion){
        case "glyphicon glyphicon-remove":
            setTimeout(esperehide, 1000);
            swal({
                title: "¿Esta Seguro?",
                text: "Se borrará el registro # " + id_exp,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#F8BB86",
                confirmButtonText: "Eliminar!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    url:"../php/"+pag_upd+".php",
                    cache:false,
                    type:"POST",
                    data:"id_sup="+id_exp,
                    success: function(datos){
                        if(datos !== ''){
                            // alert(datos);
                            $("#" + divpanel).load("./" + divpanel + ".php?id_emp="+id_emp);
                            swal({
                                title: "Eliminado!",
                                text: "El registro se ha eliminado correctamente!",
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#94B86E"
                            });
                        }
                        else{
                            swal({
                                title: "Error!",
                                text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                            return;
                        }
                    }
                });
            });
            break;
        case "glyphicon glyphicon-eye-open":
            espereshow();
            if(divpanel === 'solic_laboral'){
                $("#" + divpanel).load("./" + divpanel + "_temp.php?exp_id="+id_exp);
            }
            else{$("#" + divpanel).load("./" + divpanel + "_ed.php?exp_id="+id_exp+"&exp_d=ok");}
            break;
        case "glyphicon glyphicon-pencil":
            espereshow();
            $("#" + divpanel).load("./" + divpanel + "_ed.php?exp_id="+id_exp);
            break;
        case "glyphicon glyphicon-plus":
            espereshow();
            $("#" + divpanel).load("./" + divpanel + "_ed.php?id_emp="+id_emp);
            break;
        case "glyphicon glyphicon-download":
            setTimeout(esperehide, 1000);
            // $("#" + divpanel).load("./" + divpanel + "_print.php?id_emp="+id_exp);
            break;
    }
}
// funcion que se ejecuta al cargar  el archivo emp_estudios_ed.php
function empEstudiosEdit() {
    $("#e3_tstd_id").on("change", datosEstudiosEdit);
    $("input:radio[name='e3_std_fini']").on("click", hab_deshab);
    $("input:radio[name='e3_std_fini']").on("touch", hab_deshab);
    $("input:radio[name='e3_cont_fin']").on("click", hide_show_ffin);
    $("input:radio[name='e3_cont_fin']").on("touch", hide_show_ffin);
    $("input:radio[name='e3_cont_pat']").on("click", hide_show_pat);
    $("input:radio[name='e3_cont_pat']").on("touch", hide_show_pat);
    $("input:radio[name='e3_horario_fin']").on("click", hide_show_ffin);
    $("input:radio[name='e3_horario_fin']").on("touch", hide_show_ffin);
    $("input:radio[name='e3_card_fin']").on("click", hide_show_ffin);
    $("input:radio[name='e3_card_fin']").on("touch", hide_show_ffin);
    $("#btn_cancelar").on("click", cancelarTarea);
    setTimeout(esperehide, 1000);
    datosEstudiosEdit();
}
// funcion que se ejecuta al cambiar el tipo de estudio en editar o agregar nuevo estudio. 
function datosEstudiosEdit (datos) {
    espereshow();
    var tipostd = $("#e3_tstd_id").val();
    if(tipostd == '3'){
        $("#n_tarj_prof").css("display", "block");
        $("#a_tarj_prof").css("display", "block");
    }
    else{
        $("#n_tarj_prof").css("display", "none");
        $("#a_tarj_prof").css("display", "none");
    }
    setTimeout(esperehide, 1000);
}
// Funcion que se activa al hacer clic en el boton cancelar
function cancelarTarea (datos) {
    espereshow();
    var divpanel = $("#div_panel").val();
    var tipoaccion = $(this).children("i").attr("class");
    var id_exp = $("#id_emp").val();
    if((id_exp !== '')&&(id_exp !== undefined)){var varget = "&id_emp="+id_exp;}
    else{var varget = "";}
    if(tipoaccion === 'glyphicon glyphicon-arrow-left'){
        $("#" + divpanel).load("./" + divpanel + ".php?perm_mod="+sess_mod_1+varget);
    }
    ocultarPermiso();
    setTimeout(esperehide, 1000);
}
// Esta funcion no esta definida revisar para que se armo
function eventSolic() {
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta cuando se selecciona una opcion de terminado el estudio.
function hab_deshab (datos) {
    espereshow();
    var valor = $(this).val();
    switch(valor){
        case '1':
            $("#e3_std_ffin").attr("readonly", false);
            break;
        case '2':
            $("#e3_std_ffin").attr("readonly", false);
            break;
        case '3':
            $("#e3_std_ffin").attr("readonly", "readonly");
            break;
    }
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta cuando se selecciona una opcion de terminado o no el contrato en Contratos.
function hide_show_ffin () {
    espereshow();
    $("#cont_ffin").toggleClass('hidden');
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta cuando se selecciona una opcion de patrocino o no en Contratos.
function hide_show_pat () {
    espereshow();
    $(".patrocinio").toggleClass('hidden');
    setTimeout(esperehide, 1000);
}
// cargar la lista de busqueda y de emleados en solicitudes
function cargaListEmpSolic(){
    // cargar el listado de Empleados
    $("#search_cont").on("keyup", buscarEmpleadoSolic);
    $("#search_cont").on("change", buscarEmpleadoSolic);
    $("#search_cont_icon").on("click", buscarEmpleadoSolic);
    $("#search_cont_icon").on("touch", buscarEmpleadoSolic);
    $("#search_cont_icon2").on("click", buscarEmpleadoSolic);
    $("#search_cont_icon2").on("touch", buscarEmpleadoSolic);
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta cuando se carga la pagina de solicitudes
function det_solic() {
    $(".panel-default > div > h4 > a").on("click", datosSolicitud);
    $(".panel-default > div > h4 > a").on("touch", datosSolicitud);
    setTimeout(esperehide, 1000);
}
//funcion que se ejecuta cuando se hace clic en las opciones de solicitud
function datosSolicitud(datos) {
    var id_emp = $("#id_emp").val();
    $(".panel").children(".panel-collapse").html('');
    var pagina = $(this).attr("href");
    var pag = pagina.replace("#", "");
    if(!id_emp.length){
        swal({
            title: "Error!",
            text: "Debe buscar y seleccionar un empleado!",
            type: "error",
            confirmButtonText: "Entendido",
            confirmButtonColor: "#E25856"
        });
        // type: "error",confirmButtonColor: "#E25856"
        // type: "success",confirmButtonColor: "#94B86E"
        // type: "warning",confirmButtonColor: "#F8BB86"
        // type: "info",confirmButtonColor: "#C9DAE1"
        $(".panel").children(".panel-collapse").html('');
    }
    else{
        espereshow();
        if($(pagina).html() === ''){$(pagina).load(pag + ".php?id_emp="+id_emp+"&perm_mod="+sess_mod_1);}
    }
    setTimeout(esperehide, 1000);
}
// cargar la lista de busqueda y de emleados en Ingreso
function cargaListIngreso()
{
    // cargar el listado de Empleados
    $("#search_cont").on("keyup", buscarEmpleado);
    $("#search_cont_icon").on("click", buscarEmpleado);
    $("#search_cont_icon").on("touch", buscarEmpleado);
    $("#emp_det").load("./ing_det_ed.php");
    $("#new_emp").on("click", newEmpleado);
    $("#new_emp").on("touch", newEmpleado);
}
// funcion que se ejecuta cuando se carga la pagina de solicitudes
function det_ing() {
    $(".panel-default > div > h4 > a").on("click", datosIngreso);
    $(".panel-default > div > h4 > a").on("touch", datosIngreso);
    setTimeout(esperehide, 1000);
}
//funcion que se ejecuta cuando se hace clic en las opciones de solicitud
function datosIngreso(datos) {
    $(".panel").children(".panel-collapse").html('');
    var pagina = $(this).attr("href");
    var pag = pagina.replace("#", "");
    espereshow();
    if($(pagina).html() === ''){$(pagina).load(pag + ".php");}
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta al cargar  el archivo emp_estudios_ed.php
function ingresoEdit() {
    // event.preventDefault();
    $("#btn_cancelar").on("click", cancelarTarea);
    $("#btn_cancelar").on("touch", cancelarTarea);
    var div_pag = $("#div_panel").val();
    var id_empresa = $("#e3_emp_id").val();
    if((id_empresa !== '')&&(id_empresa !== undefined)){var varget = "?id_empresa="+id_empresa;}
    else{var varget = "";}
    if(div_pag === 'ing_reporte'){
        $("#btn_generar").on("click", generarReporte);
        $("#btn_generar").on("touch", generarReporte);
        // Si el perfil es diferentea a empleado carga la lista de empleados
        if(sess_perf !== '5'){
            $("#ing_empleado").load("./ing_empleados.php"+varget);
        }
        else{
            generarReporte();
        }
        
        $("#e3_emp_id").on("change", cargaEmpleados);
    }
    if(sess_perf !== '5'){setTimeout(esperehide, 1000);}
}
// Generar el reporte de ingresos al edificio
function generarReporte() {
    espereshow();
    var finicial = $("#e3_ing_finicial").val();
    var ffinal = $("#e3_ing_ffinal").val();
    var emp = $("#e3_emp_id").val();
    var card = $("#e3_user_card").val();
    $("#reporte").load("./ing_generado.php?finicial="+finicial+"&ffinal="+ffinal+"&emp="+emp+"&card="+card);
    // setTimeout(esperehide, 1000);
}
// funcion que carga los empleados en un select al seleccionar una empresa
function cargaEmpleados(datos) {
    espereshow();
    var id_empresa = $(this).val();
    $("#ing_empleado").load("./ing_empleados.php?id_empresa="+id_empresa);
    setTimeout(esperehide, 1000);
}
// Funcion que se inicia al cargar al generar el informe de ingreso.
function detalleIng() {
    $(".id_detalle").on("click", verDetalle);
    $(".id_detalle").on("touch", verDetalle);
    setTimeout(esperehide, 1000);
}
// Funcion que muestra el detalle del ingresos, almuerzos y/o break
function verDetalle(datos) {
    espereshow();
    var div_carga = $(this).attr('div_carga');
    var pag = $(this).attr('pag');
    var card = $(this).attr('name');
    var finicial = $("#e3_ing_finicial").val();
    var ffinal = $("#e3_ing_ffinal").val();
    var emp = $("#e3_emp_id").val();
    var len_div = $(div_carga).html();
    if(len_div.length){
        $(".detalle_ingreso").html("");
        $(".detalle_ingreso").addClass('hidden');
        $(".id_detalle").parent("div").parent("div").removeClass('bviolet');
        setTimeout(esperehide, 1000);
    }
    else{
        $(".detalle_ingreso").html("");
        $(".detalle_ingreso").addClass('hidden');
        $(".id_detalle").parent("div").parent("div").removeClass('bviolet');
        $(div_carga).removeClass('hidden');
        $(div_carga).load("./"+pag+".php?card="+card+"&finicial="+finicial+"&ffinal="+ffinal+"&emp="+emp);
        $(div_carga).addClass('bviolet');
        $(this).parent("div").parent("div").toggleClass('bviolet');
    }
}
// funcion que oculta el permiso o vacaciones del reporte de ingreso de un empleado
function ocultarPermiso (argument) {
    var perm = $("#perm_id").val();
    $(".perm" + perm).html("");
    
}
// funcion que cambia el estado de una solicitud de permiso cuando esta no es tomada por el empleado
function ignorarPermiso () {
    var id_emp = $("#id_emp").val();
    var id_ignorar = $("#id_upd").val();
    setTimeout(esperehide, 1000);
    swal({
        title: "¿Esta Seguro?",
        text: "Se omitira el permiso # " + id_ignorar,
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        confirmButtonColor: "#F8BB86",
        confirmButtonText: "Ignorar!",
        closeOnConfirm: false
    },
    function(){
        $.ajax({
            url:"../php/ins_upd_perm.php",
            cache:false,
            type:"POST",
            data:"id_ignorar="+id_ignorar,
            success: function(datos){
                if(datos !== ''){
                    $("#solic_permisos").load("./solic_permisos.php?id_emp="+id_emp+"&perm_mod="+sess_mod_1);
                    swal({
                        title: "Felicidades!",
                        text: "El permiso se ha actualizado correctamente!",
                        type: "success",
                        confirmButtonText: "Continuar",
                        confirmButtonColor: "#94B86E"
                    });
                }
                else{
                    swal({
                        title: "Error!",
                        text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                        type: "error",
                        confirmButtonText: "Aceptar",
                        confirmButtonColor: "#E25856"
                    });
                    return;
                }
            }
        });
    });
}
// funcion que se ejecuta al cargar  el archivo solic_permisos_ed.php
function solicPermisos() {
    $("#btn_cancelar").on("click", cancelarTarea);
    $("#btn_regresar").on('click', cancelarTarea);
    $("#ignorar").on('click', ignorarPermiso);
    setTimeout(cerrar_alert, 9000);
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta al cargar  el archivo solic_vacaciones_ed.php
function solicVacaciones() {
    $("#btn_cancelar").on("click", cancelarTarea);
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta al seleccionar el tipo de certificado laboral a generar
function mostrarCampos (argument) {
    var tipo = $(this).val();
    if(tipo === '1'){
        if(!$("label[for='e3_solic_det']").parent("div").hasClass('hidden')){
            $("label[for='e3_solic_det']").parent("div").addClass('hidden');
        }
        $("label[for='e3_solic_obs']").parent("div").removeClass('hidden');
    }
    else if((tipo === '2') || (tipo === '3')){
        $("label[for='e3_solic_det']").parent("div").removeClass('hidden');
        $("label[for='e3_solic_obs']").parent("div").removeClass('hidden');
    }
    else{
        if(!$("label[for='e3_solic_det']").parent("div").hasClass('hidden')){
            $("label[for='e3_solic_det']").parent("div").addClass('hidden');
        }
        if(!$("label[for='e3_solic_obs']").parent("div").hasClass('hidden')){
            $("label[for='e3_solic_obs']").parent("div").addClass('hidden');
        }
    }
}
// funcion que se ejecuta al seleccionar la fecha de terminacion de vacaciones
function calculaDias(datos) {
    var fechaini = $("#e3_solic_fini").val();
    var fechafin = $(this).val();
    if((fechaini !== '')&&(fechaini <= fechafin)){
        var dias = restaFechas(fechaini, fechafin);
        $("#e3_solic_ndias").val(dias);
    }
    else{
        swal({
            title: "Error!",
            text: "la fecha inicial es mayor a la final o no ha sido seleccionada!",
            type: "error",
            confirmButtonText: "Continuar",
            confirmButtonColor: "#94B86E"
        });
    }
}
// Función para calcular los días transcurridos entre dos fechas
function restaFechas(f1,f2){
    var aFecha1 = f1.split('-'); 
    var aFecha2 = f2.split('-'); 
    var fFecha1 = Date.UTC(aFecha1[0],aFecha1[1]-1,aFecha1[2]); 
    var fFecha2 = Date.UTC(aFecha2[0],aFecha2[1]-1,aFecha2[2]); 
    var dif = fFecha2 - fFecha1;
    var dias = Math.floor(dif / (1000 * 60 * 60 * 24)); 
    return dias;
}

var th = ['','mil','millón', 'billón','trillón'];
var dg = ['cero','uno','dos','tres','cuatro', 'cinco','seis','siete','ocho','nueve']; 
var tn = ['diez','once','doce','trece', 'catorce','quince','dieciseis', 'diecisiete','dieciocho','diecinueve']; 
var tw = ['veinte','treinta','cuarenta','cincuenta', 'sesenta','setenta','ochenta','nocenta']; 
function toWords(s){
    s = s.toString();
    s = s.replace(/[\, ]/g,'');
    if (s != parseFloat(s)) return 'no es un número';
    var x = s.indexOf('.');
    if (x == -1) x = s.length;
    if (x > 15) return 'Muy grande';
    var n = s.split('');
    var str = '';
    var sk = 0;
    for (var i=0; i < x; i++) {
        if ((x-i)%3==2) {
            if (n[i] == '1') {
                str += tn[Number(n[i+1])] + ' ';
                i++;
                sk=1;
            }
            else if (n[i]!=0) {
                str += tw[n[i]-2] + ' ';
                sk=1;
            }
        }
        else if (n[i]!=0) {
            str += dg[n[i]] +' ';
            if ((x-i)%3==0) str += 'cien ';
            sk=1;
        }
        if ((x-i)%3==1) {
            if (sk) str += th[(x-i-1)/3] + ' ';
            sk=0;
        }
    }
    if (x != s.length) {
        var y = s.length;
        str += 'pesos ';
        for (var i=x+1; i<y; i++) str += dg[n[i]] +' ';
    }
    return str.replace(/\s+/g,' ');
}
// Muestra el numero de una cifra en el campo correspondiente
function mostrarNumero(n, l){
    var texto = toWords(n).toUpperCase();
    $("#"+l).html(texto);
}
//funcion que convierte los numeros en letras
function letras(c,d,u){
    var centenas,decenas,decom
    var lc=""
    var ld=""
    var lu=""
    centenas=eval(c);
    decenas=eval(d);
    decom=eval(u);
    switch(centenas){
        case 0: lc="";break;
        case 1:{
            if (decenas==0 && decom==0)lc="Cien";
            else lc="Ciento ";
        }
        break;
        case 2: lc="Doscientos ";break;
        case 3: lc="Trescientos ";break;
        case 4: lc="Cuatrocientos ";break;
        case 5: lc="Quinientos ";break;
        case 6: lc="Seiscientos ";break;
        case 7: lc="Setecientos ";break;
        case 8: lc="Ochocientos ";break;
        case 9: lc="Novecientos ";break; 
    } 
    switch(decenas){
        case 0: ld="";break;
        case 1:{ 
            switch(decom){
                case 0:ld="Diez";break;
                case 1:ld="Once";break;
                case 2:ld="Doce";break;
                case 3:ld="Trece";break;
                case 4:ld="Catorce";break;
                case 5:ld="Quince";break;
                case 6:ld="Dieciseis";break;
                case 7:ld="Diecisiete";break;
                case 8:ld="Dieciocho";break;
                case 9:ld="Diecinueve";break;
            }
        }      
        break;
        case 2:ld="Veinte";break;
        case 3:ld="Treinta";break;
        case 4:ld="Cuarenta";break;
        case 5:ld="Cincuenta";break;
        case 6:ld="Sesenta";break;
        case 7:ld="Setenta";break;
        case 8:ld="Ochenta";break;
        case 9:ld="Noventa";break; 
    }
    switch(decom){
        case 0: lu="";break;
        case 1: lu="Un";break;
        case 2: lu="Dos";break;
        case 3: lu="Tres";break;
        case 4: lu="Cuatro";break;
        case 5: lu="Cinco";break;
        case 6: lu="Seis";break;
        case 7: lu="Siete";break;
        case 8: lu="Ocho";break;
        case 9: lu="Nueve";break; 
    }           
    if (decenas==1){return lc+ld;}
    if (decenas==0 || decom==0){return lc+" "+ld+lu;}
    else{
        if(decenas==2){
            ld="Veinti";
            return lc + ld + lu.toLowerCase();
        }
        else{return lc+ld+" y "+lu;}
    }
}
//funcion que divide las cifras y envia los numeros para convertirlos en letras
function getNumberLiteral(n){
    // alert(n);
    var m0,cm,dm,um,cmi,dmi,umi,ce,de,un,hlp,decimal;           
    if (isNaN(n)) {
        event.preventDefault();
        alert("La Cantidad debe ser un valor Numérico.");
        return null
    }
    m0= parseInt(n/ 1000000000000); rm0=n% 1000000000000;
    m1= parseInt(rm0/100000000000); rm1=rm0%100000000000;
    m2= parseInt(rm1/10000000000); rm2=rm1%10000000000;
    m3= parseInt(rm2/1000000000); rm3=rm2%1000000000;
    cm= parseInt(rm3/100000000); r1= rm3%100000000;
    dm= parseInt(r1/10000000); r2= r1% 10000000;
    um= parseInt(r2/1000000); r3= r2% 1000000;
    cmi=parseInt(r3/100000); r4= r3% 100000;
    dmi=parseInt(r4/10000); r5= r4% 10000;
    umi=parseInt(r5/1000); r6= r5% 1000;
    ce= parseInt(r6/100); r7= r6% 100;
    de= parseInt(r7/10); r8= r7% 10;
    un= parseInt(r8/1);
    //r9=r8%1; 
    999123456789
    if (n< 1000000000000 && n>=1000000000){
        tmp=n.toString();
        s=tmp.length;
        tmp1=tmp.slice(0,s-9)
        tmp2=tmp.slice(s-9,s);           
        tmpn1=getNumberLiteral(tmp1);
        tmpn2=getNumberLiteral(tmp2);
        if(tmpn1.indexOf("Un")>=0)pred=" Billón ";
        else pred=" Billones ";
        return tmpn1+ pred +tmpn2;
    }           
    if (n<10000000000 && n>=1000000){
        mldata=letras(cm,dm,um); 
        hlp=mldata.replace("Un","*");
        if (hlp.indexOf("*")<0 || hlp.indexOf("*")>3){
            mldata=mldata.replace("Uno","un");
            mldata+=" Millones ";
        }
        else{mldata="Un Millón ";}
        mdata=letras(cmi,dmi,umi);
        cdata=letras(ce,de,un);
        if(mdata!=" "){
            if (n == 1000000) {mdata=mdata.replace("Uno","un") + "de";}
            else {mdata=mdata.replace("Uno","un")+" mil ";}
        }
        return (mldata+mdata+cdata);
    } 
    if (n<1000000 && n>=1000){
        mdata=letras(cmi,dmi,umi);
        cdata=letras(ce,de,un);
        hlp=mdata.replace("Un","*");
        if (hlp.indexOf("*")<0 || hlp.indexOf("*")>3){
            mdata=mdata.replace("Uno","un");
            return (mdata +" mil "+cdata);
        }
        else return ("Mil "+ cdata);
    }
    if (n<1000 && n>=1){return (letras(ce,de,un));}
    if (n==0){return " Cero";}
    return "No disponible"
}
// funcion que se ejecuta al hacer click en el boton cancelar de datos basicos en empleados
function empBasicos() {
    $("#btn_cancelar").on("click", cancelarTareaBasicos);
    setTimeout(esperehide, 1000);
}
// funcion que regresa a la pagina original haciendo click en cancelar
function cancelarTareaBasicos() {
    var texto = $("#id_emp").val();
    if(texto !== ''){
        $("#detalle_emp_"+texto).load("./emp_det_ed.php?emp_id="+texto);
    }
    else{
        $("#emp_det").load("./emp_det_ed.php");
    }
}
// funcion que se ejecuta al hacer click en el boton cancelar de datos basicos en empleados
function empTemporal() {
    if($('#div_panel').length){
        $("#btn_cancelar").on("click", cancelarTareaTemporal);
        // $("#btn_print").on("click", printTemporal);
        setTimeout(esperehide, 1000);
    }
    else{
        $("#col-md-12").removeClass('btblue');
        // $("#col-md-12").load('calendario.php');
        setTimeout(esperehide, 1000);
    }
}
// funcion que regresa a la pagina original haciendo click en cancelar
function cancelarTareaTemporal() {
    var texto = $("#id_emp").val();
    var div_panel = $("#div_panel").val();

    if(div_panel === 'index'){
        $("#col-md-12").load(div_panel+'.php');
        $("#col-md-12").removeClass('btblue');
    }
    else{$("#col-md-12").load(div_panel+'.php');}
    // alert("aca "+texto);
    $("#detalle_emp_"+texto).html("");
    $("#detalle_emp_"+texto).addClass('hidden');
    $("#detalle_emp_"+texto).removeClass('btblue');
    $(this).parent("div").parent("div").toggleClass('btblue');
}
// funcion que abre la pagina de impresion de la hoja de vida del empleado
function printTemporal() {
    var id_emp = $("#id_emp").val();
    if((id_emp !== '')&&(id_emp !== undefined)){
        $("#detalle_emp_"+id_emp).load("./emp_det_print.php?emp_id="+id_emp);
    }
    else{
        $("#emp_det").load("./emp_det_ed.php");
    }
}
// funcion que se ejecuta al cargar el detalle del informe de ingresos
function detalleEntradas() {
    $(".ver-perm").on("click", mostrarPermiso);
    $(".ver-perm").on("touch", mostrarPermiso);
    $(".ver-esp").on("click", mostrarEspecial);
    $(".ver-esp").on("touch", mostrarEspecial);
    setTimeout(esperehide, 1000);
}
// Funcion que se ejecuta al hacer click en el icono de ver solicitud en el detalle del informe de ingreso
function mostrarPermiso (datos) {
    espereshow();
    var id_solic = $(this).attr("name");
    var padre = $(this).parent("div").parent("div");

    if($(".perm"+id_solic).hasClass('hidden')){
        $(".perm"+id_solic).removeClass('hidden');
        $(padre).next(".perm"+id_solic).load("./solic_permisos_ed.php?exp_id="+id_solic+"&exp_d=rep");
    }
    else{
        $(".perm"+id_solic).html('');
        $(".perm"+id_solic).addClass('hidden');
        setTimeout(esperehide, 1000);
    }
    // $(padre).next(".perm"+id_solic).toggleClass('hidden');
}
// Funcion que se ejecuta al hacer click en el icono de ver día especial en el detalle del informe de ingreso
function mostrarEspecial (datos) {
    espereshow();
    var id_solic = $(this).attr("name");

    $(".esp"+id_solic).html('');
    $(".esp"+id_solic).addClass('hidden');

    var padre = $(this).parent("div").parent("div");
    $(padre).next(".esp"+id_solic).load("./cal_ver_evento.php?id="+id_solic);
    $(padre).next(".esp"+id_solic).toggleClass('hidden');
}
// Funcion que carga el calendario
function cargarCalendario () {
    if ((sess_perf === '9') || (sess_perf === '1')) {
        $(".btn_tipo").removeClass('hidden');
        $(".btn-cal").attr('disabled', false);
    }
    else if (sess_perf === '4') {
        $(".btn_tipo").removeClass('hidden');
        $(".btn-cal").first().attr('disabled', false);
        $(".btn-cal").last().attr('disabled', false);
    }
    else{
        $(".alert").parent("div").addClass('hidden');
    }
    $(".btn").on("click", tipoCalendario);
    $(".btn").on("touch", tipoCalendario);
    setTimeout(esperehide, 1500);
    setTimeout(cerrar_alert, 8500);
}
// Funcion que obtiene el tipo de calendario que se ingresara
function tipoCalendario (datos) {
    var tipocal = $(this).attr('name');
    $("#tipo_cal").val(tipocal);
}
function agregarEvento (datos) {
    var fechadia = $(this).attr('data-date');
    var tipocal = $("#tipo_cal").val();
    if(tipocal === '2'){
        $(this).toggleClass('fc-event');
    }
    else{
        $(".ing-cal").load("cal_evento.php");
        // $(".ing-cal").fadeIn('fast');
        $(".ing-cal").removeClass('hidden');
        $(this).toggleClass('fc-event');
    }    
}
function editEvento () {
    $('#e3_cal_emp_0').on("click", marcarEmpresas);
    $('.btn-default').on("click", cerrarDetEvento);
    setTimeout(esperehide, 1000);
}
// Funcion que marca todos los checkbox de las empresas al hacer click en todos
function marcarEmpresas (datos) {
    $('input[type=checkbox]').each( function() {            
        if($("input[name=e3_cal_todos]:checked").length == 1){
            this.checked = true;
        } else {
            this.checked = false;
        }
    });
    // $('input[name=e3_cal_emp[]]').attr('checked', true);
}
// funcion que se ejecuta al cargar la paginas de ver eventos
function verEvento () {
    $('.btn-default').on("click", cerrarDetEvento);
    setTimeout(esperehide, 1000);
}
// Funcion que cierra el detalle del evento al hacer click en el boton cancelar
function cerrarDetEvento (event) {
    event.preventDefault();
    $(".ing-cal").html("");
    $(".ing-cal").addClass('hidden');
}
// Funcion que cierra automaticamente un mensaje de alerta.
function cerrar_alert () {
    $('.alert').fadeOut('slow');
}
// funcion que muestra pagina al hacer clic en boton cancelar de cambiar contraseña
function cancelarContrasena (argument) {
    var pag = $("#div_panel").val();
    $("#col-md-12").load("./"+pag+".php");
}
// funcion que se ejecuta al cargar la pagina de cambio de contraseña
function cambioContrasena () {
    $("#btn_cancelar").on("click", cancelarContrasena);
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta al cargar la pagina de pausas activas
function cargarPausas () {
    $("#img-pausas").html('');
    setTimeout(esperehide, 1000);
}
// funcion que se ejecuta cada vez que se carga un contenido en las pausas activas
function validaFinal (img, total, time, carp) {
    if("'"+img+"'" === "'"+total+"'"){
        if((carp === '1') || (carp === '2')){
            time += 63000;
        }
        else if(carp === '3'){
            time += 57000;
        }
        img = 1;
        setTimeout(
            function () {
                $("#img-pausas").html('<img src="../img/pausas/'+carp+'/final.png" class="img-responsive" alt="Image" width="100%">');
            },
            time
        );
    }
}
// funcion que carga la imagen al div de las pausas activas
function colocaPausa (carp, img, time, total) {
    setTimeout(
        function () {
            $("#img-pausas").html('<img src="../img/pausas/'+carp+'/'+img+'.gif" class="img-responsive" alt="Image" width="100%">');
        },
        time
    );
    validaFinal(img, total, time, carp);
}
// Funcion que se ejecuta al cargar los documentos de reglamento para aceptar
function cargaRegla () {
    $("input[name=e3_regla_nom]").on("click", aceptarTerminos);
    $(".btn").on("click", guardarTerminos);
}
// Funcion que se ejecuta al checkear o descheckear acepta el reglamento
function aceptarTerminos (datos) {
    $(".btn").toggleClass('disabled');
}
// Funcion que se ejecuta cuando se hace click en el boton de aceptar terminos
function guardarTerminos (datos) {
    if($('input[name=e3_regla_nom]').is(':checked')) {
        var doc = $('input[name=e3_regla_nom]').val();
        $.ajax({
            url:"../php/ins_upd_regla.php",
            cache:false,
            type:"POST",
            data:"e3_regla_nom="+doc,
            success: function(datos){
                if(datos){
                    $(".div-regla").addClass('hidden');
                    swal({
                        title: "¡Felicidades!",
                        text: "Registro actualizado correctamente!",
                        type: "success",
                        confirmButtonText: "Continuar",
                        confirmButtonColor: "#94B86E"
                    },
                    function(){
                        location.reload();
                    });
                }
                else{
                    $(".div-regla").addClass('hidden');
                    swal({
                        title: "Error!",
                        text: "El registro no se actualizó!",
                        type: "error",
                        confirmButtonText: "Volver",
                        confirmButtonColor: "#E25856"
                    },
                    function(){
                        location.reload();
                    });
                }
            }
        });
    }
}














$(document).on('ready', espereshow);