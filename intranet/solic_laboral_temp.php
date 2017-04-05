<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$fsolic = date('Y-m-d H:i');$obs = "";$user = "";$det = "A quien interese";$exp_id = "";$emp_nom = "";$emp_ape = "";$emp_carg = "";$emp_doc = "";$emp_cdoc = "";$emp_fing = "";$emp_sal = "";$emp_pval = "";$emp_pent = "";$empr_nom = "";$empr_doc = "";$empr_dir = "";$empr_tel = "";$empr_fax = "";$empr_img = "";$empr_web = "";$logo = "";
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
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 text-center" style="margin:auto;float:none">
    <div class="form-group text-right">
        <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="solic_laboral">
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="widget"></div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
        <img src="http://181.49.17.5/img/empresas/<?php echo $logo;?>.jpg" class="img-responsive" alt="Image" width="180px">
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="widget"></div>
        </div>
    </div>
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
        
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left"><?php 
            if($rep == '1'){?>
                <br /><br /><br />
                <p><h3 class="text-center">CERTIFICAMOS</h3></p>
                <br /><br /><br />
                <p>Que el(la) señor(a) <strong><?php echo $emp_nom." ".$emp_ape;?></strong> con cédula ciudadanía No. <strong><?php echo $emp_doc;?></strong><?php if($emp_cdoc <> ''){?> expedida en <strong><?php echo $emp_cdoc;?></strong><?php }?>, labora en nuestra empresa desde el <strong><?php echo date("d", $cont_fini)." de ".strtoupper(mesesLetras(date('m', $cont_fini)))." del ".date('Y', $cont_fini);?></strong> desempeñando el cargo de <strong><?php echo $emp_carg;?></strong>, con un asignación mensual de <strong id="sal_letras"></strong> (<strong>$<?php echo number_format($emp_sal);?></strong>) y tiene contrato a <strong><?php echo $emp_tcon;?></strong>.</p>
                <?php if($emp_pval <> ''){?>
                    <p>La empresa le reconoce  mensualmente la suma de <strong id="pat_letras"></strong> (<strong>$<?php echo number_format($emp_pval);?></strong>) como aporte de patrocinio el cual se consigna en <strong><?php echo $emp_pent;?></strong>.</p>
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
                <?php }?>
                <p>La presente certificación se expide, a los <strong><span id="diadelmes"></span>(<?php echo date('d');?>)</strong> días del mes de <strong><?php echo strtoupper(mesesLetras(date('m')));?></strong> de <span id="anioletras"></span> <strong><?php echo date('Y');?></strong>, con destino a <strong><?php echo strtoupper($det);?></strong>.</p><?php 
            }
            else{?>
                <p>En calidad de representante legal de la empresa <?php echo $empr_nom;?> con NIT <?php echo $empr_doc;?>, me permito certificar que el(la) señor(a) <strong><?php echo $emp_nom." ".$emp_ape;?></strong> identificado(a) con cédula ciudadanía No. <strong><?php echo $emp_doc;?></strong><?php if($emp_cdoc <> ''){?> expedida en <strong><?php echo $emp_cdoc;?></strong><?php }?>, se encuentra vinculado(a) a la empresa mediante contrato laboral suscrito desde el día <strong><?php echo date("d", $cont_fini)." de ".strtoupper(mesesLetras(date('m', $cont_fini)))." del ".date('Y', $cont_fini);?></strong> desempeñando el cargo de <strong><?php echo $emp_carg;?></strong>.</p>
                <p>La asignación salarial mensual es de <strong id="sal_letras"></strong> (<strong>$<?php echo number_format($emp_sal);?></strong>).</p>
                <?php if($emp_pval <> ''){?>
                    <p>La empresa le reconoce  mensualmente la suma de <strong id="pat_letras"></strong> (<strong>$<?php echo number_format($emp_pval);?></strong>) como ahorro voluntario el cual se consigna en <strong><?php echo $emp_pent;?></strong>.</p>
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
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 h6">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
            <?php echo $empr_nom."  -  NIT ".$empr_doc."  -   ".$empr_dir."  - PBX ".$empr_tel."  - FAX ".$empr_fax;?>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
            <?php echo $empr_web;?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="widget"></div>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Regresar</button>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="widget"></div>
        </div>
    </div>
</div>
<script>solicVacaciones();</script>
<script type="text/javascript">
    var salario = '<?php echo $emp_sal;?>';
    var texto_sal = getNumberLiteral(salario) + " pesos m/cte.";
    $('#sal_letras').html(texto_sal.toUpperCase());
    var patrocinio = '<?php echo $emp_pval;?>';
    var texto_pat = getNumberLiteral(patrocinio) + " pesos m/cte.";
    $('#pat_letras').html(texto_pat.toUpperCase());
    var hoy = new Date();
    var anio = hoy.fullYear();
    var dia = hoy.getDate();
    mostrarNumero(dia, 'diadelmes');
    mostrarNumero(anio, 'anioletras');
</script>