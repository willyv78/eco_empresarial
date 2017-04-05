<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
require_once ("../php/dompdf/dompdf_config.inc.php");
ob_start();
$fsolic = date('Y-m-d H:i');$obs = "";$user = "";$det = "A quien interese";$rep = "";$exp_id = "";$emp_nom = "";$emp_ape = "";$emp_carg = "";$emp_doc = "";$emp_cdoc = "";$emp_fing = "";$emp_sal = "";$emp_pval = "";$emp_pent = "";$emp_tcon = "";$empr_nom = "";$empr_doc = "";$empr_dir = "";$empr_tel = "";$empr_fax = "";$empr_img = "";$src = "";$empr_web = "";
if(isset($_GET["exp_id"])){$exp_id = $_GET["exp_id"];}
$res_bus = registroCampo("e3_solic", "e3_solic_fsolic, e3_solic_obs, e3_user_id, e3_solic_det, e3_solic_rep", "WHERE e3_solic_id = '$exp_id'", "", "");
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $fsolic = date('Y-m-d H:i', strtotime($row[0]));
        $obs = $row[1];
        $user = $row[2];
        $det = $row[3];
        $rep = $row[4];
    }
}
if($user <> ''){
    $res_emp = registroCampo('e3_user u', 'u.e3_user_nom, u.e3_user_ape, c.e3_carg_id, u.e3_user_doc, u.e3_user_fing, c.e3_cont_sal, e.e3_emp_nom, e.e3_emp_doc, e.e3_emp_dir, e.e3_emp_tel, e.e3_emp_fax, e.e3_emp_img, e.e3_emp_web, c.e3_cont_pval, c.e3_cont_pent, c.e3_tcon_id, c.e3_emp_id, c.e3_cont_fini, u.e3_user_cdoc', 'LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id LEFT JOIN e3_emp e ON e.e3_emp_id = c.e3_emp_id WHERE u.e3_user_id = "'.$user.'" AND (c.e3_cont_ffin = "0000-00-00" OR c.e3_cont_ffin IS NULL)', '', '');
    if($res_emp){
        if(mysql_num_rows($res_emp) > 0){
            $row_emp = mysql_fetch_array($res_emp);
            $emp_nom = strtoupper($row_emp[0]);
            $emp_ape = strtoupper($row_emp[1]);
            $emp_carg = nombreCampo($row_emp[2], "e3_carg");
            $emp_doc = $row_emp[3];
            $emp_cdoc = $row_emp[18];
            $emp_fing = strtotime($row_emp[4]);
            $emp_sal = $row_emp[5];
            $emp_pval = $row_emp[13];
            $emp_pent = $row_emp[14];
            $emp_tcon = nombreCampo($row_emp[15], "e3_tcon");
            $empr_nom = $row_emp[6];
            $empr_doc = $row_emp[7];
            $empr_dir = $row_emp[8];
            $empr_tel = $row_emp[9];
            $empr_fax = $row_emp[10];
            $empr_img = base64_encode($row_emp[11]);
            $src = 'data: '.mime_content_type($row_emp[11]).';base64,'.$empr_img;
            $empr_web = $row_emp[12];
            $empr_id = $row_emp[16];
            $cont_fini = strtotime($row_emp[17]);
            // Validamos el tipo de empresa para asignar que correos se envian y que logo se utiliza
            if($empr_id == '1'){
                $logo = "logoTributar";
                $rep_legal = "LILY E. VELÁSQUEZ GUTIÉRREZ";
            }
            elseif($empr_id == '2'){
                $logo = "logoCoveg";
                $rep_legal = "LILY E. VELÁSQUEZ GUTIÉRREZ";
            }
            elseif($empr_id == '3'){
                $logo = "logoRmasB";
                $rep_legal = "CARLOS FELIPE RAMOS VELÁSQUEZ";
            }
            elseif($empr_id == '4'){
                $logo = "logoHache";
                $rep_legal = "CARLOS FELIPE RAMOS VELÁSQUEZ";
            }
            elseif($_POST['emp_emp'] == '5'){
                $logo = "logoInversiones";
                $rep_legal = "LILY E. VELÁSQUEZ GUTIÉRREZ";
            }
        }
    }
    $res_hor = registroCampo('e3_horario', 'MIN(e3_horario_dia) AS min, MAX(e3_horario_dia) AS max, e3_horario_hent, e3_horario_hsal', 'WHERE e3_user_id = "'.$user.'" AND e3_horario_dia < 8 AND (e3_horario_ffin = "0000-00-00" OR e3_horario_ffin IS NULL)', 'GROUP BY e3_horario_hent, e3_horario_hsal', 'ORDER BY e3_horario_dia ASC');
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
        <!-- Font awesome icon -->
        <link rel="stylesheet" href="../style/font-awesome.css">
        <link rel="stylesheet" href="../style/jquery-ui.css"> 
        <link rel="stylesheet" href="../style/fullcalendar.css">
        <link rel="stylesheet" href="../style/bootstrapValidator.min.css"/>
        <link rel="stylesheet" href="../style/font.css">
        <link rel="stylesheet" href="../style/main_my.css">
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../style/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="../style/sweet-alert.css">
        <link rel="stylesheet" href="../style/style.css">
        <!-- HTML5 Support for IE -->
        <!--[if lt IE 9]>
        <script src="../js/html5shim.js"></script>
        <![endif]-->
        <!-- Favicon -->
    </head>
    <body>
        <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 text-center h5" style="margin:auto;float:none">
            <br /><br /><br /><br /><br /><br /><br />
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php 
                if($rep <> '1'){?>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        <?php echo "Bogotá, ".mesesLetras(date('m'))." ".date('d')." de ".date('Y');?>
                    </div>
                    <br /><br /><br /><br />
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        Referencia: Certificación Laboral
                    </div>
                    <br /><br /><br />
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                        Atento Saludo;
                    </div>
                    <br /><br /><br /><?php 
                }?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:justify;"><?php 
                    if($rep == '1'){
                        $sal_letras = new EnLetras();
                        $val_sal_letras = strtolower($sal_letras -> ValorEnLetras($emp_sal, "pesos M/CTE."));
                        $pat_letras = new EnLetras();
                        $val_pat_letras = strtolower($pat_letras -> ValorEnLetras($emp_pval, "pesos M/CTE."));?>
                        <br /><br /><br />
                        <p><h4 class="text-center">CERTIFICAMOS</h4></p>
                        <br /><br /><br />
                        <p>Que el(la) señor(a) <strong><?php echo $emp_nom." ".$emp_ape;?></strong> con cédula ciudadanía No. <strong><?php echo $emp_doc;?></strong><?php if($emp_cdoc <> ''){?> expedida en <strong><?php echo $emp_cdoc;?></strong><?php }?>,  labora en nuestra empresa desde el <strong><?php echo date("d", $cont_fini)." de ".strtoupper(mesesLetras(date('m', $cont_fini)))." del ".date('Y', $cont_fini);?></strong> desempeñando el cargo de <strong><?php echo $emp_carg;?></strong>, con un asignación mensual de <strong id="sal_letras"><?php echo $val_sal_letras;?></strong> (<strong>$<?php echo number_format($emp_sal);?></strong>) y tiene contrato a <strong><?php echo $emp_tcon;?></strong>.</p>
                        <?php if($emp_pval <> ''){?>
                            <p>La empresa le reconoce  mensualmente la suma de <strong id="pat_letras"><?php echo $val_pat_letras;?></strong> (<strong>$<?php echo number_format($emp_pval);?></strong>) como aporte de patrocinio el cual se consigna en <strong><?php echo $emp_pent;?></strong>.</p>
                            <p>El valor de los aportes  en salud y pensión los asume la empresa.</p>
                            <p>El horario de trabajo es de 
                                <?php 
                                    if($res_hor){
                                        if(mysql_num_rows($res_hor) > 0){
                                            $nreg = mysql_num_rows($res_hor);
                                            $sq = 0;
                                            while($row_hor = mysql_fetch_array($res_hor)){
                                                $hor_min = diasTodos($row_hor[0]);
                                                $hor_max = diasTodos($row_hor[1]);
                                                $hor_ent = date("h:i", strtotime($row_hor[2]));
                                                $hor_sal = date("h:i", strtotime($row_hor[3]));
                                                if($sq == $nreg){echo " y ";}
                                                if($hor_min <> $hor_max){
                                                    echo $hor_min." a ".$hor_max." de ".$hor_ent." AM a ".$hor_sal." PM";
                                                }
                                                else{
                                                    echo $hor_min." de ".$hor_ent." AM. a ".$hor_sal." PM";
                                                }
                                                if($sq < $nreg){echo ", ";}
                                                elseif($sq == $nreg){echo ".";}
                                                $sq += 1;
                                            }
                                        }
                                    }
                                ?>
                            </p>
                        <?php }
                        $dias_letras = new EnLetras();
                        $val_dias_letras = strtolower($dias_letras -> ValorEnLetras(date('d'), ""));
                        $anio_letras = new EnLetras();
                        $val_anio_letras = strtolower($anio_letras -> ValorEnLetras(date('Y'), ""));?>
                        <p>La presente certificación se expide, a los <strong><span id="diadelmes"><?php echo $val_dias_letras;?></span>(<?php echo date('d');?>)</strong> días del mes de <strong><?php echo strtoupper(mesesLetras(date('m')));?></strong> de <span id="anioletras"><?php echo $val_anio_letras;?></span> (<strong><?php echo date('Y');?></strong>), con destino a <strong><?php echo strtoupper($det);?></strong>.</p><?php 
                    }
                    else{
                        $sal_letras = new EnLetras();
                        $val_sal_letras = strtolower($sal_letras -> ValorEnLetras($emp_sal, "pesos M/CTE."));
                        $pat_letras = new EnLetras();
                        $val_pat_letras = strtolower($pat_letras -> ValorEnLetras($emp_pval, "pesos M/CTE."));?>
                        <p>En calidad de representante legal de la empresa <?php echo $empr_nom;?> con NIT <?php echo $empr_doc;?>, me permito certificar que el(la) señor(a) <strong><?php echo $emp_nom." ".$emp_ape;?></strong> identificado(a) con cédula ciudadanía No. <strong><?php echo $emp_doc;?></strong><?php if($emp_cdoc <> ''){?> expedida en <strong><?php echo $emp_cdoc;?></strong><?php }?>, se encuentra vinculado(a) a la empresa mediante contrato laboral suscrito desde el día <strong><?php echo date("d", $cont_fini)." de ".strtoupper(mesesLetras(date('m', $cont_fini)))." del ".date('Y', $cont_fini);?></strong> desempeñando el cargo de <strong><?php echo $emp_carg;?></strong>.</p>
                        <p>La asignación salarial mensual es de <strong id="sal_letras"><?php echo $val_sal_letras;?></strong> (<strong>$<?php echo number_format($emp_sal);?></strong>).</p>
                        <?php if($emp_pval <> ''){?>
                            <p>La empresa le reconoce  mensualmente la suma de <strong id="pat_letras"><?php echo $val_pat_letras;?></strong> (<strong>$<?php echo number_format($emp_pval);?></strong>) como ahorro voluntario el cual se consigna en <strong><?php echo $emp_pent;?></strong>.</p>
                        <?php }?>
                        <p>La duración del contrato se ha pactado a <strong><?php echo $emp_tcon;?></strong>.</p>
                        <br />
                        <p>La presente certificación se expide a solicitud del empleado, con destino a <strong><?php echo strtoupper($det);?></strong>.</p><?php 
                    }?>
                    <br /><br /><br />
                    <p>Atentamente,</p>
                    <br /><br /><br />
                    <p><?php echo $rep_legal;?></p>
                    <p>Representante Legal</p>
                    <br /><br /><br /><br /><br />
                    <p class="h6">C.C. Hoja de Vida</p>
                    <br />
                </div>
            </div>
        </div>
    </body>
</html>

<?php 
    $dompdf = new DOMPDF();
    $dompdf->load_html(ob_get_clean());
    $dompdf->render();
    $pdf = $dompdf->output();
    $filename = "Certificado".time().'.pdf';
    // file_put_contents($filename, $pdf);
    $dompdf->stream($filename);
    $dompdf->setTimeout(500);
?>