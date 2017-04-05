<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
ob_start();
if(isset($_GET["emp_id"])){$emp_id = $_GET["emp_id"];}
else{$emp_id = "";}
$res_bus = empleadoBuscarId($emp_id);
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $id = $row[0];
        $nom = $row[1];
        $ape = $row[2];
        $ndoc = $row[3];
        $dir = $row[4];
        $ind = $row[5];
        $areat = $row[6];
        if($areat <> ''){$tel .= $areat." ";}
        $telf = $row[7];
        if($telf <> ''){$tel .= $telf." ";}
        $ext = $row[8];
        if(($ext <> '')&&($ext <> 0)){$tel .= "Ext. ".$ext." ";}
        $telc = $row[9];
        if($telc <> ''){$tel .= "Cel. ".$telc." ";}
        $emailc = $row[10];
        $emailp = $row[11];
        $fnac = $row[12];
        $obs = $row[13];
        $pub = $row[14];
        $pad = $row[15];
        $nome = $row[17];
        $tele = $row[18];
        $user = $row[20];
        $tdoc = nombreCampo($row[21], "e3_tdoc");
        $tcont = nombreCampo($row[22], "e3_perf");
        // $emp = nombreCampo($row[23], "e3_emp");
        $est = nombreCampo($row[24], "e3_est");
        $carg = nombreCampo($row[25], "e3_carg");
        $area = nombreCampo($row[26], "e3_area");
        $ciu = nombreCampo($row[27], "e3_ciu");
        $tipoc = nombreCampo($row[28], "e3_tcont");
        $tpers = nombreCampo($row[29], "e3_tper");
        $perf = $row[30];
        $empp = $row[31];
        $gen = $row[32];
        $sal = $row[33];
        $fing = $row[34];
        $card = $row[35];
        $hora = $row[36];
        $door = $row[37];
        $img = $row[38];
        $cta = $row[39];
        $ban = nombreCampo($row[40], "e3_ban");;
        $pval = $row[41];
        $pent = $row[42];
        $pfch = $row[43];
        $tcon = nombreCampo($row[44], "e3_tcon");
        $rh = $row[45];
        $res_emp = registroCampo('e3_emp', '*', 'WHERE e3_emp_id = "'.$row[23].'"', '', '');
        if($res_emp){
            if(mysql_num_rows($res_emp) > 0){
                $row_emp = mysql_fetch_array($res_emp);
                $empr_nom = $row_emp[1];
                $empr_doc = $row_emp[2];
                $empr_dir = $row_emp[3];
                $empr_tel = $row_emp[4];
                $empr_fax = $row_emp[5];
                $empr_img = base64_encode($row_emp[6]);
                $src = 'data: image/png;base64,'.$empr_img;
                $empr_web = $row_emp[7];
            }
            else{
                $empr_nom = "";
                $empr_doc = "";
                $empr_dir = "";
                $empr_tel = "";
                $empr_fax = "";
                $src = "";
                $empr_web = "";
            }
        }
        else{
            $empr_nom = "";
            $empr_doc = "";
            $empr_dir = "";
            $empr_tel = "";
            $empr_fax = "";
            $src = "";
            $empr_web = "";
        }
        $res_hor = registroCampo('e3_horario', 'MIN(e3_horario_dia) AS min, MAX(e3_horario_dia) AS max, e3_horario_hent, e3_horario_hsal', 'WHERE e3_user_id = "'.$emp_id.'" AND e3_horario_dia < 8', 'GROUP BY e3_horario_hent, e3_horario_hsal', 'ORDER BY e3_horario_dia ASC');
        $res_seg = registroCampo('e3_segsoc', '*', 'WHERE e3_user_id = "'.$emp_id.'"', '', 'ORDER BY e3_segsoc_nom ASC');
        $res_std = registroCampo('e3_std', '*', 'WHERE e3_user_id = "'.$emp_id.'"', '', 'ORDER BY e3_std_fini ASC');
        $res_lab = registroCampo('e3_lab', '*', 'WHERE e3_user_id = "'.$emp_id.'"', '', 'ORDER BY e3_lab_fini ASC');
    }
    else
    {
        $accion = "Nuevo Empleado";
        $nom = "";
        $ape = "";
        $ndoc = "";
        $dir = "";
        $ind = "";
        $areat = "";
        $telf = "";
        $ext = "";
        $telc = "";
        $emailc = "";
        $emailp = "";
        $fnac = "";
        $obs = "";
        $pub = "";
        $pad = "";
        $nome = "";
        $tele = "";
        $user = "";
        $tdoc = "";
        $tcont = "";
        $emp = "";
        $est = "";
        $carg = "";
        $area = "";
        $ciu = "";
        $tipoc = "";
        $tpers = "";
        $perf = "";
        $empp = "";
        $gen = "";
        $sal = "";
        $fing = "";
        $card = "";
        $fent = "";
        $fsal = "";
        $img = "";
        $cta = "";
        $ban = "";
        $pval = "";
        $pent = "";
        $pfch = "";
        $tcon = "";
        $rh = "";
    }
}
else
{
    $accion = "Nuevo Empleado";
    $nom = "";
    $ape = "";
    $ndoc = "";
    $dir = "";
    $ind = "";
    $areat = "";
    $telf = "";
    $ext = "";
    $telc = "";
    $emailc = "";
    $emailp = "";
    $fnac = "";
    $obs = "";
    $pub = "";
    $pad = "";
    $nome = "";
    $tele = "";
    $user = "";
    $tdoc = "";
    $tcont = "";
    $emp = "";
    $est = "";
    $carg = "";
    $area = "";
    $ciu = "";
    $tipoc = "";
    $tpers = "";
    $perf = "";
    $empp = "";
    $gen = "";
    $sal = "";
    $fing = "";
    $card = "";
    $fent = "";
    $fsal = "";
    $img = "";
    $cta = "";
    $ban = "";
    $pval = "";
    $pent = "";
    $pfch = "";
    $tcon = "";
    $rh = "";
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Edificio Eco Empresarial</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Cache-Control" content="max-age=0, no-cache, no-store, private"> 
        <meta http-equiv="Pragma" content="nocache">
        <meta name="description" content="Intranet Grupo Empresarial Eco Empresarial">
        <meta name="keywords" content="Tributar Asesores, Coveg Auditores, R + B Diseño Experimental, Editores Hache">
        <meta name="author" content="Wilson Velandia">
        <!-- iconos para web apps y favicon -->
        <link rel="shortcut icon" href="../img/favicon.ico" />
        <link rel="apple-touch-icon" href="../img/icono_57.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="../img/icono_72.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="../img/icono_114.png" />
        <!-- Main stylesheet -->
        <link rel="stylesheet" href="../style/style.css">
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <!-- HTML5 Support for IE -->
        <!--[if lt IE 9]>
        <script src="../js/html5shim.js"></script>
        <![endif]-->
        <!-- Favicon -->
        <style>
            legend{
                font-size: 16px;
                line-height: 8px;
                margin-bottom: 10px;
                margin-top: 10px;
            }
            .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12
            {
                position: relative;
                float: none;
                font-size: 12px;
                line-height: 6px;
                margin-top: 0px;
                margin-left: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
                padding-top: 0px;
                padding-left: 0px;
                padding-right: 0px;
                padding-bottom: 0px;
            }
        </style>
    </head>
    <body>
        <div style="margin-bottom:30px;">&nbsp;</div>
        <div style="margin-bottom:30px;">&nbsp;</div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <br><br><br>
            <!-- Datos personales -->
            <legend class="text-right">Datos Personales</legend>
            <div style="display:inline-block;line-height:6px;width:16.66666667%;position:relative;">
                <img src="<?php echo $img;?>" class="img-rounded" alt="Foto" style="max-width:90px;max-height:120px;text-align:left">
            </div>
            <div style="display:inline-block;line-height:6px;width:83.33333333%;position:absolute;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Nombre: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo strtoupper($nom." ".$ape);?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for=""><?php echo $tdoc.": ";?></label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $ndoc;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Dirección: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $dir;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Teléfono(s): </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $tel;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Email Corporativo: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $emailc;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Email Personal: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $emailp;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha de Nacimiento: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $fnac;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Grupo Sanguíneo y RH: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $rh;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">En caso de emergencia: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $nome;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Telefono contacto: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $tele;?></div>
                </div>
            </div>
            <!-- Datos del contrato -->
            <legend class="text-right">Datos Contrato</legend>
            <div style="display:inline-block;line-height:6px;width:16.66666667%;position:relative;"></div>
            <div style="display:inline-block;line-height:6px;width:83.33333333%;position:relative;">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Empresa: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $empr_nom;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha de ingreso: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $fing;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Tipo contrato: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $tcon;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Cargo: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $carg;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Área: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $area;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Salario: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo number_format($sal);?></div>
                </div>
                <?php if(($pval <> '')&&($pval > 0)){?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Val Ahorro Vol.: </label>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $pval;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Entidad Ahorro: </label>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $pent;?></div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha Ahorro: </label>
                        <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $pefch;?></div>
                    </div>
                <?php }?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">No. Carnét: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $card;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Puerta ingreso: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo "Piso ".$door;?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Cuenta Nomina: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php if($cta <> ''){echo $cta." - ".$ban;}else{echo " - o - ";}?></div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Horario: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php 
                        if($res_hor){
                            if(mysql_num_rows($res_hor) > 0){
                                $nreg = mysql_num_rows($res_hor);
                                $sq = 1;
                                while($row_hor = mysql_fetch_array($res_hor)){
                                    $hor_min = diasTres($row_hor[0]);
                                    $hor_max = diasTres($row_hor[1]);
                                    $hor_ent = date("h:i", strtotime($row_hor[2]));
                                    $hor_sal = date("h:i", strtotime($row_hor[3]));
                                    // if($sq == $nreg){echo " y ";}
                                    if($hor_min <> $hor_max){
                                        echo $hor_min." a ".$hor_max." de ".$hor_ent." AM a ".$hor_sal." PM<br>";
                                    }
                                    else{
                                        echo $hor_min." de ".$hor_ent." AM. a ".$hor_sal." PM<br>";
                                    }
                                    $sq += 1;
                                    // if($sq > $nreg){echo "<br>";}
                                }
                            }
                            else{echo "No tiene horario";}
                        }?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                    <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Afiliaciones: </label>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php 
                        if($res_seg){
                            if(mysql_num_rows($res_seg) > 0){
                                $sq = 1;
                                while($row_seg = mysql_fetch_array($res_seg)){
                                    echo $row_seg[1]." - ".$row_seg[2];
                                    if($sq < mysql_num_rows($res_seg)){echo "<br><br>";}
                                    $sq += 1;
                                }
                            }
                            else{echo "No tiene afiliaciones";}
                        }?>
                    </div>
                </div>
            </div>
            <!-- Estudios Realizados -->
            <legend class="text-right">Estudios Realizados</legend>
            <div style="display:inline-block;line-height:6px;width:16.66666667%;position:relative;"></div>
            <div style="display:inline-block;line-height:6px;width:83.33333333%;position:relative;">
                <?php 
                if($res_std){
                    if(mysql_num_rows($res_std) > 0){
                        while($row_std = mysql_fetch_array($res_std)){?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Institución: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_std[1];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Tipo: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo nombreCampo($row_std[2], "e3_tstd");?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Titulo: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_std[3];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha inicio: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_std[4];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha finalización: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_std[5];?></div>
                            </div>
                            <?php if($row_std[7] <> ''){?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">No. Tarj. Prof.: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_std[7];?></div>
                            </div><?php 
                            }?>
                            <div style="margin-bottom:10px;">&nbsp;</div><?php 
                        }
                    }
                    else{echo "No tiene estudios realizados";}
                }?>
            </div>
            <!-- Experiencia Laboral -->
            <legend class="text-right">Experiencia Laboral</legend>
            <div style="display:inline-block;line-height:6px;width:16.66666667%;position:relative;"></div>
            <div style="display:inline-block;line-height:6px;width:83.33333333%;position:relative;">
                <?php 
                if($res_lab){
                    if(mysql_num_rows($res_lab) > 0){
                        while($row_lab = mysql_fetch_array($res_lab)){?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Empresa: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[1];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Cargo: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[2];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha ingreso: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[3];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Fecha retiro: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[4];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Jefe inmediato: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[5];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Teléfono: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[6];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Email: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[7];?></div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                                <label class="col-xs-4 col-sm-4 col-md-4 col-lg-4 control-label pull-left" style="display:inline-block;line-height:6px;" for="">Motivo retiro: </label>
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 pull-right" style="display:inline-block;line-height:6px;"><?php echo $row_lab[8];?></div>
                            </div><?php 
                        }?>
                        <div style="margin-bottom:10px;">&nbsp;</div><?php 
                    }
                    else{echo "No tiene experiencia laboral";}
                }?>
            </div>
        </div>
        <script type="text/javascript" src="../js/jquery.min.js"></script> <!-- jQuery -->
        <script type="text/javascript" src="../js/bootstrap.min.js"></script> <!-- Bootstrap -->
    </body>
</html>
<?php
    require_once("../php/dompdf/dompdf_config.inc.php");
    $dompdf = new DOMPDF();
    $dompdf->load_html(ob_get_clean());
    $dompdf->render();
    $pdf = $dompdf->output();
    $filename = "CV ".$nom." ".$ape.".pdf";
    // file_put_contents($filename, $pdf);
    $dompdf->stream($filename);
?>