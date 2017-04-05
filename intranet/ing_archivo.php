<div class="panel-body">
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>Cargar archivo!</strong> El archivo a cargar debe nombrarse "accesos_mesAÑO.csv" (ejemplo: accesos_noviembre2014.csv) y tener extensión .csv y sus campos estar separados por comas. En caso de encontrase un archivo con el mismo nombre este se remplazará por el ultimo cargado.
    </div>
    <div id="perm" class="panel-body tab-pane fade active in">           
        <form class="form-horizontal" id="form_ing_archivo" name="form_ing_archivo" action="" method="POST" role="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="e3_ing_ruta" class="col-sm-4 control-label">Archivo:</label>
                <div class="col-sm-8">
                    <input id="e3_ing_ruta" type="file" name="e3_ing_ruta" class="form-control" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                    <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="ing_archivo">
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-floppy-disk"></i> Cargar</button>
                    <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script><!-- Libreria java script que realiza la validacion de los formulariosP -->
<script>ingresoEdit();</script>
<script>
    $(document).ready(function() {
        $('#form_ing_archivo').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_ing_ruta: {
                    validators: {
                        file: {
                            extension: 'csv,txt,xls,xlsx',
                            type: 'text/csv,text/plain,application/excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,application/x-excel',
                            maxSize: 2097152000,
                            message: 'El archivo seleccionado no es valido'
                        },
                        notEmpty: {
                            message: 'El archivo es requerido'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            espereshow();
            // Prevent form submission
            e.preventDefault();
            var datos_form = new FormData($("#form_ing_archivo")[0]);
            $.ajax({
                url:"../php/ins_archivo.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        $("#ing_archivo").load("./ing_archivo.php");
                        swal({
                            title: "Felicidades!",
                            text: "El registro se ha guardado correctamente!",
                            type: "success",
                            confirmButtonText: "Continuar",
                            confirmButtonColor: "#94B86E"
                        });
                    }
                    else{
                        swal({
                            title: "Error!",
                            text: "Ha ocurrido un error,\nNo se ha realizado cambios,\nrevise la información diligenciada he intentelo nuevamente.",
                            type: "error",
                            confirmButtonText: "Aceptar",
                            confirmButtonColor: "#E25856"
                        });
                        return;
                    }
                }
            });
        });
    });
</script>