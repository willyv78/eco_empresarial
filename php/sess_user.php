<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación WEB usando HTML5, CSS3, javascript, jquery y MYSQL - Edificio E3      //
// Copyright 2015 Wilson Giovanny Velandia Barreto 3165879350 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////

$user=$_SESSION['user_id'];
$session_id = session_id();

$val = "SELECT e3_sess_session FROM e3_sess WHERE e3_sess_user = '".$user."'";
$res_val = mysql_query($val, conexion());
if($res_val){
	if(mysql_num_rows($res_val) > 0){
		$row_val = mysql_fetch_array($res_val);
		if($row_val[0] <> $session_id){session_destroy();}
		else{echo $session_id;}
	}
	else{session_destroy();}
}
else{session_destroy();}
?>