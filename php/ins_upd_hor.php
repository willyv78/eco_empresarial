<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$tabla = "e3_horario";
if(isset($_POST['id_sup'])){
	$exp = explode("|", $_POST['id_sup']);
    $fini = $exp[0];
    $ffin = $exp[1];
    $user = $exp[2];
    $sql_borrar = "DELETE FROM e3_horario WHERE e3_user_id = '".$user."' AND (e3_horario_fini = '".$fini."' AND e3_horario_ffin = '".$ffin."')";
    $res_borrar = mysql_query($sql_borrar, conexion());
    if($res_borrar){
        echo "Se borro el registro";
    }
}
else if(isset($_POST['id_upd'])){
    $sq = 0;$sw = 0;
    $campos = "";
    $sql_upd = "";
    // divido la variable en tres para tomar la fecha inicial, fecha final y id de usuario
    $exp = explode("|", $_POST['id_upd']);
    $fini = $exp[0];
    $ffin = $exp[1];
    $user = $exp[2];
    // Borramos todos los registros encontrados con las variables
    $sql_upd_del = "DELETE FROM e3_horario WHERE e3_user_id = '".$user."' AND (e3_horario_fini = '".$fini."' AND e3_horario_ffin = '".$ffin."')";
    $res_del = mysql_query($sql_upd_del, conexion());
    if(!$res_del){$sw += 1;}
    // validamos que se envio la fecha final
    if($_POST['e3_horario_fin'] == '1'){$final = $_POST['e3_horario_ffin'];}
    else{$final = '0000-00-00';}
    // Valido que se envie dias de la semana con horario
    if(isset($_POST['e3_user_dia'])){
        for($i = 0; $i < count($_POST['e3_user_dia']); $i++){
            $val_dia = $_POST['e3_user_dia'][$i];
            $nom_val_ing = "e3_user_hing_".$val_dia;
            $nom_val_sal = "e3_user_hsal_".$val_dia;
            // Se agregar los registros enviados
            $sql_upd = "INSERT INTO e3_horario (e3_horario_dia, e3_horario_hent, e3_horario_hsal, e3_user_id, e3_horario_fecha, e3_horario_user, e3_horario_fini, e3_horario_ffin, e3_horario_obs) VALUES ('".$_POST['e3_user_dia'][$i]."', '".$_POST[$nom_val_ing]."', '".$_POST[$nom_val_sal]."', '".$user."', NOW(), ".$_SESSION['user_id'].", '".$_POST['e3_horario_fini']."', '".$final."', '".$_POST['e3_horario_obs']."');";
            $res_ins = mysql_query($sql_upd, conexion());
            // si algo sale mal suma un valor a la variable
            if(!$res_ins){$sw += 1;}
        }
    }
    // Si todo sale bien envia respuesta
    if($sw == 0){echo $_POST['id_upd'];}
}
else{
    $nex_id = $_POST['e3_user_id'];
    $sw = 0;

    if($_POST['e3_horario_fin'] == '1'){$final = $_POST['e3_horario_ffin'];}
    else{$final = '0000-00-00';}

    if(isset($_POST['e3_user_dia'])){
        for($i = 0; $i < count($_POST['e3_user_dia']); $i++){
            $val_dia = $_POST['e3_user_dia'][$i];
            $nom_val_ing = "e3_user_hing_".$val_dia;
            $nom_val_sal = "e3_user_hsal_".$val_dia;

            $sql_upd = "INSERT INTO e3_horario (e3_horario_dia, e3_horario_hent, e3_horario_hsal, e3_user_id, e3_horario_fecha, e3_horario_user, e3_horario_fini, e3_horario_ffin, e3_horario_obs) VALUES ('".$_POST['e3_user_dia'][$i]."', '".$_POST[$nom_val_ing]."', '".$_POST[$nom_val_sal]."', '".$nex_id."', NOW(), ".$_SESSION['user_id'].", '".$_POST['e3_horario_fini']."', '".$final."', '".$_POST['e3_horario_obs']."');";
            $res_ins = mysql_query($sql_upd, conexion());
            if(!$res_ins){$sw += 1;}
        }
    }
    if($sw == 0){echo $nex_id;}
}
?>