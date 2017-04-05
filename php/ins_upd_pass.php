<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
$tabla = "e3_user";
$user = $_SESSION['user_id'];
$sql_upd = "UPDATE ".$tabla." SET e3_user_pass = '".$_POST['e3_user_pass_conf']."' WHERE ".$tabla."_id = '$user' AND e3_user_pass = '".$_POST['e3_user_pass']."'";
$res_upd = mysql_query($sql_upd, conexion());
if($res_upd){
	if(mysql_affected_rows() > 0){echo $sql_upd;}
}
?>