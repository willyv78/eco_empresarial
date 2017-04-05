<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$tabla = "e3_cal";
$path = "../img/calendario/";
if(isset($_POST['id_sup'])){
    $sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup']."";
    $res_borrar = mysql_query($sql_borrar, conexion());
    if($res_borrar){
        echo "Se borro el registro";
    }
    else{echo "";}
}
else if(isset($_POST['id_upd'])){
    $sq = 0;$sw = 0;
    $campos = "";
    $sql_upd = "";
    if(isset($_POST['e3_user_dia'])){
        $sql_upd = "DELETE FROM e3_horario WHERE e3_user_id = '".$_POST['id_upd']."';";
        $res_del = mysql_query($sql_upd, conexion());
        if(!$res_del){$sw += 1;}
        for($i = 0; $i < count($_POST['e3_user_dia']); $i++){
            $val_dia = $_POST['e3_user_dia'][$i];
            $nom_val_ing = "e3_user_hing_".$val_dia;
            $nom_val_sal = "e3_user_hsal_".$val_dia;
            $sql_upd = "INSERT INTO e3_horario (e3_horario_dia, e3_horario_hent, e3_horario_hsal, e3_user_id, e3_horario_fecha, e3_horario_user) VALUES ('".$_POST['e3_user_dia'][$i]."', '".$_POST[$nom_val_ing]."', '".$_POST[$nom_val_sal]."', '".$_POST['id_upd']."', NOW(), ".$_SESSION['user_id'].");";
            $res_ins = mysql_query($sql_upd, conexion());
            if(!$res_ins){$sw += 1;}
        }
    }
    foreach($_POST as $key => $value){
        if(($key <> 'id_upd')&&($key <> 'e3_cal_todos')&&($key <> 'e3_cal_emp')&&($key <> 'e3_cal_file')){
            if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
            else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
            $sq += 1;
        }
    }

    //comprobamos que sea una petición ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        //obtenemos el archivo de la foto a subir.
        $file = $_FILES['e3_cal_file']['name'];
        if($file){
            $nom_id = $_POST['id_upd']."_cal";
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $nom_file = $nom_id.".".$extension;
            //comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
            if(!is_dir($path)){mkdir($path, 0777);}
            //si existe el archivo lo eliminamos
            if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}                         
            //comprobamos si el archivo ha subido
            if ($file && move_uploaded_file($_FILES['e3_cal_file']['tmp_name'], $path.$nom_file)){              
                $campos .= ", e3_cal_file = '".$path.$nom_file."'";
                $docu = "Documento cargado correctamente.\n";
            }
        }
    }

    $val_emp = "";
    if(isset($_POST['e3_cal_emp'])){
        for($i = 0; $i < count($_POST['e3_cal_emp']); $i++){
            if($i == 0){$val_emp .= $_POST['e3_cal_emp'][$i];}
            else{$val_emp .= ",".$_POST['e3_cal_emp'][$i];}
        }
    }

    if($tabla == 'e3_cal'){
        if($val_emp <> ''){
            $campos .= ", e3_cal_emp = '".$val_emp."'";
        }
        $campos .= ", e3_cal_fecha = NOW(), e3_cal_user = ".$_SESSION['user_id'];
    }

    $sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = '".$_POST['id_upd']."';";
    $res_upd = mysql_query($sql_upd, conexion());
    if(!$res_upd){$sw += 1;}
    if($sw == 0){echo $_POST['id_upd'];}
    else{echo "";}
}
else{
    $nex_id = NextID('hache_eco_empresarial', 'e3_cal');
    // $nex_id = NextID('eco_empresarial', 'e3_cal');
    $sq = 0;$sw = 0;
    $campo = "";
    $valor = "";
    $val_emp = "";
    if(isset($_POST['e3_cal_emp'])){
        for($i = 0; $i < count($_POST['e3_cal_emp']); $i++){
            if($i == 0){$val_emp .= $_POST['e3_cal_emp'][$i];}
            else{$val_emp .= ",".$_POST['e3_cal_emp'][$i];}
        }
    }

    foreach($_POST as $key=>$value){
        if(($key <> 'e3_cal_todos')&&($key <> 'e3_cal_emp')&&($key <> 'e3_cal_file')){
            if($sq == 0){$campo .= $key;$valor .= "'".trim($value)."'";}
            else{$campo .= ",".$key;$valor .= ",'".trim($value)."'";}            
            $sq += 1;
        }
    }

    //obtenemos el archivo a subir
    $file = $_FILES['e3_cal_file']['name'];
    if($file){
        $nom_id = $nex_id."_cal";
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $nom_file = $nom_id.".".$extension;
        //comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
        if(!is_dir($path)){mkdir($path, 0777);}
        //si existe el archivo lo eliminamos
        if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}                         
        //comprobamos si el archivo ha subido
        if ($file && move_uploaded_file($_FILES['e3_cal_file']['tmp_name'], $path.$nom_file)){              
            $campo .= ", e3_cal_file";
            $valor .= ", '".$path.$nom_file."'";
            $docu = "Documento cargado correctamente.\n";
        }
    }

    if($tabla == 'e3_cal'){
        if($val_emp <> ''){
            $campo .= ", e3_cal_emp";
            $valor .= ", '".$val_emp."'";
        }
        $campo .= ", e3_cal_fecha, e3_cal_user";
        $valor .= ", NOW(), ".$_SESSION['user_id'];
    }

    $sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
    $res_ins = mysql_query($sql_ins, conexion());
    // $used_id = mysql_insert_id(conexion());
    if(!$res_ins){$sw += 1;}
    if($sw == 0){
        if($_POST['e3_cal_tipo'] == '1'){$background='#2F96B4';}
        else{$background='#F89406';}
        echo "{id:".$nex_id.", title:'".$_POST['e3_cal_nom']."', start:'".$_POST['e3_cal_fini']."', end:'".$_POST['e3_cal_ffin']."', color:'#257e4a', backgroundColor:'".$background."'}";
    }
    else{echo "";}
}
?>