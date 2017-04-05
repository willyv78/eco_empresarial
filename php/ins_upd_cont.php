<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
$tabla = "e3_cont";
if(isset($_POST['id_sup'])){
	$datos_ant = "";
	$sql_ant = "SELECT * FROM e3_cont WHERE e3_cont_id = ".$_POST['id_sup'];
	$res_ant = mysql_query($sql_ant, conexion());
	if($res_ant){
		if(mysql_num_rows($res_ant) > 0){
			$row_ant = mysql_fetch_array($res_ant);
			$datos_ant = $row_ant[0]."|".$row_ant[1]."|".$row_ant[2]."|".$row_ant[3]."|".$row_ant[4]."|".$row_ant[5]."|".$row_ant[6]."|".$row_ant[7]."|".$row_ant[8]."|".$row_ant[9]."|".$row_ant[10]."|".$row_ant[11]."|".$row_ant[12]."|".$row_ant[13]."|".$row_ant[14]."|".$row_ant[15]."|".$row_ant[16]."|".$row_ant[17];
		}
	}
	$sql_audi = "INSERT INTO e3_auditor (e3_auditor_ant, e3_auditor_tipo, e3_auditor_user, e3_auditor_fecha) VALUES ('".$datos_ant."', 'Eliminado Contrato', ".$_SESSION['user_id'].", NOW())";
	$res_audi = mysql_query($sql_audi, conexion());

	$sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup'];
	echo $sql_borrar;
	$res_borrar = mysql_query($sql_borrar, conexion());
	if($res_borrar && $res_audi){echo "Se borro el registro";}
	// else{echo $sql_audi;}
}
else if(isset($_POST['id_upd'])){
	$sq = 0;
	$campos = "";
	foreach($_POST as $key=>$value){
		if(($key != 'id_upd')&&($key != 'tabla')&&($key != 'id')&&($key != 'ins')&&($key != 'e3_std_file')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'id_emp')&&($key != 'div_panel')&&($key != 'e3_cont_fin')&&($key != 'e3_cont_pat')&&($key != 'e3_cont_ffin')){
			if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
			else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
			$sq += 1;
		}
		else if($key == 'e3_cont_ffin'){
			if($_POST['e3_cont_fin'] == '0'){
				if($sq == 0){$campos .= $key."='0000-00-00'";}
				else{$campos .= ", ".$key."='0000-00-00'";}
			}
			else{
				if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
				else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
			}
			$sq += 1;
		}
	}
	$campos .= ", e3_cont_fecha=NOW(), e3_cont_user=".$_SESSION['user_id'];
	$sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = ".$_POST['id_upd'];
	$res_upd = mysql_query($sql_upd, conexion());
	if($res_upd){echo $sql_upd;}
}
else{
	$sq = 0;
	$campo = "";
	$valor = "";
	foreach($_POST as $key=>$value){
		if(($key != 'ins')&&($key != 'tabla')&&($key != 'id')&&($key != 'id_upd')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'div_panel')&&($key != 'e3_cont_fin')&&($key != 'e3_cont_pat')){
			if($sq == 0){$campo .= $key;$valor .= "'".mysql_escape_string($value)."'";}
			else{$campo .= ",".$key;$valor .= ",'".mysql_escape_string($value)."'";}			
			$sq += 1;
		}
	}
	$campo .= ", e3_cont_fecha, e3_cont_user";
	$valor .= ", NOW(), ".$_SESSION['user_id'];
	$sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
	$res_ins = mysql_query($sql_ins, conexion());
	if($res_ins){echo "Registro ingresado correctamente";}
}
?>