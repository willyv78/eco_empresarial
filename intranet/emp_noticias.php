<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
if(isset($_GET["emp_id"]))
{
  $emp_id = $_GET["emp_id"];
}
else
{
  $emp_id = "";
}
$res_bus = empleadoBuscarId($emp_id);
$res_busc = empleadoBuscarEmpleadoId($emp_id);
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $nom = $row[1];
        $ape = $row[2];
        $ndoc = $row[3];
        $dir = $row[4];
        $ind = $row[5];
        $areat = $row[6];
        $telf = $row[7];
        $ext = $row[8];
        $telc = $row[9];
        $emailc = $row[10];
        $emailp = $row[11];
        $fnac = $row[12];
        $obs = $row[13];
        $pub = $row[14];
        $pad = $row[15];
        $nome = $row[17];
        $tele = $row[18];
        $user = $row[20];
        $tdoc = $row[21];
        $tcont = $row[22];
        $emp = $row[23];
        $est = $row[24];
        $carg = $row[25];
        $area = $row[26];
        $ciu = $row[27];
        $tipoc = $row[28];
        $tpers = $row[29];
        $perf = $row[30];
        $empp = $row[31];
        $gen = $row[32];
        $sal = $row[33];
        $fing = $row[34];
    }
    else
    {
        $nom = "";
        $ape = "";
        $ndoc = "";
        $dir = "";
        $ind = "";
        $areat = "";
        $telf = "";
        $ext = "";
        $telc = "";
        $emailc = "";
        $emailp = "";
        $fnac = "";
        $obs = "";
        $pub = "";
        $pad = "";
        $nome = "";
        $tele = "";
        $user = "";
        $tdoc = "";
        $tcont = "";
        $emp = "";
        $est = "";
        $carg = "";
        $area = "";
        $ciu = "";
        $tipoc = "";
        $tpers = "";
        $perf = "";
        $empp = "";
        $gen = "";
        $sal = "";
        $fing = "";
    }
}
else
{
    $nom = "";
    $ape = "";
    $ndoc = "";
    $dir = "";
    $ind = "";
    $areat = "";
    $telf = "";
    $ext = "";
    $telc = "";
    $emailc = "";
    $emailp = "";
    $fnac = "";
    $obs = "";
    $pub = "";
    $pad = "";
    $nome = "";
    $tele = "";
    $user = "";
    $tdoc = "";
    $tcont = "";
    $emp = "";
    $est = "";
    $carg = "";
    $area = "";
    $ciu = "";
    $tipoc = "";
    $tpers = "";
    $perf = "";
    $empp = "";
    $gen = "";
    $sal = "";
    $fing = "";
}
?>
<div class="panel-body">
    <div class="input-group input-group-md">
        <h4>Publicaciones</h4>
        <span class="input-group-addon" title="Nuevo registro"><i class="glyphicon glyphicon-plus"></i></span>
    </div>
    <img src="../img/invitacion.jpg" class="img-responsive" alt="Image">
</div>