<?php session_start();?>
<!DOCTYPE html>
<html class="signin no-js" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Intranet Grupo Empresarial Eco Empresarial">
    <meta name="keywords" content="Tributar Asesores, Coveg Auditores, R+ B Diseño Experimental, Editores Hache">
    <meta name="author" content="Wilson Velandia">
    <!-- iconos para web apps y favicon -->
    <link rel="shortcut icon" href="./img/favicon.ico" />
    <link rel="apple-touch-icon" href="./img/icono_76.png">
    <link rel="apple-touch-icon" sizes="72x72" href="./img/icono_120.png">
    <link rel="apple-touch-icon" sizes="114x114" href="./img/icono_152.png">
    <link rel="stylesheet" href="style/bootstrapValidator.min.css"/>
    <link rel="stylesheet" href="style/sweet-alert.css">
    <link rel="stylesheet" href="style/bootstrap.min.css">
    <link rel="stylesheet" href="style/main_my.css">
    <link rel="stylesheet" href="style/style.css">
    <title>Edificio Eco Empresarial</title>
    <script type="text/javascript">
        //<![CDATA[
        try{if (!window.CloudFlare) {var CloudFlare=[{verbose:0,p:0,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/dok2v=88e434a982/"},atok:"05c88fe193ee7775bb3abde4dd9eace4",petok:"225e84481d9fae694d5a60d94661c158ae3928e6-1412257171-1800",zone:"nyasha.me",rocket:"0",apps:{"ga_key":{"ua":"UA-50530436-1","ga_bs":"2"}}}];CloudFlare.push({"apps":{"ape":"4979c49cc7637c0f99bbff37394a6ab9"}});!function(a,b){a=document.createElement("script"),b=document.getElementsByTagName("script")[0],a.async=!0,a.src="//ajax.cloudflare.com/cdn-cgi/nexp/dok2v=97fb4d042e/cloudflare.min.js",b.parentNode.insertBefore(a,b)}()}}catch(e){};
        //]]>
    </script>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="js/modernizr.js"></script>
    <!-- Google analitycs -->
    <script type="text/javascript">
        /*var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-44648472-1']);
        // Recommanded value by Google doc and has to before the trackPageView
        _gaq.push(['_setSiteSpeedSampleRate', 5]);
        _gaq.push(['_trackPageview', 'product']);
        (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();*/
    </script>
    <!-- Desabilita la opcion de seleccionar texto -->
    <script type="text/javascript">
        function disableselect(e){return false }
        function reEnable(){return true}
        //if IE4 
        // disable text selection        
        //if NS6
        if (window.sidebar){
            //document.onmousedown=disableselect
            // the above line creates issues in mozilla so keep it commented.
            document.onclick=reEnable
        }
        function clickIE(){
            if (document.all){
                  (message);
                  return false;
            }
        }
    </script>
    <!-- Desabilita la opcion de click derecho -->
    <script type="text/javascript">
        // disable right click
        window.onerror = new Function("return true");
        //No permite seleccionar el contenido de una página 
        document.oncontextmenu = function(){return false};
    </script>
    <!-- Borrar el portapapeles con el uso de teclado -->
    <script type="text/javascript">
        //Borra el Portapapeles con el uso del teclado
        if (document.layers)
            document.captureEvents(Event.KEYPRESS)
        function backhome(e){
            window.clipboardData.clearData();
        }
    </script>
</head>
<body class="bg-primary"><?php 
    if(!isset($_SESSION['user_id'])){?>
        <!-- Div de carga de la pagina -->
        <div class="espere">
            <div id="cargar_gif"></div>
            <!-- <div id="cargar_blanco"></div> -->
            <div id="cargar_texto">Cargando espere un momento por favor...</div>
        </div>
        <div class="cover"></div>
        <div class="overlay bg-primary"></div>
        <div class="center-wrapper">
            <div class="center-content">
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                        <section class="panel bg-white no-b">
                            <div class="tab-content text-center">
                                <!-- formulario de ingreso -->
                                <div id="ingreso"  class="p15 tab-pane fade active in">
                                    <form id="login_form" name="login_form" role="form" action="">
                                        <div class="form-group">
                                            <input id="email" name="email" type="email" class="form-control input-lg mb25" placeholder="Correo Electrónico" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input id="password" name="password" type="password" class="form-control input-lg mb25" placeholder="Clave">
                                        </div>
                                        <div class="show">
                                            <div class="pull-right">
                                                <a href="#olvido" data-toggle="tab">¿Olvidó su clave?</a>
                                            </div>
                                        </div>
                                        <button id="Ingresar" class="btn btn-success btn-lg btn-block" type="submit">Ingresar</button>
                                    </form>
                                </div>
                                <!-- formulario de olvido contraseña -->
                                <div id="olvido" class="p15 tab-pane fade">
                                    <p class="text-center mb25">¿Olvidó su clave?
                                        <div class="text-center">Por favor ingrese su correo electrónico.</div>
                                        <div class="text-center">Recibirá su nueva clave para poder ingresar.</div>
                                    </p>
                                    <form id="olvido_form" name="olvido_form" role="form" action="">
                                        <input id="email_olvido" name="email_olvido" type="email" class="form-control input-lg mb25" placeholder="Correo Electrónico" autofocus>
                                        <button class="btn btn-success btn-lg btn-block" type="submit">Enviar Clave</button>
                                    </form>
                                </div>
                            </div>
                        </section>
                        <p class="text-center">
                            Copyright &copy;
                            <span id="year" class="mr5"></span>
                            <span>R + B Diseño Experimental S.A.S.</span>
                        </p>
                    </div>
                </div>
            </div>
        </div><?php 
    }
    else{?>
        <script>window.location = "intranet/"</script><?php
    }?>
    <script type="text/javascript">
        var el = document.getElementById("year"),
        year = (new Date().getFullYear());
        el.innerHTML = year;
    </script>

    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/sweet-alert.min.js"></script><!-- Personalizar alertas -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrapValidator.min.js"></script>

    <script>
        $(document).ready(function() {
            // Funcion que se ejecuta para ver el mensaje de cargando
            function espereshow ()
            {
                $('.espere').fadeIn('fast');
            }
            //  Función que se ejecuta para ocultar el mensaje de cargando
            function esperehide() {
                $('.espere').fadeOut('slow');
            }
            // validación formulario de ingreso
            $("#login_form").bootstrapValidator({
                message: 'Este valor no es valido',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        message: 'El email no es valido',
                        validators: {
                            notEmpty: {
                                message: 'El email es requerido'
                            },
                            emailAddress: {
                                message: 'El email no es valido'
                            }
                        }
                    },
                    password: {
                        message: 'La clave no es valido',
                        validators: {
                            notEmpty: {
                                message: 'La clave es requerido'
                            },
                            stringLength: {
                                min: 5,
                                max: 45,
                                message: 'La clave debe contener de 5 a 45 characteres'
                            },
                            regexp: {
                                regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ@#$%&*-_.]+$/,
                                message: 'La clave debe contener letras, números, "_", "#", "@" y/o ".".'
                            }
                        }
                    }
                }
            })
            .on('success.form.bv', function(e) {
                espereshow();
                e.preventDefault();
                //Trer los datos de la shema de la tabla seleccionada
                $.ajax({
                    url:"php/val_user.php",
                    cache:false,
                    type:"POST",
                    data:"email="+email.value+"&password="+password.value,
                    success: function(datos){
                        if(datos !== ''){
                            setTimeout(esperehide(), 500);
                            swal({
                                title: "Felicidades!",
                                text: datos,
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#94B86E"
                            },
                            function(){
                                espereshow();
                                window.location = "./intranet/";
                            });
                        }
                        else{
                            setTimeout(esperehide(), 500);
                            swal({
                                title: "Error!",
                                text: "Email y/o Password incorrecto.",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                            return;
                        }
                    }
                });
            });
            // Validación formulario de olvido
            $("#olvido_form").bootstrapValidator({
                message: 'Este valor no es valido',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    email: {
                        message: 'El email no es valido',
                        validators: {
                            notEmpty: {
                                message: 'El email es requerido'
                            },
                            emailAddress: {
                                message: 'El email no es valido'
                            }
                        }
                    }
                }
            })
            .on('success.form.bv', function(e) {
                espereshow();
                e.preventDefault();
                //Trer los datos de la shema de la tabla seleccionada
                $.ajax({
                    url:"php/gen_pass.php",
                    cache:false,
                    type:"POST",
                    data:"email="+email_olvido.value,
                    success: function(datos){
                        if(datos !== ''){
                            setTimeout(esperehide(), 500);
                            swal({
                                title: "Felicidades!",
                                text: "Revise su correo e ingrese nuevamente",
                                type: "success",
                                confirmButtonText: "Continuar",
                                confirmButtonColor: "#94B86E"
                            },
                            function(){
                                espereshow();
                                window.location = "./";
                            });
                        }
                        else{
                            setTimeout(esperehide(), 500);
                            swal({
                                title: "Error!",
                                text: "Email incorrecto o no registrado.",
                                type: "error",
                                confirmButtonText: "Aceptar",
                                confirmButtonColor: "#E25856"
                            });
                            return;
                        }
                    }
                });
            });
            setTimeout(esperehide(), 500);
        });
    </script>
</body>
</html>
