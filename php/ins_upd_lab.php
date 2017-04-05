<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
$tabla = "e3_lab";
$path = "../img/archivos/";
if(isset($_POST['id_sup'])){
	$sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup']."";
	$res_borrar = mysql_query($sql_borrar, conexion());
	if($res_borrar){
		$nom_id = $_POST['id_sup']."_certlab";
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
	foreach($_POST as $key=>$value){
		if(($key != 'id_upd')&&($key != 'tabla')&&($key != 'id')&&($key != 'ins')&&($key != 'e3_lab_file')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'id_emp')&&($key != 'div_panel')){
			if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
			else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
			$sq += 1;
		}
	}

	//comprobamos que sea una petición ajax
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	    //obtenemos el archivo a subir
	    $file = $_FILES['e3_lab_file']['name'];
	    if($file){
	    	$nom_id = $_POST['id_upd']."_certlab";
	    	$extension = pathinfo($file, PATHINFO_EXTENSION);
	    	$nom_file = $_POST['id_upd']."_certlab".".".$extension;
	    	//comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
	    	if(!is_dir($path)){mkdir($path, 0777);}
	    	//si existe el archivo lo eliminamos
	    	if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}		        	     
	    	//comprobamos si el archivo ha subido
	    	if ($file && move_uploaded_file($_FILES['e3_lab_file']['tmp_name'], $path.$nom_file)){		    	
	    		$campos .= ", e3_lab_file = '$path".$nom_file."'";
	    		$docu = "Documento cargado correctamente.\n";
	    	}
	    }
	}

	$sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE e3_lab_id = ".$_POST['id_upd']."";
	$res_upd = mysql_query($sql_upd, conexion());
	if($res_upd){echo $docu . $sql_upd;}
	else{echo "";}
}
else{
	$nex_id = NextID('hache_eco_empresarial', 'e3_lab');
	// $nex_id = NextID('eco_empresarial', 'e3_lab');
	$sq = 0;
	$campo = "";
	$valor = "";
	foreach($_POST as $key=>$value){
		if(($key != 'ins')&&($key != 'tabla')&&($key != 'id')&&($key != 'id_upd')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'div_panel')){
			if($sq == 0){$campo .= $key;$valor .= "'".mysql_escape_string($value)."'";}
			else{$campo .= ",".$key;$valor .= ",'".mysql_escape_string($value)."'";}			
			$sq += 1;
		}
	}
	
	//comprobamos que sea una petición ajax
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	    //obtenemos el archivo a subir
	    $file = $_FILES['e3_lab_file']['name'];
	    if($file){
	    	$nom_id = $nex_id."_certlab";
	    	$extension = pathinfo($file, PATHINFO_EXTENSION);
	    	$nom_file = $nom_id.".".$extension;
	    	//comprobamos si existe un directorio para subir el archivo si no es así, lo creamos
	    	if(!is_dir($path)){mkdir($path, 0777);}
	    	//si existe el archivo lo eliminamos
	    	if (file_exists($path.$nom_file)) {unlink($path.$nom_file);}		        	     
	    	//comprobamos si el archivo ha subido
	    	if ($file && move_uploaded_file($_FILES['e3_lab_file']['tmp_name'], $path.$nom_file)){	
	    		$campo .= ", e3_lab_file";
	    		$valor .= ", '$path".$nom_file."'";
	    		$docu = "Documento cargado correctamente.\n";
	    	}
	    }
	}

	$sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
	$res_ins = mysql_query($sql_ins, conexion());
	if($res_ins){echo $docu . $sql_ins;}
	else{echo $sql_ins;}
}
?>