<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$id_even = "";
$nom_even = "";
$tipo_even = "";
$tip_even = "";
$fini_even = "";
$ffin_even = "";
$emp_even = "";
$file_even = "";
$obs_even = "";
$fecha_even = "";
$user_even = "";
$class_div = "";
if(isset($_GET['id'])){
    $res = registroCampo("e3_cal", "*", "WHERE e3_cal_id = '".$_GET['id']."'", "", "");
    if($res){
        if(mysql_num_rows($res) > 0){
            $row = mysql_fetch_array($res);
            $id_even = $row[0];
            $nom_even = $row[1];
            $tipo_even = $row[2];
            if($tipo_even == '1'){$tip_even = "Notificación";$class_div = "btn-info";}
            elseif($tipo_even == '2'){$tip_even = "Festivo";$class_div = "btn-success";}
            elseif($tipo_even == '3'){$tip_even = "Día Especial";$class_div = "btn btn-warning";}
            elseif($tipo_even == '4'){$tip_even = "Permiso";$class_div = "btn btn-violet";}
            elseif($tipo_even == '5'){$tip_even = "Vacaciones";$class_div = "btn btn-success";}
            else{$tip_even = "Cumpleaños";$class_div = "btn-cumple";}
            $fini_even = date('Y-m-d H:i', strtotime($row[3]));
            $ffin_even = date('Y-m-d H:i', strtotime($row[4]));
            $emp_even = $row[5];
            $file_even = $row[6];
            $obs_even = $row[7];
            $fecha_even = $row[8];
            $user_even = $row[9];
        }
    }
}

if($nom_even == 'Día Sin Ascensor'){
    $file_even = "../img/archivos/sinascensor.jpg";
}
// echo $ffecha_date;
?>
<div class="col-xs-11 col-sm-10 col-md-8 col-lg-6">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group text-right">
            <legend><h3><?php echo $tip_even; ?></h3></legend>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <h2><?php echo $nom_even;?></h2>
        </div><?php 
        if($file_even <> ''){?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img class="img-responsive" src="<?php echo $file_even; ?>" alt="Image" width="80%" style="margin: auto;">
            </div><?php
        }
        if($tipo_even <> '6'){?>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4 text-right">
                    <h3>Inicio:&nbsp;</h3>
                </div>
                <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 text-left">
                    <h3><?php echo $fini_even;?></h3>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="col-xs-3 col-sm-4 col-md-4 col-lg-4 text-right">
                    <h3>Finaliza:&nbsp;</h3>
                </div>
                <div class="col-xs-9 col-sm-8 col-md-8 col-lg-8 text-left">
                    <h3><?php echo $ffin_even;?></h3>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-3 col-sm-2 col-md-2 col-lg-2 text-right">
                    <h3>Para:&nbsp;</h3>
                </div>
                <div class="col-xs-9 col-sm-10 col-md-10 col-lg-10 text-left">
                    <h3><?php 
                        $dat_emp = explode(",", $emp_even);
                        $num_emp = count($dat_emp);
                        for($i = 0; $i < $num_emp; $i++){
                            $res_emp = registroCampo("e3_emp", "e3_emp_id, e3_emp_nom", "WHERE e3_emp_id = '".$dat_emp[$i]."'", "", "");
                            if($res_emp){
                                if(mysql_num_rows($res_emp) > 0){
                                    $row_emp = mysql_fetch_array($res_emp);
                                    if($num_emp == '1'){$col = 12;}
                                    elseif($num_emp == '2'){$col = 6;}
                                    elseif($num_emp == '3'){$col = 6;}
                                    else{$col = 6;}?>
                                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-<?php echo $col;?>">
                                        <?php echo substr($row_emp[1],0,26);?>
                                    </div><?php 
                                }
                            }
                        }
                        ?>
                    </h3>
                </div>
            </div><?php 
        }
        if(($emp_even <> '') && ($tipo_even == '6')){
            $img_user = "../img/fotos/man.jpeg";
            $res_img_user = registroCampo("e3_user", "e3_user_img", "WHERE e3_user_id = '".$emp_even."'", "", "");
            if($res_img_user){
                if(mysql_num_rows($res_img_user) > 0){
                    $row_img_user = mysql_fetch_array($res_img_user);
                    $img_user = $row_img_user[0];
                }
            }?>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col-xs-3 col-sm-4 col-md-5 col-lg-5">&nbsp;</div>
                <div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
                    <img class="img-responsive" src="<?php echo $img_user; ?>" alt="Image" width="80%" style="margin: auto;">
                </div>
                <div class="col-xs-3 col-sm-4 col-md-5 col-lg-5">&nbsp;</div>
            </div><?php
        }?>
        <?php if($obs_even <> ''){?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-right">
                <h3>Mensaje:&nbsp;</h3>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 text-left">
                <h3><?php echo $obs_even;?></h3>
            </div>
        </div>
        <?php }?>
        <?php if($user_even <> ''){
            $nom_crea = "";
            $fecha_crea = "";
            if($user_even <> '1'){
                $res_crea = contactoBuscarId($user_even);
                if($res_crea){
                    if(mysql_num_rows($res_crea) > 0){
                        $row_crea = mysql_fetch_array($res_crea);
                        $nom_crea = $row_crea[1] . " " . $row_crea[2];
                        if($fecha_even <> ''){
                            $fecha_crea = "<br>Fecha:&nbsp;" . $fecha_even;
                        }
                    }
                }
            }
            else{
                $nom_crea = "Administrador Aplicación WEB";
                $fecha_crea = "<br>Fecha:&nbsp;".$fecha_even;
            }
            ?>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 text-right">
                <h3>Creador:&nbsp;</h3>
            </div>
            <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10 text-left">
                <h3><?php echo $nom_crea . $fecha_crea;?></h3>
            </div>
        </div>
        <?php }?>
        <div class="form-group text-center">
            <div class="widget">&nbsp;</div>
            <button type="buttom" class="btn btn-default">Regresar</button>
        </div>
    </div>
</div>
<script>
</script>
<script>
    verEvento();
</script>