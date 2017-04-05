<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$sw = 0;
$error = "";
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
    $nruta = $_FILES['e3_ing_ruta']['tmp_name'];//ruta del archivo de origen
    $nombre_archivo = $_FILES['e3_ing_ruta']['name'];//nombre del archivo origen
    $nom_explode = explode(".", $nombre_archivo);
    $mes_explode = explode("_", $nom_explode[0]);
    $mes = $mes_explode[1];

    $res_mes = consultaCampo($mes, "e3_ing_mes", "e3_ing");
    if($res_mes > 0){
        $sql_delete = "DELETE FROM e3_ing WHERE e3_ing_mes = '$mes'";
        $res_delete = mysql_query($sql_delete, conexion());
        if($res_delete){$sw += 0;}
        else{$sw += 1;}
    }

    // $fp=fopen($nruta,"r");// Abre el archivo para leer su contenido
    $fila=1;
    $mostrar = "";
    $error = "";
    if (($gestor = fopen($nruta, "r")) !== FALSE) {
        while (($datos = fgetcsv($gestor, 99999999)) !== FALSE) {
            $numero = count($datos);
            $mostrar .= "<p>$numero de campos en la línea $fila</p>\n";
            $campos_linea = "";
            if($fila > 2){
                for($i=0; $i < $numero; $i++){
                    if($i == 0){
                        $phpdate = strtotime($datos[$i]);
                        $campo = "'".date('Y-m-d', $phpdate)."', ";
                        $campo .= "'".date('H:i:s', $phpdate)."'";
                    }
                    else{
                        if($datos[$i] == ''){
                            $campo = "'NULL'";
                            if($i == 4){$campo .= ", '1'";}
                        }
                        else{
                            if($i == 2){
                                $nombre_pers = explode("\\", $datos[$i]);
                                $nom_pers = str_replace("_", " ", $nombre_pers[2]);
                                $campo = "'".$nom_pers."'";
                            }
                            elseif($i == 4){
                                $nom_puerta = explode("\\", $datos[$i]);
                                $puerta = $nom_puerta[2];
                                $campo = "'".$puerta."'";
                                $res_door = registroCampo("e3_door", "e3_door_num", "WHERE e3_door_noming = '".$puerta."'", "", "");
                                if($res_door){
                                    if(mysql_num_rows($res_door) > 0){
                                        $row_door = mysql_fetch_array($res_door);
                                        $campo .= ", '".$row_door[0]."'";
                                    }
                                    else{$campo .= ", '1'";}
                                }
                                else{$campo .= ", '1'";}
                            }
                            elseif($i == 5){
                                $buscar   = 'Out';
                                $coincidencia = strrpos($datos[$i], $buscar);
                                //se puede hacer la comparacion con 'false' o 'true' y los comparadores '===' o '!=='
                                if ($coincidencia === false) {$in_out = "IN";}
                                else {$in_out = "OUT";}
                                $campo = "'".$in_out."'";
                            }
                            else{
                                $campo = "'".$datos[$i]."'";
                            }
                        }
                    }
                    $campos_linea .= $campo.', ';
                }
                $sql = "INSERT INTO e3_ing (e3_ing_date, e3_ing_hour, e3_ing_type, e3_ing_pers, e3_ing_card, e3_ing_door, e3_ing_ndoor, e3_ing_ingsal, e3_ing_mes, e3_ing_fecha, e3_ing_user) VALUES (".$campos_linea."'".$mes."',NOW(), ".$_SESSION['user_id'].");";
                $res = mysql_query($sql, conexion());
                if($res){$sw += 0;}
                else{$sw += 1;$error .= "Error en fila $fila : ".$sql."\n";}
                $mostrar .= "<p>Campos en la línea $fila: $campos_linea</p>\n";
            }
            $fila++;
        }
        fclose($gestor);
    }
}
if($sw > 0){echo $error;}
else{echo "1 ".$mostrar;}
?>