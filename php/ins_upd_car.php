<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
$tabla = "e3_card";
$docu = "";
if(isset($_POST['id_sup'])){
	$sql_borrar = "DELETE FROM $tabla WHERE ".$tabla."_id = ".$_POST['id_sup']."";
	$res_borrar = mysql_query($sql_borrar, conexion());
	if($res_borrar){echo "Se borro el registro";}
}
else if(isset($_POST['id_upd'])){
	$sq = 0;
	$campos = "";
	foreach($_POST as $key=>$value){
		if(($key != 'id_upd')&&($key != 'tabla')&&($key != 'id')&&($key != 'ins')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'id_emp')&&($key != 'div_panel')&&($key != 'e3_card_fin')){
			if($sq == 0){$campos .= $key."='".mysql_escape_string($value)."'";}
			else{$campos .= ", ".$key."='".mysql_escape_string($value)."'";}
			$sq += 1;
		}
	}
	$campos .= ", e3_card_fecha = NOW(), e3_card_user = ".$_SESSION['user_id'];
	$sql_upd = "UPDATE ".$tabla." SET ".$campos." WHERE ".$tabla."_id = ".$_POST['id_upd']."";
	$res_upd = mysql_query($sql_upd, conexion());
	if($res_upd){echo $sql_upd;}
}
else{
	$sq = 0;
	$campo = "";
	$valor = "";
	foreach($_POST as $key=>$value){
		if(($key != 'ins')&&($key != 'tabla')&&($key != 'id')&&($key != 'id_upd')&&($key != 'campos')&&($key != 'requeridos')&&($key != 'div_panel')&&($key != 'e3_card_fin')){
			if($sq == 0){$campo .= $key;$valor .= "'".mysql_escape_string($value)."'";}
			else{$campo .= ",".$key;$valor .= ",'".mysql_escape_string($value)."'";}			
			$sq += 1;
		}
	}
	$campo .= ", e3_card_fecha, e3_card_user";
	$valor .= ", NOW(), ".$_SESSION['user_id'];
	$sql_ins = "INSERT INTO ".$tabla." (".$campo.") VALUES (".$valor.")";
	$res_ins = mysql_query($sql_ins, conexion());
	if($res_ins){echo "Registro ingresado correctamente";}
}
?>