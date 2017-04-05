<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
$tabla = "e3_std";
$path = "../img/archivos/";
$docu = "";
if(isset($_POST['id_sup'])){
	$sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup'];
	$res_borrar = mysql_query($sql_borrar, conexion());
	if($res_borrar){
		$nom_cert = $_POST['id_sup']."_cert";
		$nom_tarj = $_POST['id_sup']."_tprof";		
		foreach (scandir($path) as $item) {
		    if ($item == '.' || $item == '..'){continue;}
		    else{
				$nom_arch = explode(".", $item);
		    	if(($nom_arch[0] == $nom_cert)||($nom_arch[0] == $nom_tarj)){unlink($path.$item);}	    	
		    }	    
		}
		echo "Se borro el registro";
	}
}
else if(isset($_POST['id_upd'])){
	$sq = 0;
	$campos = "";
	foreach($_POST as $key=>$value){
		if(($key != 'id_upd')&&($key != 'tabla')&&($key != 'id')&&($key != 'ins')&&($key != 'e3_std_file')&&($key != 'e3_std_file_tprof')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'id_emp')&&($key != 'div_panel')){
			if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
			else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
			$sq += 1;
		}
	}
	if($tabla == 'e3_std'){
		//comprobamos que sea una petición ajax
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		    //obtenemos el archivo del certificado a subir.
		    $file = $_FILES['e3_std_file']['name'];
		    if($file){
		    	$nom_id = $_POST['id_upd']."_cert";
		    	$extension = pathinfo($file, PATHINFO_EXTENSION);
		    	$nom_file = $_POST['id_upd']."_cert".".".$extension;
		    	//comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
		    	if(!is_dir($path)){mkdir($path, 0777);}
		    	//si existe el archivo lo eliminamos
		    	if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}		        	     
		    	//comprobamos si el archivo ha subido
		    	if ($file && move_uploaded_file($_FILES['e3_std_file']['tmp_name'], $path.$nom_file)){		    	
		    		$campos .= ", e3_std_file = '".$path.$nom_file."'";
		    		$docu = "Documento cargado correctamente.\n";
		    	}
		    }
		    //obtenemos el archivo de la tarjeta profesional a subir
		    $file_tprof = $_FILES['e3_std_file_tprof']['name'];
		    if($file_tprof){
		    	$nom_tprof = $_POST['id_upd']."_tprof";
		    	$ext_tprof = pathinfo($file_tprof, PATHINFO_EXTENSION);
		    	$nom_file_tprof = $_POST['id_upd']."_tprof".".".$ext_tprof;
		    	//comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
		    	if(!is_dir($path)){mkdir($path, 0777);}
		    	//si existe el archivo lo eliminamos
		    	if (file_exists($path.$nom_tprof)) {unlink($path.$nom_tprof);}		        	     
		    	//comprobamos si el archivo ha subido
		    	if ($file_tprof && move_uploaded_file($_FILES['e3_std_file_tprof']['tmp_name'], $path.$nom_tprof)){		    	
		    		$campos .= ", e3_std_file_tprof = '".$path.$nom_tprof."'";
		    		$docu .= "Documento cargado correctamente.\n";
		    	}
		    }
		}
		$campos .= ", e3_std_fecha=NOW(), e3_std_user=".$_SESSION['user_id'];
	}
	$sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = ".$_POST['id_upd'];
	$res_upd = mysql_query($sql_upd, conexion());
	if($res_upd){echo $docu . $sql_upd;}
}
else{
	$nex_id = NextID('hache_eco_empresarial', 'e3_std');
	$sq = 0;
	$campo = "";
	$valor = "";
	foreach($_POST as $key=>$value){
		if(($key != 'ins')&&($key != 'id_upd')&&($key != 'tabla')&&($key != 'id')&&($key != 'e3_std_file')&&($key != 'e3_std_file_tprof')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'id_emp')&&($key != 'div_panel')){
			if($sq == 0){$campo .= $key;$valor .= "'".mysql_escape_string($value)."'";}
			else{$campo .= ",".$key;$valor .= ",'".mysql_escape_string($value)."'";}			
			$sq += 1;
		}
	}
	if($tabla == 'rmb_calendario'){$campo .= ", rmb_calendario_fecha, rmb_calendario_user";$valor .= ", NOW(), ".$_SESSION['user_id']."";}

	if($tabla == 'e3_std'){
		//comprobamos que sea una petición ajax
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		    //obtenemos el archivo a subir
		    $file = $_FILES['e3_std_file']['name'];
		    if($file){
		    	$nom_id = $nex_id."_cert";
		    	$extension = pathinfo($file, PATHINFO_EXTENSION);
		    	$nom_file = $nom_id.".".$extension;
		    	//comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
		    	if(!is_dir($path)){mkdir($path, 0777);}
		    	//si existe el archivo lo eliminamos
		    	if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}		        	     
		    	//comprobamos si el archivo ha subido
		    	if ($file && move_uploaded_file($_FILES['e3_std_file']['tmp_name'], $path.$nom_file)){		    	
		    		$campo .= ", e3_std_file";
		    		$valor .= ", '$path"."$nom_file'";
		    		$docu = "Documento cargado correctamente.\n";
		    	}
		    }
		    //obtenemos el archivo de la tarjeta profesional a subir
		    $file_tprof = $_FILES['e3_std_file_tprof']['name'];
		    if($file_tprof){
		    	$nom_tprof = $_POST['id_upd']."_tprof";
		    	$ext_tprof = pathinfo($file_tprof, PATHINFO_EXTENSION);
		    	$nom_file_tprof = $_POST['id_upd']."_tprof".".".$ext_tprof;
		    	//comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
		    	if(!is_dir($path)){mkdir($path, 0777);}
		    	//si existe el archivo lo eliminamos
		    	if (file_exists($path.$nom_tprof)) {unlink($path.$nom_tprof);}		        	     
		    	//comprobamos si el archivo ha subido
		    	if ($file_tprof && move_uploaded_file($_FILES['e3_std_file_tprof']['tmp_name'], $path.$nom_tprof)){
		    		$campo .= ", e3_std_file_tprof";
		    		$valor .= ", '$path".$nom_tprof."'";
		    		$docu .= "Documento cargado correctamente.\n";
		    	}
		    }
		}
		$campo .= ", e3_std_fecha, e3_std_user";
		$valor .= ", NOW(), ".$_SESSION['user_id']."";
	}

	$sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
	$res_ins = mysql_query($sql_ins, conexion());
	if($res_ins){echo "Registro ingresado correctamente";}
}
?>