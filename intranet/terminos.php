<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$doc_id = "";
$docs_nom = "";
$docs_url = "";

if(isset($_GET["doc_id"])){$doc_id = $_GET["doc_id"];}

// traemos los documentos que deben leer los usuarios
$res_docs = registroCampo("e3_docs", "e3_docs_nom, e3_docs_url", "WHERE e3_docs_id = '$doc_id'", "", "");
if($res_docs){
    if(mysql_num_rows($res_docs) > 0){
        $row_docs = mysql_fetch_array($res_docs);
        $docs_nom = $row_docs[0];
        $docs_url = $row_docs[1];
    }
}
?>
<div>
    <iframe id="frame-regla" src="<?php echo $docs_url;?>" allowfullscreen="true" webkitallowfullscreen="true"></iframe>

    <form action="" method="POST" class="form-horizontal" role="form">
        <div class="form-group">
            <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                <label>
                    <input id="e3_regla_nom" type="checkbox" name="e3_regla_nom" value="<?php echo $doc_id;?>"> Acepto que he leido el(la) <?php echo $docs_nom;?>.
                </label>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                <button type="button" class="btn btn-primary disabled">Aceptar</button>
            </div>
        </div>
    </form>

</div>
<script>cargaRegla();</script>