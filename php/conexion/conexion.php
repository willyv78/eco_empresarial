<?php
//////////////////////////////////////////////////////////////////////////////////////
// Aplicación javascript usando jquery - Juego Crucigrama                           //
// Copyright 2014 Wilson Giovanny Velandia Barreto 3204274564 - willyv78@gmail.com  //
//////////////////////////////////////////////////////////////////////////////////////
function conexion(){
    $con = mysql_connect("127.0.0.1","root","gemelo22"); //Conexion local
    //$con = mysql_connect("localhost","root","Ubuntu123"); //Conexion servidor e3
	//$con = mysql_connect("localhost","rmas2784","rmasbconfig001"); //Conexion RmasB
	//$con = mysql_connect("localhost","hache","soyarquitecto"); //Conexion Editores Hache
	if (!$con){die('No se pudo conectar: ' . mysql_error());}
	mysql_select_db("hache_eco_empresarial", $con); //Conexion local //Conexion servidor e3
	//mysql_select_db("rmas2784_rmb_admon", $con); //Conexion RmasB
    //mysql_select_db("hache_eco_empresarial", $con); //Conexion Editores Hache
	return $con;
}
?>