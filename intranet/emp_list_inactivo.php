<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$text_bus = "";
$clase_boton_azul  = "col-xs-6 col-sm-6 col-md-6 col-lg-6";
$clase_boton_verde = "col-xs-6 col-sm-6 col-md-6 col-lg-6";
if(isset($_GET["perf"])){
    $clase_boton_azul  = "col-xs-12 col-sm-12 col-md-12 col-lg-12";
    $clase_boton_verde = "hidden";
}

$res_bus = registroCampo("e3_user u", "u.e3_user_id, u.e3_user_nom, u.e3_user_ape, u.e3_user_doc, u.e3_user_email, u.e3_user_email2, u.e3_user_tel, u.e3_user_cel, u.e3_user_img, carg.e3_carg_nom, e.e3_emp_nom", "LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_carg carg USING(e3_carg_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE (u.e3_tcont_id = '2' AND u.e3_est_id <> '1' AND c.e3_cont_ffin <= NOW()) ", "GROUP BY u.e3_user_id", "ORDER BY u.e3_user_ape ASC, c.e3_cont_fini DESC");

// $res_bus = empleadosBuscar($text_bus);
$html = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center widget">';
if($res_bus){
    if(mysql_num_rows($res_bus) > 0){
        while($row_bus = mysql_fetch_array($res_bus)){
            // Armamos los divs de salida de información
            $html .= '<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 text-left cam_ing">';
                if($row_bus[8] <> ''){$src = $row_bus[8];}
                else{$src = "../img/fotos/man.jpeg";}
                $html .= "<div class='col-xs-3 col-sm-3 col-md-3 col-lg-3 center-block img-thumbnail' style='background-image:url(\"".$src."\"); background-size:contain; background-repeat:no-repeat; background-position:bottom; height:100px;'></div>";
                $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.strtoupper($row_bus[2])."</div>";
                $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.strtoupper($row_bus[1])."</div>";
                $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.$row_bus[9].'</div>';
                $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left text_ing">'.$row_bus[10].'</div>';
                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">
                            <div id="cont_'.$row_bus[0].'" class="'.$clase_boton_azul.' btn btn-primary opc_emp">
                                <i class="glyphicon glyphicon-eye-open"></i>
                            </div>
                            <div id="cont_'.$row_bus[0].'" class="'.$clase_boton_verde.' btn btn-success opc_emp">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </div>
                        </div>';
            $html .= "</div>";
            $html .= '<div id="detalle_emp_'.$row_bus[0].'" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left hidden detalle_ingreso"></div><input type="hidden" id="nom_div_pag" class="form-control" value="emp_det">';
        }
    }
    else{
        $html .= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Atención!</strong> No se encontraron resultados por "'.$_GET["text_bus"].'"...</div>';
    }
}
else{
    $html .= '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><strong>Atención!</strong> No se encontraron resultados por "'.$_GET["text_bus"].'"...</div>';
}
$html .= '</div>';
echo $html;
?>
<script>ed_empleado();</script>