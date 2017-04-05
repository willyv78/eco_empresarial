<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$res_menu = menuBuscar();
$img = "";$regla = "";$emp="1";
$fechahoy = date('Y-m-d');
if(isset($_SESSION['user_perf']))
{
    $sess_perf = $_SESSION['user_perf'];
    $perfil = $_SESSION['user_nom']. " " .$_SESSION['user_ape'];
    // traemos la foto del usuario registrado
    $res = registroCampo("e3_user", "e3_user_img", "WHERE e3_user_id = '".$_SESSION['user_id']."'", "", "");
    if($res){
        if(mysql_num_rows($res) > 0){
            $row = mysql_fetch_array($res);
            $img = $row[0];
        }
    }
    // traemos la empresa del usuario registrado
    $res_emp = registroCampo("e3_cont", "e3_emp_id", "WHERE e3_user_id = '".$_SESSION['user_id']."' AND (e3_cont_ffin ='0000-00-00' OR e3_cont_ffin IS NULL)", "", "");
    if($res_emp){
        if(mysql_num_rows($res_emp) > 0){
            $row_emp = mysql_fetch_array($res_emp);
            $emp = $row_emp[0];
        }
    }
    // traemos los documentos que deben leer los usuarios
    $res_docs = registroCampo("e3_docs", "e3_docs_id, e3_docs_nom, e3_docs_emp, e3_docs_url", "WHERE e3_docs_emp LIKE '%$emp%'", "", "");
    if($res_docs){
        if(mysql_num_rows($res_docs) > 0){
            $sw = 0;
            $regla = "";
            $num_docs = mysql_num_rows($res_docs);
            while($row_docs = mysql_fetch_array($res_docs)){
                $res_regla = registroCampo("e3_regla", "e3_regla_id", "WHERE e3_regla_nom = '".$row_docs[0]."' AND e3_regla_user = '".$_SESSION['user_id']."'", "", "");
                if($res_regla){
                    if(mysql_num_rows($res_regla) == 0){
                        if($sw == 0){$regla .= $row_docs[0];}
                        else{
                            if($regla == ''){$regla .= $row_docs[0];}
                            else{$regla .= ",".$row_docs[0];}
                        }
                    }
                }
                $docs_id[$sw] = $row_docs[0];
                $docs_nom[$sw] = $row_docs[1];
                $docs_url[$sw] = $row_docs[3];
                $sw++;
            }
        }
    }
    // permisos por modulo
    $res_perm = registroCampo("e3_perm", "e3_mod_id, e3_perm_perm", "WHERE e3_perf_id = ".$_SESSION['user_perf'], "", "");
    $rows_perm = array();
    if($res_perm){
        if(mysql_num_rows($res_perm) > 0){
            while($row_perm = mysql_fetch_array($res_perm)){
                $rows_perm[$row_perm[0]] = array('modulo' => $row_perm[0], 'permisos' => $row_perm[1]);
            }
        }
    }?>
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Edificio Eco Empresarial</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="Cache-Control" content="max-age=0, no-cache, no-store, private"> 
            <meta http-equiv="Pragma" content="nocache">
            <meta name="description" content="Intranet Grupo Empresarial Eco Empresarial">
            <meta name="keywords" content="Tributar Asesores, Coveg Auditores, R + B Diseño Experimental, Editores Hache">
            <meta name="author" content="Wilson G. Velandia B. @willyv78">
            <!-- iconos para web apps y favicon -->
            <link rel="shortcut icon" href="../img/favicon.ico" />
            <link rel="apple-touch-icon" sizes="76x76" href="../img/icono_76.png">
            <link rel="apple-touch-icon" sizes="120x120" href="../img/icono_120.png">
            <link rel="apple-touch-icon" sizes="152x152" href="../img/icono_152.png">
            <link rel="stylesheet" href="../style/font-awesome.css"> 
            <link rel="stylesheet" href="../style/fullcalendar.css">
            <link rel="stylesheet" href="../style/bootstrap-datepicker.min.css">
            <link rel="stylesheet" href="../style/bootstrapValidator.min.css"/>
            <link rel="stylesheet" href="../style/bootstrap.min.css">
            <link rel="stylesheet" href="../style/bootstrap-datetimepicker.min.css">
            <link rel="stylesheet" href="../style/sweet-alert.css">
            <!-- estilos para framework DataTables -->
            <link rel="stylesheet" href="../style/jquery.dataTables.min.css">
            <link rel="stylesheet" href="../style/dataTables.tableTools.min.css">
            <link rel="stylesheet" href="../style/dataTables.jqueryui.css">
            <link rel="stylesheet" href="../style/jquery-ui.css">
            <!-- Main stylesheet -->
            <link rel="stylesheet" href="../style/style.css">
            <!-- HTML5 Support for IE -->
            <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
            <![endif]-->
            <!-- Favicon -->
        </head>
        <body>
            <!-- Div de carga de la pagina -->
            <div class="espere">
                <div id="cargar_gif"></div>
                <!-- <div id="cargar_blanco"></div> -->
                <div id="cargar_texto">Cargando espere un momento por favor...</div>
            </div>
            <!-- Barra de navegación superior -->
            <div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
                <div class="containerk">
                    <!-- Menu button for smallar screens HEADER -->
                    <div class="navbar-header">
                        <!-- Menu superior minimizado en tres barras -->
                        <button class="navbar-toggle hidden-sm hidden-md hidden-lg" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                            <span class="sr-only">Menu Minimizado</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Titulo de la pagina suoerior izquierda -->
                        <a href="./" class="navbar-brand col-xs-4 col-sm-5 col-md-6 col-lg-7"><span class="bold"><span class="hidden-xs">Edificio Eco Empresarial - </span><span>E3</span></span></a>
                        <a href="#" class="nom-usu col-xs-4 col-sm-6 col-md-5 col-lg-4">
                            <span href="#emp_det_passwd" class="bold ver-nom hidden-xs menu_movil" data-original-title="Cambiar Contraseña" data-toggle="tooltip" data-placement="bottom" title=""><?php echo $_SESSION['user_nom'];?></span>
                            <i id="nav-cerrar" data-original-title="Salir" data-toggle="tooltip" data-placement="left" title="" class="glyphicon glyphicon-remove"></i>
                        </a>
                    </div>
                    <!-- Variables de session -->
                    <input id="user_id" type="hidden" value="<?php echo $_SESSION['user_id'];?>">
                    <input id="sess_user_perf" type="hidden" value="<?php echo $_SESSION['user_perf']; ?>">
                    <input id="sess_user_mail" type="hidden" value="<?php echo $_SESSION['user_mail']; ?>">
                    <input id="regla" type="hidden" value="<?php echo $regla;?>">
                    <!-- Menu para dispocitivos moviles -->
                    <nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Biblioteca -->
                            <?php if($rows_perm[5]){?>
                            <li class="dropdown blightblue">
                                <a class="dropdown-toggle menu_movil"  href="#biblioteca">
                                    <i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;Biblioteca
                                </a>
                            </li>
                            <?php }?>
                            <!-- Calendario -->
                            <?php if($rows_perm[2]){?>
                            <li class="dropdown bviolet">
                                <a class="dropdown-toggle menu_movil" href="#calendario" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;Calendario
                                    <!-- <span class="badge">3</span> -->
                                </a>
                            </li>
                            <?php }?>
                            <!-- Configuración -->
                            <?php if($rows_perm[8]){?>
                            <li class="dropdown navbar-default">
                                <a class="dropdown-toggle menu_movil" href="#configuracion" style="color:#777 !important;">
                                    <i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Configuración
                                </a>
                            </li>
                            <?php }?>
                            <!-- Contactos -->
                            <?php if($rows_perm[3]){?>
                            <li class="statistics-toggle bblack">
                                <a href="#contactos" class="menu_movil">
                                    <i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;Contactos
                                    <!-- <span class="badge">2</span> -->
                                </a>
                            </li>
                            <?php }?>
                            <!-- Pausas Activas -->
                            <li class="dropdown borange">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;Pausas Activas
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu borange">
                                    <li>
                                        <a name="1" class="menu_movil" href="#pausas">
                                            <i class="glyphicon glyphicon-list-alt"></i>
                                            &nbsp;&nbsp;7:00 AM
                                        </a>
                                    </li>
                                    <li>
                                        <a name="2" class="menu_movil" href="#pausas">
                                            <i class="glyphicon glyphicon-list-alt"></i>
                                            &nbsp;&nbsp;9:30 AM
                                        </a>
                                    </li>
                                    <li>
                                        <a name="3" class="menu_movil" href="#pausas">
                                            <i class="glyphicon glyphicon-list-alt"></i>
                                            &nbsp;&nbsp;3:30 PM
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- Perfil -->
                            <li class="dropdown bred">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Perfil
                                    <b class="caret"></b>
                                </a>
                                <!-- Dropdown menu -->
                                <ul class="dropdown-menu bred">
                                    <li><a href="#emp_det_temp" class="menu_movil"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Ver Hoja de Vida</a></li>
                                    <li><a href="#emp_det_passwd" class="menu_movil"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Cambiar Contraseña</a></li>
                                    <li class="divider"></li>
                                    <li id="menu_movil_cerrar"><a><i class="glyphicon glyphicon-off"></i>&nbsp;&nbsp;Salir</a></li>
                                </ul>
                            </li>
                            <!-- Recursos Humanos -->
                            <?php if($rows_perm[1]){?>
                            <li class="dropdown bblue">
                                <!-- Nombre icono menu -->
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-hand-right"></i>&nbsp;&nbsp;RRHH
                                    <b class="caret"></b>
                                    <!-- <span class="badge">6</span> -->
                                </a>
                                <!-- Dropdown menu -->
                                <ul class="dropdown-menu bblue">
                                    <li><a class="menu_movil" href="#rrhh"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Empleados</a></li>
                                    <li>
                                        <a class="menu_movil" href="#solic"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Solicitudes</a>
                                        <!-- <span class="badge">6</span> -->
                                    </li>
                                    <li><a class="menu_movil" href="#ingreso"><i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Ingresos</a></li><?php 
                                    if(($sess_perf == '9') || ($sess_perf == '1')){?>
                                        <li><a class="menu_movil" href="#emp_list_inactivo"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Empleados Inactivos</a></li><?php 
                                    }?>
                                </ul>
                            </li>
                            <?php }?>
                            <!-- Reglamento -->
                            <?php if($rows_perm[9]){?>
                            <li class="dropdown borange">
                                <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;Reglamento
                                    <b class="caret"></b>
                                    <!-- <span class="badge badge-success">4</span> -->
                                </a>
                                <!-- Dropdown menu -->
                                <ul class="dropdown-menu borange"><?php 
                                    for($i = 0; $i < $num_docs; $i++){?>
                                        <li>
                                            <a href="<?php echo $docs_url[$i];?>" target="_blank">
                                                <?php echo $docs_nom[$i];?>
                                            </a>
                                        </li><?php 
                                    }?>
                                </ul>
                            </li>
                            <?php }?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Main content starts -->
            <div id="div_contenido" class="content">
                <!-- Barra de navegacion menu izquierda -->
                <div class="sidebar sidebar-fixed">
                    <!-- Titulo de la barra de menu en tamaño pequeño -->
                    <div class="sidebar-dropdown"><a href="#">Menú</a></div>
                    <div class="sidebar-inner">
                        <!--- Sidebar navigation -->
                        <!-- If the main navigation has sub navigation, then add the class "has_submenu" to "li" of main navigation. -->
                        <!-- Titulo del menu izquierdo -->
                        <div class="sidebar-title">
                            <span class="message">Menú</span>
                            <span class="glyphicon glyphicon-resize-small pull-right" name="navi" aria-hidden="true"></span>
                        </div>
                        <!-- Menú izquierdo -->
                        <ul class="navi"><?php 
                            if($res_menu)
                            {
                                if(mysql_num_rows($res_menu) > 0)
                                {
                                    while ($row_menu = mysql_fetch_array($res_menu))
                                    {
                                        $id_mod = $row_menu[2];
                                        // RRHH
                                        if(($id_mod == '1') && ($rows_perm[1])){?>
                                            <li>
                                                <a name=""><?php echo $row_menu[0];?></a>
                                                <ul class="submenuizq" id="rrhh">
                                                    <li>
                                                        <a name="<?php echo $row_menu[1];?>">
                                                            Empleados
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a name="solic">
                                                            Solicitudes
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a name="ingreso">
                                                            Ingreso
                                                        </a>
                                                    </li><?php 
                                                    if(($sess_perf == '9') || ($sess_perf == '1')){?>
                                                        <li>
                                                            <a name="emp_list_inactivo">
                                                                Empleados Inactivos
                                                            </a>
                                                        </li><?php 
                                                    }?>
                                                </ul>
                                            </li><?php
                                        }
                                        // Reglamentos
                                        else if(($id_mod == '9') && ($rows_perm[9])){?>
                                            <li>
                                                <a name=""><?php echo $row_menu[0];?></a>
                                                <ul class="submenuizq" id="reglamento"><?php 
                                                    for($i = 0; $i < $num_docs; $i++){?>
                                                        <li>
                                                            <a href="<?php echo $docs_url[$i];?>" target="_blank" data-original-title="<?php echo $docs_nom[$i];?>" data-toggle="tooltip" data-placement="bottom" title="">
                                                                <?php echo getSubString($docs_nom[$i], 22);?>
                                                            </a>
                                                        </li><?php 
                                                    }?>
                                                </ul>
                                            </li><?php 
                                        }
                                        else{
                                            if(isset($rows_perm[$id_mod]['modulo'])){?>
                                            <li>
                                                <a id="menu_<?php echo $row_menu[1];?>" name="<?php echo $row_menu[1];?>">
                                                     <?php echo $row_menu[0];?>
                                                </a>
                                            </li><?php 
                                            }
                                        }
                                    }
                                }   
                            }?>
                            <!-- Pausas Activas -->
                            <li>
                                <a name="">Pausas Activas</a>
                                <ul class="submenuizq" id="pausas">
                                    <li>
                                        <a id="1" name="pausas">
                                            7:00 AM
                                        </a>
                                    </li>
                                    <li>
                                        <a id="2" name="pausas">
                                            9:30 AM
                                        </a>
                                    </li>
                                    <li>
                                        <a id="3" name="pausas">
                                            3:30 PM
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <!-- Fin del menu izquierdo -->

                        <!-- Inicio notificaciones calendario -->
                        <div class="sidebar-title">
                            <span class="message">Notificaciones</span>
                            <span class="glyphicon glyphicon-resize-small pull-right" name="notifications" aria-hidden="true"></span>
                        </div>
                        <ul class="notifications"></ul>
                        <!-- Fin notificaciones menu izquierdo -->

                    </div>
                </div>
                <!-- final barra de menu izquierdo -->

              	<!-- contenido de la pagina -->
              	<div class="mainbar">
                    <!-- mapa del sitio y otros links -->
                    <div class="page-head hidden-xs">
                        <!-- Page heading -->
                        <!-- Breadcrumb MAPA DEL SITIO -->
                        <!-- Izquierda -->
                        <div class="bread-crumb">
                            <a href="./"><i class="glyphicon glyphicon-home"></i>Inicio</a>
                        </div>
                        <!-- Opciones Derecha despues del mapa del sitio -->
                        <ul class="crumb-buttons">
                            <li class="first">
                                <a class="menu_movil" title="Solicitudes"  href="#solic">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                    <span>Solicitudes</span>
                                </a>
                            </li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" title="">
                                    <i class="glyphicon glyphicon-comment"></i>
                                    <span>Contactos</span>
                                    <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a class="menu_movil" title="Nuevo Contacto"  href="#cont_det_ed">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            Nuevo Contacto
                                        </a>
                                    </li>
                                    <li>
                                        <a class="menu_movil" title="Ver contactos"  href="#contactos">
                                            <i class="glyphicon glyphicon-reorder"></i>
                                            Ver contactos
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="range">
                                <a class="menu_movil" title="Ver contactos"  href="#calendario">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    <span><?php echo date("Y-m-d") ?></span>
                                </a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix visible-xs-*"></div>
                    <!-- Final del mapa del sitio y otros links -->
            	    <!-- Matter Contenido de la pagina -->
            	    <div class="matter">
                        <div class="container">
                            <!-- Contenedor del contenido de la pagina -->
                            <div class="row">
                                
                                <!-- Menu para dispositivos moviles -->
                                <div id="menushort" class="panel-group hidden-sm hidden-md hidden-lg" id="accordion">
                                    <div class="widget"></div>
                                    <!-- Biblioteca -->
                                    <?php if($rows_perm[5]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading blightblue">
                                            <h4 class="panel-title">
                                                <a class="menu_movil" href="#biblioteca" data-toggle="collapse" data-parent="#accordion"><i class="glyphicon glyphicon-book"></i>&nbsp;&nbsp;Biblioteca</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- Calendario -->
                                    <?php if($rows_perm[2]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading bviolet">
                                            <h4 class="panel-title">
                                                <a class="menu_movil" href="#calendario" data-toggle="collapse" data-parent="#accordion"><i class="glyphicon glyphicon-calendar"></i>&nbsp;&nbsp;Calendario</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- Configuración -->
                                    <?php if($rows_perm[8]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="menu_movil" href="#configuracion" data-toggle="collapse" data-parent="#accordion"><i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Configuración</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- Contactos -->
                                    <?php if($rows_perm[3]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading bblack">
                                            <h4 class="panel-title">
                                                <a class="menu_movil" href="#contactos" data-toggle="collapse" data-parent="#accordion"><i class="glyphicon glyphicon-comment"></i>&nbsp;&nbsp;Contactos</a>
                                            </h4>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- Pausas Activas -->
                                    <?php if($rows_perm[9]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading borange">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#menu_pausas"><i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;Pausas Activas <b class="caret"></b></a>
                                            </h4>
                                        </div>
                                        <div id="menu_pausas" class="panel-collapse collapse menu-phone borange">
                                            <div class="divider"><hr></div>
                                            <div>
                                                <a class="menu_movil" name="1" href="#pausas"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;7:00 AM</a>
                                            </div>
                                            <div>
                                                <a class="menu_movil" name="2" href="#pausas"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;9:30 AM</a>
                                            </div>
                                            <div>
                                                <a class="menu_movil" name="3" href="#pausas"><i class="glyphicon glyphicon-list-alt"></i>&nbsp;&nbsp;3:30 AM</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- Perfil -->
                                    <div class="panel panel-default">
                                        <div class="panel-heading bred">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#menu_perfil"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Perfil <b class="caret"></b></a>
                                            </h4>
                                        </div>
                                        <div id="menu_perfil" class="panel-collapse collapse menu-phone bred">
                                            <div class="divider"><hr></div>
                                            <div>
                                                <a class="menu_movil" href="#emp_det_temp"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Ver Hoja de Vida</a>
                                            </div>
                                            <div>
                                                <a class="menu_movil" href="#emp_det_passwd"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Cambiar Contraseña</a>
                                            </div>
                                            <div class="divider"><hr></div>
                                            <div id="menu_perfil_carrar">
                                                <a><i class="glyphicon glyphicon-off"></i>&nbsp;&nbsp;Salir</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- RRHH -->
                                    <?php if($rows_perm[1]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading bblue">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#menu_rrhh"><i class="glyphicon glyphicon glyphicon-link"></i>&nbsp;&nbsp;RRHH <b class="caret"></b></a>
                                            </h4>
                                        </div>
                                        <div id="menu_rrhh" class="panel-collapse collapse menu-phone bblue">
                                            <div class="divider"><hr></div>
                                            <div>
                                                <a class="menu_movil" href="#rrhh"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Empleados</a>
                                            </div>
                                            <div>
                                                <a class="menu_movil" href="#solic"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;Solicitudes</a>
                                            </div>
                                            <div>
                                                <a class="menu_movil" href="#ingreso"><i class="glyphicon glyphicon-cog"></i>&nbsp;&nbsp;Ingresos</a>
                                            </div><?php 
                                            if(($sess_perf == '9') || ($sess_perf == '1')){?>
                                                <div>
                                                    <a class="menu_movil" href="#emp_list_inactivo"><i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;Empleados Inactivos</a>
                                                </div><?php 
                                            }?>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <!-- Reglamento -->
                                    <?php if($rows_perm[9]){?>
                                    <div class="panel panel-default">
                                        <div class="panel-heading borange">
                                            <h4 class="panel-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#menu_regla"><i class="glyphicon glyphicon-check"></i>&nbsp;&nbsp;Reglamento <b class="caret"></b></a>
                                            </h4>
                                        </div>
                                        <div id="menu_regla" class="panel-collapse collapse menu-phone borange">
                                            <div class="divider"><hr></div><?php 
                                            for($i = 0; $i < $num_docs; $i++){?>
                                                <div>
                                                    <a href="<?php echo $docs_url[$i];?>" target="_blank">
                                                        <?php echo $docs_nom[$i];?>
                                                    </a>
                                                </div><?php 
                                            }?>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                                <!-- FIN Menu para dispositivos moviles -->


                                <!-- Aca se desplega el contenido de la pagina -->
                                <div id="col-md-12" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden"></div>
                                <!-- Fin del contenido de la pagina -->
                                

                                <!-- Variables de los permisos del usuario para cada modulo -->
                                <!-- Recursos Humanos -->
                                <input id="perm_mod_1" type="hidden" value="<?php if(isset($rows_perm[1]['permisos'])){echo $rows_perm[1]['permisos'];}?>">
                                <!-- Calendario -->
                                <input id="perm_mod_2" type="hidden" value="<?php if(isset($rows_perm[2]['permisos'])){echo $rows_perm[2]['permisos'];}?>">
                                <!-- Contactos -->
                                <input id="perm_mod_3" type="hidden" value="<?php if(isset($rows_perm[3]['permisos'])){echo $rows_perm[3]['permisos'];}?>">
                                <!-- Inventario -->
                                <input id="perm_mod_4" type="hidden" value="<?php if(isset($rows_perm[4]['permisos'])){echo $rows_perm[4]['permisos'];}?>">
                                <!-- Biblioteca -->
                                <input id="perm_mod_5" type="hidden" value="<?php if(isset($rows_perm[5]['permisos'])){echo $rows_perm[5]['permisos'];}?>">
                                <!-- Correo -->
                                <input id="perm_mod_6" type="hidden" value="<?php if(isset($rows_perm[6]['permisos'])){echo $rows_perm[6]['permisos'];}?>">
                                <!-- Chat -->
                                <input id="perm_mod_7" type="hidden" value="<?php if(isset($rows_perm[7]['permisos'])){echo $rows_perm[7]['permisos'];}?>">
                                <!-- Configuración -->
                                <input id="perm_mod_8" type="hidden" value="<?php if(isset($rows_perm[8]['permisos'])){echo $rows_perm[8]['permisos'];}?>">
                                <!-- Reglamento -->
                                <input id="perm_mod_9" type="hidden" value="<?php if(isset($rows_perm[9]['permisos'])){echo $rows_perm[9]['permisos'];}?>">
                                <!-- fin de valiables de permisos modulos -->

                            </div>
                        </div>
            		</div>
            		<!-- Matter final -->
                </div>
               <!-- Mainbar ends -->

               <div class="widget"></div>
            </div>
            <!-- Content ends -->
            <!-- Boton de ir a home se habilita cuando se hace scroll para configurar buscar funcion en el archivo custom.js en la carpeta js -->
            <span class="totop"><a href="#div_contenido"><i class="glyphicon glyphicon-chevron-up"></i></a></span> 
            <!-- Div de carga de formulario para ingreso de eventos al calendario -->
            <div class="ing-cal hidden">
                <div>
                    <h3>Cargando espere un momento por favor...</h3>
                </div>
            </div>
            <!-- Div de carga de reglamentos -->
            <div class="div-regla hidden"></div>
            <!-- jQuery -->
            <script src='../js/jquery.min.js'></script>
            <script src="../js/sweet-alert.min.js"></script>
            <script src="../js/bootstrap.min.js"></script> <!-- Bootstrap -->
            <script src="../js/e3.js"></script>
            <!-- Script for this page -->
            <script>
                opcMenu();
            </script>
        </body>
    </html><?php 
}
else{
    session_destroy();?>
    <script>
        alert("No ha iniciado Sesión");
        window.location = "../";
    </script><?php 
}?>