<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$tabla = "e3_user";
$path = "../images/archivos/";
if(isset($_POST['id_sup'])){
    $sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup']."";
    $res_borrar = mysql_query($sql_borrar, conexion());
    if($res_borrar){
        $nom_id = $_POST['id_sup'];
        foreach (scandir($path) as $item) {
            if ($item == '.' || $item == '..'){continue;}
            else{
                $nom_arch = explode(".", $item);
                if($nom_arch[0] == $nom_id){unlink($path.$item);}           
            }       
        }
        echo "Se borro el registro";
    }
}
else if(isset($_POST['id_upd'])){
    $sq = 0;
    $campos = "";
    foreach($_POST as $key => $value){
        if(($key != 'id_upd')&&($key != 'tabla')&&($key != 'id')&&($key != 'ins')&&($key != 'e3_pais_id')&&($key != 'campos')&&($key != 'e3_dpto_id')&&($key <> 'e3_cal_todos')&&($key <> 'e3_cal_emp')&&($key <> 'e3_est_id')){
            if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
            else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
            $sq += 1;
        }
    }

    if(isset($_POST['e3_est_id'])){
        if($_POST['e3_est_id'] <= '0'){
            $campos .= ", e3_est_id = '1'";
        }
        else{
            $campos .= ", e3_est_id = '".$_POST['e3_est_id']."'";
        }
    }

    $val_emp = "";
    if(isset($_POST['e3_cal_emp'])){
        for($i = 0; $i < count($_POST['e3_cal_emp']); $i++){
            if($i == 0){$val_emp .= $_POST['e3_cal_emp'][$i];}
            else{$val_emp .= ",".$_POST['e3_cal_emp'][$i];}
        }
    }

    if($tabla == 'e3_user'){
        if($val_emp <> ''){
            $campos .= ", e3_user_emp = '".$val_emp."'";
        }
        $campos .= ", e3_user_fecha = NOW(), e3_user_user = ".$_SESSION['user_id'];
    }

    $sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = ".$_POST['id_upd'];
    $res_upd = mysql_query($sql_upd, conexion());
    if($res_upd){echo "Registro actualizado correctamente";}
    else{echo "";}
}
else{
    $sq = 0;
    $campo = "";
    $valor = "";
    foreach($_POST as $key=>$value){
        if(($key != 'ins')&&($key != 'tabla')&&($key != 'id')&&($key != 'id_upd')&&($key != 'e3_pais_id')&&($key != 'e3_dpto_id')&&($key <> 'e3_cal_todos')&&($key <> 'e3_cal_emp')&&($key <> 'e3_est_id')){
            if($key == "e3_user_id")
            {
                $key = "e3_user_pad";
            }
            if($sq == 0){$campo .= $key;$valor .= "'".trim($value)."'";}
            else{$campo .= ",".$key;$valor .= ",'".trim($value)."'";}            
            $sq += 1;
        }
    }

    if(isset($_POST['e3_est_id'])){
        if($_POST['e3_est_id'] <= '0'){
            $campos .= ", e3_est_id = '1'";
        }
        else{
            $campos .= ", e3_est_id = '".$_POST['e3_est_id']."'";
        }
    }

    $val_emp = "";
    if(isset($_POST['e3_cal_emp'])){
        for($i = 0; $i < count($_POST['e3_cal_emp']); $i++){
            if($i == 0){$val_emp .= $_POST['e3_cal_emp'][$i];}
            else{$val_emp .= ",".$_POST['e3_cal_emp'][$i];}
        }
    }

    if($tabla == 'e3_user'){
        if($val_emp <> ''){
            $campos .= ", e3_user_emp = '".$val_emp."'";
        }
        $campos .= ", e3_user_fecha = NOW(), e3_user_user = ".$_SESSION['user_id'];
    }

    $sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
    $res_ins = mysql_query($sql_ins, conexion());
    if($res_ins){echo "Registro ingresado correctamente";}
    else{echo "";}
}
?>