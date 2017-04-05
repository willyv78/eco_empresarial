<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$tabla = "";
$id_reg = "";
$titulo = "";
$readonly = "";
$src = "data:image/png;base64,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";
$row_reg = array();

if(isset($_GET['tbl_db'])){$tabla = $_GET['tbl_db'];}
if(isset($_GET['conf_id_open'])){
    $id_reg = $_GET['conf_id_open'];
    if($tabla == 'e3_perm'){$orden = "ORDER BY e3_mod_id ASC";}
    else{$orden = "ORDER BY ".$tabla."_nom ASC";}
    $res_reg = registroCampo($tabla, "*", "WHERE ".$tabla."_id = '$id_reg'", "", $orden);
    if($res_reg){
        if(mysql_num_rows($res_reg) > 0){
            $row_reg = mysql_fetch_assoc($res_reg);
        }
    }
}
if(isset($_GET['titulo'])){$titulo = $_GET['titulo'];}
if(isset($_GET['conf_ver'])){$readonly = "readonly";}
$res = schemaTabla($tabla);
?>
<div class="btblue col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <form id="form_conf" name="form_conf" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="conf_lista">
            <input type="hidden" name="tabla" id="tabla" class="form-control" value="<?php echo $tabla;?>">
            <input type="hidden" name="titulo" id="titulo" class="form-control" value="<?php echo $titulo;?>">
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <?php echo $titulo;?>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <!-- <div class="widget"></div> -->
            </div>
        </div><?php 
        if($res){
            if(mysql_num_rows($res) > 0){
                $campo_requerido = array();
                while($row = mysql_fetch_array($res)){
                    $id_reg = $row_reg[$tabla."_id"];
                    if(($row[1] <> 'PRI') && ($row[0] <> 'e3_user_perf') && ($row[0] <> $tabla.'_user') && ($row[0] <> $tabla.'_fecha')){
                        if($row[3] == 'NO'){$required = 'required="required"';}
                        else{$required = '';}?>
                        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="<?php echo $row[0];?>"><?php echo $row[2];?> : </label>
                            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php 
                                if($row[0] == 'e3_emp_img'){
                                    if($row_reg[$row[0]] <> ''){
                                        $src = base64_decode($row_reg[$row[0]]);
                                        // $src = 'data: image/png;base64,'.$empr_img;
                                    }?>
                                    <input type="hidden" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" value="">
                                    <img id="vistaPrevia" src="<?php echo $src;?>" class="img-responsive" alt="Image" width="40%">
                                    <input type="file" name="file_logo" id="file_logo" class="form-control fileimagen" placeholder="" value="">
                                    <?php 
                                }
                                elseif($row[0] == 'e3_mod_id'){
                                    echo campoSelect($row_reg[$row[0]], "e3_mod");
                                }
                                elseif(($row[0] == 'e3_perf_perm') || ($row[0] == 'e3_perm_perm') || ($row[0] == 'e3_user_emp')){
                                    for($i = 1; $i <= 4; $i++){
                                        $pos = false;
                                        if($i == 1){$label = "Consultar";$pos = strstr($row_reg[$row[0]], '1');}
                                        elseif($i == 2){$label = "Editar";$pos = strstr($row_reg[$row[0]], '2');}
                                        elseif($i == 3){$label = "Eliminar";$pos = strstr($row_reg[$row[0]], '3');}
                                        elseif($i == 4){$label = "Agregar";$pos = strstr($row_reg[$row[0]], '4');}
                                        if($pos !== false){$checked = 'checked="checked"';}
                                        else{$checked = '';}?>
                                        <div class="checkbox col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <label>
                                                <input id="<?php echo $row[0].'_'.$i;?>" type="checkbox" name="<?php echo $row[0];?>[]" <?php echo $checked;?> value="<?php echo $i;?>">
                                                <?php echo $label;?>
                                            </label>
                                        </div><?php 

                                    }
                                }
                                elseif($row[0] == 'e3_mod_id'){
                                    echo campoSelectMaster("e3_mod", $row_reg[$row[0]], "*", "", "", "ORDER BY e3_mod_nom ASC");
                                }
                                elseif($row[0] == 'e3_perf_id'){
                                    echo campoSelectMaster("e3_perf", $row_reg[$row[0]], "*", "", "", "ORDER BY e3_perf_nom ASC");
                                }
                                elseif($row[0] == 'e3_est_id'){
                                    if($tabla == 'e3_user'){$where = "WHERE e3_mod_id = '1'";}
                                    else{$where = "WHERE e3_mod_id = '$id_reg'";}
                                    echo campoSelectMaster("e3_est", $row_reg[$row[0]], "*", $where, "", "ORDER BY e3_est_nom ASC");
                                }
                                elseif($row[0] == $tabla.'_obs'){?>
                                    <textarea name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" rows="3" placeholder="Ingrese una observación." class="form-control" ><?php echo $row_reg[$row[0]];?></textarea><?php 
                                }
                                elseif($row[0] == 'e3_user_pub'){?>
                                    <div class="text-left">
                                        <input type="radio" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" value="1" <?php if(($row_reg[$row[0]] == '')||($row_reg[$row[0]] == '1')){echo "checked";} ?>> Público &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" value="2" <?php if(($row_reg[$row[0]] <> '')&&($row_reg[$row[0]] == '2')){echo "checked";} ?>> Privado
                                    </div><?php 
                                }
                                elseif($row[0] == 'e3_user_hora'){?>
                                    <div class="text-left">
                                        <input type="radio" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" value="1" <?php if(($row_reg[$row[0]] == '')||($row_reg[$row[0]] == '1')){echo "checked";} ?>> Sí &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" value="2" <?php if(($row_reg[$row[0]] <> '')&&($row_reg[$row[0]] == '2')){echo "checked";} ?>> No
                                    </div><?php 
                                }
                                elseif($row[0] == 'e3_user_pad'){
                                    echo campoSelectMaster("e3_user", $row_reg[$row[0]], "*", "WHERE e3_tcont_id != '2'", "", "ORDER BY e3_user_nom ASC");
                                }
                                elseif($row[0] == 'e3_tdoc_id'){
                                    echo campoSelect($row_reg[$row[0]], 'e3_tdoc');
                                }
                                elseif($row[0] == 'e3_ciu_id'){
                                    echo campoSelect($row_reg[$row[0]], 'e3_ciu');
                                }
                                elseif($row[0] == 'e3_tcont_id'){
                                    echo campoSelect($row_reg[$row[0]], 'e3_tcont');
                                }
                                elseif($row[0] == 'e3_tper_id'){
                                    echo campoSelect($row_reg[$row[0]], 'e3_tper');
                                }
                                elseif($row[0] == 'e3_user_gen'){?>
                                    <div class="text-left">
                                        <input type="radio" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" value="1" <?php if(($row_reg[$row[0]] == '')||($row_reg[$row[0]] == '1')){echo "checked";} ?>> Femenino &nbsp;&nbsp;&nbsp;
                                        <input type="radio" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" value="2" <?php if(($row_reg[$row[0]] <> '')&&($row_reg[$row[0]] == '2')){echo "checked";} ?>> Masculino
                                    </div><?php 
                                }
                                elseif($row[0] == 'e3_user_img'){
                                    if($row_reg[$row[0]] <> ''){?>
                                        <img src="<?php echo $row_reg[$row[0]];?>" class="img-responsive" alt="Image" width="20%"><?php 
                                    }?>
                                    <input type="file" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" placeholder="Imagen de perfil y carnét" value="" <?php echo $required;?>><?php 
                                }
                                elseif($row[0] == 'e3_docs_emp'){
                                    for($i = 1; $i <= 5; $i++){
                                        $pos = false;
                                        if($i == 1){$label = "Tributar Asesores";$pos = strstr($row_reg[$row[0]], '1');}
                                        elseif($i == 2){$label = "Coveg Auditores";$pos = strstr($row_reg[$row[0]], '2');}
                                        elseif($i == 3){$label = "R + B Diseño Experimental";$pos = strstr($row_reg[$row[0]], '3');}
                                        elseif($i == 4){$label = "Editores Hache";$pos = strstr($row_reg[$row[0]], '4');}
                                        elseif($i == 5){$label = "Inversiones y Consultorias CV";$pos = strstr($row_reg[$row[0]], '5');}
                                        if($pos !== false){$checked = 'checked="checked"';}
                                        else{$checked = '';}?>
                                        <div class="checkbox col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                            <label>
                                                <input id="<?php echo $row[0].'_'.$i;?>" type="checkbox" name="<?php echo $row[0];?>[]" <?php echo $checked;?> value="<?php echo $i;?>">
                                                <?php echo $label;?>
                                            </label>
                                        </div><?php 

                                    }
                                }
                                elseif($row[0] == 'e3_docs_url'){
                                    if($row_reg[$row[0]] <> ''){?>
                                        <a class="btn btn-sm btn-default" href="<?php echo $row_reg[$row[0]];?>" target="_blank"><?php echo $row_reg['e3_docs_nom'];?></a><?php 
                                    }?>
                                    <input type="file" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" placeholder="Documento de consulta." value="" <?php echo $required;?>><?php 
                                }
                                else{?>
                                    <input type="text" name="<?php echo $row[0];?>" id="<?php echo $row[0];?>" class="form-control" value="<?php echo $row_reg[$row[0]];?>" <?php echo $required;?> pattern="" title=""><?php 
                                }?>
                            </div>
                        </div><?php 
                        if($required <> ''){
                            $campo_requerido[] = $row[0];
                        }
                    }
                }
            }
        }?>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="widget"></div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><?php 
            if($readonly == ''){
                if($id_reg <> ''){?>
                    <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $id_reg;?>">
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Actualizar</button><?php 
                }
                else{?>
                    <button type="submit" class="btn btn-success"><i class="glyphicon glyphicon-save"></i> Guardar</button><?php
                }
            }?>
            <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="widget"></div>
            </div>
        </div>
    </form>
