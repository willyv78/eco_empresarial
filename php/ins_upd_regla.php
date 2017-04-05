<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
if(isset($_POST['e3_regla_nom'])){
    if($_POST['e3_regla_nom'] <> ''){
        $sql_ins = "INSERT INTO e3_regla (e3_regla_nom, e3_regla_user, e3_regla_fecha) VALUES ('".$_POST['e3_regla_nom']."', '".$_SESSION['user_id']."', NOW())";
        $res_ins = mysql_query($sql_ins, conexion());
        if($res_ins){echo $sql_ins;}
    }
}?>