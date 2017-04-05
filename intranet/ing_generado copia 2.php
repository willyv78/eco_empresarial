<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

if(isset($_GET['emp'])){
    $emp = $_GET['emp'];
    if($emp <> ''){$where .= "LEFT OUTER JOIN `e3_user` ON e3_ing.e3_ing_card = e3_user.e3_user_card WHERE e3_user.e3_emp_id = '$emp' AND e3_ing_type = 'Valid_Access'";}
    else{
        $where = "WHERE e3_ing_type = 'Valid_Access'";
    }
}
else{
    $where = "WHERE e3_ing_type = 'Valid_Access'";
}

if((isset($_GET['finicial']))&&(isset($_GET['ffinal']))){
    $finicial = $_GET['finicial'];
    $ffinal = $_GET['ffinal'];
    if(($finicial <> '')&&($ffinal <> '')){
        $finicial = $finicial;
        $ffinal = $ffinal;
    }
    elseif(($finicial == '')&&($ffinal <> '')){
        $finicial = date('2000-01-01');
    }
    elseif(($finicial <> '')&&($ffinal == '')){
        $ffinal = date('Y-m-d');
    }
    else{
        $finicial = date('2000-01-01');
        $ffinal = date('Y-m-d');
    }
    $where .= " AND (e3_ing_date BETWEEN '$finicial' AND '$ffinal')";
}

if(isset($_GET['card'])){
    $card = $_GET['card'];
    if($card <> ''){$where .= " AND e3_ing_card = '$card'";}
}

$html = '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">';
$res_reporte = registroCampo("e3_ing", "e3_ing_date", "$where", "GROUP BY e3_ing_date", "ORDER BY e3_ing_date ASC");
if($res_reporte){
    if(mysql_num_rows($res_reporte) > 0){
        while($row_rep = mysql_fetch_array($res_reporte)){
            $res_minmax = registroCampo("e3_ing", "e3_ing_date, MIN(e3_ing_hour) AS mini, MAX(e3_ing_hour) AS maxi, e3_ing_card, e3_ing_pers", "$where AND e3_ing_date = '".$row_rep[0]."'", "GROUP BY e3_ing_card", "ORDER BY e3_ing_hour ASC");
            if($res_minmax){
                if(mysql_num_rows($res_minmax) > 0){
                    while($row_minmax = mysql_fetch_array($res_minmax)){
                        $res_finiffin = registroCampo("e3_user", "e3_user_hing, e3_user_hsal, e3_user_img, e3_user_nom, e3_user_ape", "WHERE e3_user_card = '".$row_minmax[3]."'", "", "");
                        if($res_finiffin){
                            if(mysql_num_rows($res_finiffin) > 0){
                                $row_finiffin = mysql_fetch_array($res_finiffin);
                                $h_ing = '07:00:00';
                                $h_sal = '17:30:00';
                                $debe_total = "";
                                $class_div = "";
                                if($row_finiffin[0] <> ''){$h_ing = $row_finiffin[0];} 
                                if($row_finiffin[1] <> ''){$h_sal = $row_finiffin[1];}
                                if($h_ing < $row_minmax[0]){
                                    $dif_ing = restaHours($h_ing, $row_minmax[0]);
                                    $debei = 1;// Me debe
                                }
                                else{
                                    $dif_ing = restaHours($row_minmax[0], $h_ing);
                                    $debei = 2;// Le debo
                                }
                                if($h_sal < $row_minmax[1]){
                                    $dif_sal = restaHours($h_sal, $row_minmax[1]);
                                    $debes = 2;// Le debo
                                }
                                else{
                                    $dif_sal = restaHours($row_minmax[1], $h_sal);
                                    $debes = 1;// Me debe
                                }
                                $dif_ing_date = date('H:i:s', $dif_ing);
                                $dif_sal_date = date('H:i:s', $dif_sal);
                                if(($debei == 1)&&($debes == 1)){
                                    $dif_total = sumarHours($dif_ing_date, $dif_sal_date);
                                    $debe_total = "Debe Reponer";
                                    $class_div = "btn btn-danger";
                                }
                                elseif(($debei == 2)&&($debes == 2)){
                                    $dif_total = sumarHours($dif_ing_date, $dif_sal_date);
                                    $debe_total = "A su favor";
                                    $class_div = "btn btn-success";
                                }
                                else{
                                    if($dif_ing_date < $dif_sal_date){
                                        $dif_total = restaHours($dif_ing_date, $dif_sal_date);
                                        if($debes == 2){
                                            $debe_total = "A su favor";
                                            $class_div = "btn btn-success";
                                        }
                                        else{
                                            $debe_total = "Debe Reponer";
                                            $class_div = "btn btn-danger";
                                        }
                                    }
                                    else{
                                        $dif_total = restaHours($dif_sal_date, $dif_ing_date);
                                        if($debei == 1){
                                            $debe_total = "Debe Reponer";
                                            $class_div = "btn btn-danger";
                                        }
                                        else{
                                            $debe_total = "A su favor";
                                            $class_div = "btn btn-success";
                                        }
                                    }
                                }
                                $html .= '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 text-left cam_ing">';
                                if($row_finiffin[2] <> ''){$src = $row_finiffin[2];}
                                else{$src = "../img/fotos/man.jpeg";}
                                    $html .= '<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 text-left">';
                                    $html .= "<img src='".$src."'/>";
                                    $html .= "</div>";
                                    $html .= '<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 text-left">';
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">'.$row_rep[0]."</div>";
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left">'.$row_finiffin[3]."  ".$row_finiffin[4]."</div>";
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-left '.$class_div.'">'.$debe_total .": ". date('H:i:s', $dif_total)."</div>";
                                    $html .= "</div>";
                                $html .= "</div>";
                                // echo $html;
                                // echo $row_minmax[0]." - ".$row_minmax[1]." - ".$row_minmax[2]." - ".$row_minmax[3]." - ".$row_minmax[4]." - ".date('H:i:s', $dif_ing)." : ".$debei." - ".date('H:i:s', $dif_sal)." : ".$debes." total ".$debe_total." = ".date('H:i:s', $dif_total)."<br />";
                            }
                            else{
                                // echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
                            }
                        }
                        else{
                            echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
                        }
                    }
                }
                else{
                    // echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
                }
            }
            else{
                echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
            }
        }
    }
    else{
        // echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
    }
}
else{
    echo '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><span>No hay campos</span></div>';
}
$html .= '</div>';
echo $html;
?>