</div>

<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-datepicker.min.js"></script> <!-- Datepicker -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function() {
        var read = '<?php echo $readonly;?>';
        editarListConfig(read);
        var arrayJS = <?php echo json_encode($campo_requerido);?>;
        for(var i = 0; i < arrayJS.length; i++) {
            $('#form_conf').bootstrapValidator('addField', arrayJS[i], {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    }
                }
            });
        }
        $('#form_conf').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                tabla: {
                    message: 'La tabla no es valido',
                    validators: {
                        notEmpty: {
                            message: 'La tabla es requerido'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            var pagina = $("#div_panel").val();
            var tabla = encodeURIComponent($("#tabla").val());
            var titulo = encodeURIComponent($("#titulo").val());
            var foto = $("#vistaPrevia").attr("src");
            var foto = window.btoa(foto);
            $("#e3_emp_img").val(foto);
            var datos_form = new FormData($("#form_conf")[0]);
            $.ajax({
                url:"../php/ins_upd_conf.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        $("#col-md-12").load("./"+pagina+".php?tbl_db="+tabla+"&tbl_title="+titulo);
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
    $('#e3_user_fnac').datepicker({format: "yyyy-mm-dd", autoclose: true});
    $('#e3_user_fing').datepicker({format: "yyyy-mm-dd", autoclose: true});
    // $('#e3_user_fecha').datetimepicker();
</script>