<?php session_start();
require_once ("conexion/conexion.php");
require_once ("funciones.php");
// id de la session del usuario es diferente para cada equipo donde se inicie session por usuario
$session_id = session_id();
// inicializo variable para controlar el id session
$sw = 0;

$email = $_POST["email"];
$passw = $_POST["password"];
if(($email <> '')&&($passw <> '')){
    // valido si existe un usuario registrado con los datos enviados
    $res_user = ValUser($email, $passw);
    if($res_user){
        if(mysql_num_rows($res_user) > 0){
            $row_user = mysql_fetch_array($res_user);
            $_SESSION['user_id'] = $row_user[0];
            $_SESSION['user_nom'] = $row_user[1];
            $_SESSION['user_ape'] = $row_user[2];
            $_SESSION['user_perf'] = $row_user[3];
            $_SESSION['user_mail'] = $email;
            // valido si existe registro de session del usuario que se esta logueando
            $res = registroCampo("e3_sess", "e3_sess_id", "WHERE e3_sess_user = '".$_SESSION['user_id']."'", "", "");
            if($res){
                // si el usuario ya ha ingresado a la plataforma actualiza el id session
                if(mysql_num_rows($res) > 0){
                    $sql = ("UPDATE e3_sess SET e3_sess_session = '$session_id', e3_sess_fecha = NOW() WHERE e3_sess_user = '".$_SESSION['user_id']."'");
                }
                // si es la primera vez que ingresa a la plataforma entonces agrega el registro del primer ingreso
                else{
                    $sql = ("INSERT INTO e3_sess (e3_sess_user, e3_sess_session, e3_sess_fecha) VALUES ('".$_SESSION['user_id']."', '$session_id', NOW())");
                }
                $query = mysql_query($sql, conexion());
                // echo $sql;
                if($query){
                    echo "Bienvenido ".$_SESSION['user_nom'];
                }
                else{
                    session_destroy();
                }
            }
            else{
                session_destroy();
            }
            
        }
        else{
            session_destroy();
        }
    }
    else{
        session_destroy();
    }
}
else{
    session_destroy();
}
?>