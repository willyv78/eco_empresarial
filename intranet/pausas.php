<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");

$path = "../img/pausas/";
$rootDir = "";
if(isset($_GET['dir'])){
    $rootDir = $_GET['dir'];
}

$dir = scandir($path.$rootDir);
natsort($dir);
$archivos = array();
foreach($dir as $key => $file) {
    $ext = explode(".", $file);
    if($ext[1] == 'gif'){
        array_push($archivos, $ext[0]);
    }
}

$archivos = json_encode($archivos);

?>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-push-2" id="img-pausas"></div>
<script>
    cargarPausas();
    var carpeta = "<?php echo $rootDir;?>"
    var array_archivos = <?php echo $archivos;?>;
    var tiempo = 0;
    for(var i = 0; i < array_archivos.length; i++){
        if(carpeta === '1'){
            if(array_archivos[i] === '2'){tiempo += 4000;}
            if(array_archivos[i] === '3'){tiempo += 62000;}
            if((array_archivos[i] === '4') || (array_archivos[i] === '5') || (array_archivos[i] === '7') || (array_archivos[i] === '8')){tiempo += 10000;}
            if((array_archivos[i] === '6') || (array_archivos[i] === '9')){tiempo += 11000;}
            if(array_archivos[i] === '10'){tiempo += 60000;}
            if(array_archivos[i] === '11'){tiempo += 64000;}
        }
        else if(carpeta === '2'){
            if(array_archivos[i] === '2'){tiempo += 4000;}
            if((array_archivos[i] === '3') || (array_archivos[i] === '4')){tiempo += 57000;}
            if(array_archivos[i] === '5'){tiempo += 59000;}
        }
        else{
            if(array_archivos[i] === '2'){tiempo += 58000;}
            if(array_archivos[i] === '3'){tiempo += 66000;}
            if(array_archivos[i] === '4'){tiempo += 62000;}
        }
        colocaPausa(carpeta, array_archivos[i], tiempo, array_archivos.length);
    }
    
</script>








