<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$tabla = "";
$path = "";
if(isset($_POST['tabla'])){$tabla = $_POST['tabla'];}
if($tabla == 'e3_user'){$path = "../img/fotos/";}
if($tabla == 'e3_docs'){$path = "../img/archivos/";}

if(isset($_POST['id_sup'])){
    $sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup']."";
    $res_borrar = mysql_query($sql_borrar, conexion());
    if($res_borrar){
        if($tabla == "e3_user"){
            $nom_id = $_POST['id_sup'];
            foreach (scandir($path) as $item) {
                if ($item == '.' || $item == '..'){continue;}
                else{
                    $nom_arch = explode(".", $item);
                    if($nom_arch[0] == $nom_id){unlink($path.$item);}
                }       
            }
        }
        echo "Se borro el registro";
    }
}
elseif(isset($_POST['id_upd'])){
    $id_upd = $_POST['id_upd'];
    $sq = 0;$sw = 0;
    $campos = "";
    $sql_upd = "";

    if($tabla == "e3_user"){$no_vale = "e3_user_id";}
    else{$no_vale = "";}

    foreach($_POST as $key => $value){
        if(($key <> 'id_upd') && ($key <> 'tabla') && ($key <> 'titulo') && ($key <> 'div_panel') && ($key <> 'e3_perm_perm') && ($key <> 'e3_user_emp') && ($key <> 'e3_perf_perm') && ($key <> 'e3_user_img') && ($key <> $no_vale) && ($key <> 'e3_docs_emp') && ($key <> 'e3_docs_url')){
            if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
            else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
            $sq += 1;
        }
    }

    if($tabla == "e3_user"){
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
                }
            }
        }
        $campos .= ", e3_user_pad='".$_POST['e3_user_id']."'";
    }

    if($tabla == "e3_docs"){
        //comprobamos que sea una petición ajax
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //obtenemos el archivo de la foto a subir.
            $file = $_FILES['e3_docs_url']['name'];
            if($file){
                $nom_id = $_POST['id_upd']."_regla";
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $nom_file = $nom_id.".".$extension;
                //comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
                if(!is_dir($path)){mkdir($path, 0777);}
                //si existe el archivo lo eliminamos
                if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}                         
                //comprobamos si el archivo ha subido
                if ($file && move_uploaded_file($_FILES['e3_docs_url']['tmp_name'], $path.$nom_file)){
                    $campos .= ", e3_docs_url = '".$path.$nom_file."'";
                }
            }
        }
    }

    // Se valida la tabla que se esta actualizando para agregar los campos de user y fecha
    if(($tabla == "e3_docs") || ($tabla == "e3_area") || ($tabla == "e3_ban") || ($tabla == "e3_cal") || ($tabla == "e3_card") || ($tabla == "e3_carg") || ($tabla == "e3_door") || ($tabla == "e3_emp") || ($tabla == "e3_est") || ($tabla == "e3_perf") || ($tabla == "e3_perm") || ($tabla == "e3_tcont") || ($tabla == "e3_tcon") || ($tabla == "e3_tstd") || ($tabla == "e3_the") || ($tabla == "e3_tper") || ($tabla == "e3_tsolic") || ($tabla == "e3_user") || ($tabla == "e3_mod") || ($tabla == "e3_tdoc")){
        $campos .= ", ".$tabla."_user = '".$_SESSION['user_id']."', ".$tabla."_fecha = NOW()";
    }

    // Valido que se envie dias de la semana con horario
    if(isset($_POST[$tabla.'_perm']) || isset($_POST['e3_user_emp']) || isset($_POST['e3_docs_emp'])){
        $val_campo = "";
        if(isset($_POST['e3_user_emp'])){$nom_campo = 'e3_user_emp';}
        elseif(isset($_POST['e3_docs_emp'])){$nom_campo = 'e3_docs_emp';}
        else{$nom_campo = $tabla.'_perm';}
        for($i = 0; $i < count($_POST[$nom_campo]); $i++){
            $val_dia = $_POST[$nom_campo][$i];
            if($i == 0){$val_campo .= $val_dia;}
            else{$val_campo .= ",".$val_dia;}
        }
        $campos .= ", ".$nom_campo."='".$val_campo."'";
    }


    $sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = '".$id_upd."';";
    $res_upd = mysql_query($sql_upd, conexion());
    if(!$res_upd){$sw += 1;}
    if($sw == 0){echo $sql_upd;}
    else{echo "";}
}
else{
    $nex_id = NextID('hache_eco_empresarial', $tabla);
    // $nex_id = NextID('eco_empresarial', 'e3_lab');
    $sq = 0;$sw = 0;
    $campo = "";
    $valor = "";

    if($tabla == "e3_user"){$no_vale = "e3_user_id";}
    else{$no_vale = "";}

    foreach($_POST as $key=>$value){
        if(($key <> 'tabla') && ($key <> 'titulo') && ($key <> 'id_upd') && ($key <> 'div_panel') && ($key <> 'e3_perm_perm') && ($key <> 'e3_user_emp') && ($key <> 'e3_perf_perm') && ($key <> 'e3_user_img') && ($key <> $no_vale) && ($key <> 'e3_docs_emp') && ($key <> 'e3_docs_url')){
            if($sq == 0){$campo .= $key;$valor .= "'".mysql_escape_string($value)."'";}
            else{$campo .= ",".$key;$valor .= ", '".mysql_escape_string($value)."'";}
            $sq += 1;
        }
    }

    if($tabla == "e3_user"){
        //comprobamos que sea una petición ajax
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //obtenemos el archivo de la foto a subir.
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
                }
            }
        }
        $campo .= ", e3_user_pad";
        $valor .= ", '".$_POST['e3_user_id']."'";
    }

    if($tabla == "e3_docs"){
        //comprobamos que sea una petición ajax
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            //obtenemos el archivo de la foto a subir.
            $file = $_FILES['e3_docs_url']['name'];
            if($file){
                $nom_id = $nex_id."_regla";
                $extension = pathinfo($file, PATHINFO_EXTENSION);
                $nom_file = $nom_id.".".$extension;
                //comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
                if(!is_dir($path)){mkdir($path, 0777);}
                //si existe el archivo lo eliminamos
                if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}                         
                //comprobamos si el archivo ha subido
                if ($file && move_uploaded_file($_FILES['e3_docs_url']['tmp_name'], $path.$nom_file)){
                    $campo .= ", e3_docs_url";
                    $valor .= ", '".$path.$nom_file."'";
                }
            }
        }
    }

    // Se valida la tabla que se esta actualizando para agregar los campos de user y fecha
    if(($tabla == "e3_docs") || ($tabla == "e3_area") || ($tabla == "e3_ban") || ($tabla == "e3_cal") || ($tabla == "e3_card") || ($tabla == "e3_carg") || ($tabla == "e3_door") || ($tabla == "e3_emp") || ($tabla == "e3_est") || ($tabla == "e3_perf") || ($tabla == "e3_perm") || ($tabla == "e3_tcont") || ($tabla == "e3_tcon") || ($tabla == "e3_tstd") || ($tabla == "e3_the") || ($tabla == "e3_tper") || ($tabla == "e3_tsolic") || ($tabla == "e3_user") || ($tabla == "e3_mod") || ($tabla == "e3_tdoc")){

        $campo .= ", ".$tabla."_user, ".$tabla."_fecha";
        $valor .= ", '".$_SESSION['user_id']."', NOW()";
    }

    // Valido que se envie dias de la semana con horario
    if(isset($_POST[$tabla.'_perm']) || isset($_POST['e3_user_emp']) || isset($_POST['e3_docs_emp'])){
        $val_campo = "";
        if(isset($_POST['e3_user_emp'])){$nom_campo = 'e3_user_emp';}
        elseif(isset($_POST['e3_docs_emp'])){$nom_campo = 'e3_docs_emp';}
        else{$nom_campo = $tabla.'_perm';}
        for($i = 0; $i < count($_POST[$nom_campo]); $i++){
            $val_dia = $_POST[$nom_campo][$i];
            if($i == 0){$val_campo .= $val_dia;}
            else{$val_campo .= ",".$val_dia;}
        }
        $campo .= ", ".$nom_campo;
        $valor .= ", '".$val_campo."'";
    }

    $sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
    $res_ins = mysql_query($sql_ins, conexion());
    if(!$res_ins){$sw += 1;}
    if($sw == 0){echo $nex_id;}
    else{echo "";}
}
?>