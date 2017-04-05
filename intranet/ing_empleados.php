<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$and = "";
if(isset($_GET['id_empresa'])){
    if($_GET['id_empresa'] <> ''){
        $and = "AND c.e3_emp_id = '".$_GET['id_empresa']."'";
    }
}

echo campoSelectMaster("e3_user u", "*", "u.e3_user_id, u.e3_user_ape, u.e3_user_nom", "LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id WHERE u.e3_tcont_id = '2' $and", "GROUP BY u.e3_user_id", "ORDER BY u.e3_user_ape ASC, c.e3_cont_fini DESC");

?>