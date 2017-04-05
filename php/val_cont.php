<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$id_cont = $_POST["id_cont"];
$res_bus = contactoBuscarId($id_cont);
if($res_bus){
    if(mysql_num_rows($res_bus) > 0){
        $row_user = mysql_fetch_array($res_bus);
        $user_nom = $row_user[1];
        $user_ape = $row_user[2];
        $user_email = $row_user[10];
        $user_tel = "+".$row_user[5]." (".$row_user[6].") ".$row_user[7]." Ext. ".$row_user[8];
        $user_tper = $row_user[29];
        echo $user_nom.",".$user_ape.",".$user_email.",".$user_tel.",".$user_tper;
    }
    else{
        echo '';
    }
}
else{
    echo '';
}
?>