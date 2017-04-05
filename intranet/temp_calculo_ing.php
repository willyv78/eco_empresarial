<?php 
$array_total = new array();
$res_report = registroCampo("e3_ing", "e3_ing_date", "$where", "GROUP BY e3_ing_date", "ORDER BY e3_ing_date ASC");
if($res_report){
    if(mysql_num_rows($res_report) > 0){
        while($row_report = mysql_fetch_array($res_report)){
            $res_horasminmax = registroCampo("e3_ing", "e3_ing_date, MIN(e3_ing_hour) AS mini, MAX(e3_ing_hour) AS maxi, e3_ing_card, e3_ing_pers", "$where AND e3_ing_date = '".$row_report[0]."'", "GROUP BY e3_ing_card", "ORDER BY e3_ing_hour ASC");
            if($res_horasminmax){
                if(mysql_num_rows($res_horasminmax) > 0){
                    while($row_horasminmax = mysql_fetch_array($res_horasminmax)){
                        $res_hinghsal = registroCampo("e3_user", "e3_user_hing, e3_user_hsal, e3_user_img, e3_user_nom, e3_user_ape", "WHERE e3_user_card = '".$row_horasminmax[3]."'", "", "");
                        if($res_hinghsal){
                            if(mysql_num_rows($res_hinghsal) > 0){
                                $row_hinghsal = mysql_fetch_array($res_hinghsal);
                                $h_ingreso = '07:00:00';
                                $h_salida = '17:30:00';
                                $debe_total = "";
                                $clase_div = "";
                                if($row_hinghsal[0] <> ''){$h_ingreso = $row_hinghsal[0];} 
                                if($row_hinghsal[1] <> ''){$h_salida = $row_hinghsal[1];}
                                if($h_ingreso < $row_horasminmax[1]){
                                    $dif_ingreso = restaHours($h_ingreso, $row_horasminmax[1]);
                                    $debeing = 1;// Me debe
                                }
                                else{
                                    $dif_ingreso = restaHours($row_horasminmax[1], $h_ingreso);
                                    $debeing = 2;// Le debo
                                }
                                if($h_salida < $row_horasminmax[2]){
                                    $dif_salida = restaHours($h_salida, $row_horasminmax[2]);
                                    $debesalida = 2;// Le debo
                                }
                                else{
                                    $dif_salida = restaHours($row_horasminmax[2], $h_salida);
                                    $debesalida = 1;// Me debe
                                }
                                $dif_entra_date = date('H:i:s', $dif_ingreso);
                                $dif_fuera_date = date('H:i:s', $dif_salida);
                                if(($debeing == 1)&&($debesalida == 1)){
                                    $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                    $debe_total_res += $dif_total;
                                    $clase_div = "bred";
                                }
                                elseif(($debeing == 2)&&($debesalida == 2)){
                                    $dif_total = sumarHours($dif_entra_date, $dif_fuera_date);
                                    $debe_total_mas += $dif_total;
                                    $clase_div = "bgreen";
                                }
                                else{
                                    if($dif_entra_date < $dif_fuera_date){
                                        $dif_total = restaHours($dif_entra_date, $dif_fuera_date);
                                        if($debesalida == 2){
                                            $debe_total_mas += $dif_total;
                                            $clase_div = "bgreen";
                                        }
                                        else{
                                            $debe_total_res += $dif_total;
                                            $clase_div = "bred";
                                        }
                                    }
                                    else{
                                        $dif_total = restaHours($dif_fuera_date, $dif_entra_date);
                                        if($debeing == 1){
                                            $debe_total_res += $dif_total;
                                            $clase_div = "bred";
                                        }
                                        else{
                                            $debe_total_mas += $dif_total;
                                            $clase_div = "bgreen";
                                        }
                                    }
                                }
                                // si es deuda resta sino suma
                                if($clase_div = "bgreen"){
                                    $array_total[$row_horasminmax[3]."_sum"] += $dif_total;
                                }
                                else{
                                    $array_total[$row_horasminmax[3]."_res"] += $dif_total;
                                }

                            }
                        }
                    }
                }
            }
        }
    }
}
?>