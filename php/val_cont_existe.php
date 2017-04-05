<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
$texto = $_POST["texto"];
if(trim($texto) != ''){
    $res_bus = contactoBuscar($texto);
    if($res_bus){
        if(mysql_num_rows($res_bus) > 0){
            $sq = 0;
            $user_datos = "";
            while($row_user = mysql_fetch_array($res_bus))
            {            
                $user_nom = $row_user[1];
                $user_ape = $row_user[2];
                $user_doc = $row_user[3];
                $user_email = $row_user[4];
                $user_email2 = $row_user[5];
                $user_tel = $row_user[6];
                $user_cel = $row_user[7];
                if($sq > 0)
                {
                    $user_datos .= "|";
                }
                $user_datos .= $user_nom.",".$user_ape.",".$user_doc.",".$user_email.",".$user_email2.",".$user_tel.",".$user_cel;
                $sq ++;
            }
            echo $user_datos;
        }
        else{
            echo '';
        }
    }
    else{
        echo '';
    }
}

?>