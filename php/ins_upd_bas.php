<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$tabla = "e3_user";
$path = "../img/fotos/";
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
    $sq = 0;$sw = 0;
    $campos = "";
    $sql_upd = "";
    foreach($_POST as $key => $value){
        if(($key <> 'id_upd')&&($key <> 'tabla')&&($key <> 'id')&&($key <> 'ins')&&($key <> 'e3_pais_id')&&($key <> 'campos')&&($key <> 'e3_dpto_id')&&($key <> 'e3_user_img')&&($key <> 'e3_user_dia')&&($key <> 'div_panel')){
            if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
            else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
            $sq += 1;
        }
    }

    //comprobamos que sea una petición ajax
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
        //obtenemos el archivo de la foto a subir.
        $file = $_FILES['e3_user_img']['name'];
        if($file){
            $nom_id = $_POST['id_upd']."_foto";
            $extension = pathinfo($file, PATHINFO_EXTENSION);
            $nom_file = $_POST['id_upd']."_foto".".".$extension;
            //comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
            if(!is_dir($path)){mkdir($path, 0777);}
            //si existe el archivo lo eliminamos
            if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}                         
            //comprobamos si el archivo ha subido
            if ($file && move_uploaded_file($_FILES['e3_user_img']['tmp_name'], $path.$nom_file)){              
                $campos .= ", e3_user_img = '".$path.$nom_file."'";
                $docu = "Documento cargado correctamente.\n";
            }
        }
    }
    if($tabla == 'e3_user'){
        $campos .= ", e3_user_fecha = NOW(), e3_user_user = ".$_SESSION['user_id'];
    }

    $sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = '".$_POST['id_upd']."';";
    $res_upd = mysql_query($sql_upd, conexion());
    if(!$res_upd){$sw += 1;}
    if($sw == 0){echo $_POST['id_upd'];}
    else{echo "";}
}
else{
    $nex_id = NextID('hache_eco_empresarial', 'e3_user');
    // $nex_id = NextID('eco_empresarial', 'e3_user');
    $sq = 0;$sw = 0;
    $campo = "";
    $valor = "";
    foreach($_POST as $key=>$value){
        if(($key <> 'ins')&&($key <> 'tabla')&&($key <> 'id')&&($key <> 'id_upd')&&($key <> 'e3_pais_id')&&($key <> 'e3_dpto_id')&&($key <> 'e3_user_img')&&($key <> 'e3_user_dia')&&($key <> 'div_panel')){
            if($key == "e3_user_id")
            {
                $key = "e3_user_pad";
            }
            if($sq == 0){$campo .= $key;$valor .= "'".trim($value)."'";}
            else{$campo .= ",".$key;$valor .= ",'".trim($value)."'";}            
            $sq += 1;
        }
    }
    //obtenemos el archivo a subir
    $file = $_FILES['e3_user_img']['name'];
    if($file){
        $nom_id = $nex_id."_foto";
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $nom_file = $nom_id.".".$extension;
        //comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
        if(!is_dir($path)){mkdir($path, 0777);}
        //si existe el archivo lo eliminamos
        if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}                         
        //comprobamos si el archivo ha subido
        if ($file && move_uploaded_file($_FILES['e3_user_img']['tmp_name'], $path.$nom_file)){              
            $campo .= ", e3_user_img";
            $valor .= ", '".$path.$nom_file."'";
            $docu = "Documento cargado correctamente.\n";
        }
    }
    if($tabla == 'e3_user'){
        $campo .= ", e3_user_pass, e3_user_fecha, e3_user_user";
        $valor .= ", ".$_POST['e3_user_doc'].", NOW(), ".$_SESSION['user_id'];
    }
    $sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
    $res_ins = mysql_query($sql_ins, conexion());
    // $used_id = mysql_insert_id(conexion());
    if(!$res_ins){$sw += 1;}
    if($sw == 0){echo $nex_id;}
    else{echo "";}
}
?>