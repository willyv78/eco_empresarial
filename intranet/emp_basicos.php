<?php session_start();
require_once ("../php/conexion/conexion.php");
require_once ("../php/funciones.php");
$nom = "";$ape = "";$ndoc = "";$cdoc = "";$dir = "";$ind = "";$areat = "";$telf = "";$ext = "";$telc = "";$emailc = "";$emailp = "";$fnac = "";$obs = "";$pub = "";$pad = "";$nome = "";$tele = "";$user = "";$tdoc = "";$tcont = "";$est = "";$ciu = "";$tpers = "";$perf = "";$empp = "";$gen = "";$fing = "";$hora = "";$img = "";$tcont = "";$rh = "";
if(isset($_GET["id_emp"]))
{
  $emp_id = $_GET["id_emp"];
  $accion = "Editar Registro";
}
else
{
  $emp_id = "";
  $accion = "Nuevo Registro";
}

for($i = 1; $i <= 10; $i++){
    $hing[$i] = "";
    if(!$hing[$i]){
        $hing[$i] = "";
        $hsal[$i] = "";
    }
}

$res_bus = empleadoBuscarId($emp_id);
if($res_bus)
{
    if(mysql_num_rows($res_bus) > 0)
    {
        $row = mysql_fetch_array($res_bus);
        $nom = $row[1];
        $ape = $row[2];
        $ndoc = $row[3];
        $cdoc = $row[45];
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
        $nome = $row[16];
        $tele = $row[17];
        $fecha = $row[18];
        $user = $row[19];
        $tdoc = $row[20];
        $tcont = $row[21];
        $perf = $row[22];
        $est = $row[23];
        $ciu = $row[24];
        $tpers = $row[25];
        $empp = $row[26];
        $gen = $row[27];
        $fing = $row[28];
        $hora = $row[29];
        $img = $row[30];
        $rh = $row[31];
        $res_ing = registroCampo('e3_horario', 'e3_horario_dia, e3_horario_hent, e3_horario_hsal', 'WHERE e3_user_id = '.$emp_id.'', '', 'ORDER BY e3_horario_dia ASC');
        if($res_ing){
            if(mysql_num_rows($res_ing) > 0){
                while($row_ing = mysql_fetch_array($res_ing)){
                    for($i = 1; $i <= 10; $i++){
                        if($i == $row_ing[0]){
                            $hing[$row_ing[0]] = $row_ing[1];
                            $hsal[$row_ing[0]] = $row_ing[2];
                        }
                    }                    
                }                
            }
        }
    }
}
?>
<div class="btblue">
    <form id="form_bas" name="form_bas" action="" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
        <div class="form-group">
            <!-- <label><?php echo $accion; ?></label> -->
            <input type="hidden" name="div_panel" id="div_panel" class="form-control" value="emp_basicos">
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_tdoc_id">Tipo de Documento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <?php echo campoSelect($tdoc, "e3_tdoc");?>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_doc">Número de Documento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_doc" type="text" name="e3_user_doc" placeholder="Número de Documento" value="<?php echo $ndoc;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_cdoc">Ciudad Expedición Documento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_cdoc" type="text" name="e3_user_cdoc" placeholder="Ciudad de Expedición de Documento" value="<?php echo $cdoc;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_nom">Nombre(s): </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_nom" type="text" name="e3_user_nom" placeholder="Nombre(s)" value="<?php echo $nom;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_ape">Apellido(s): </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_ape" type="text" name="e3_user_ape" placeholder="Apellido(s)" value="<?php echo $ape;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_tel">Telefono fijo: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_ind" type="text" name="e3_user_ind" placeholder="+57" value="<?php echo $ind;?>" class="cont-group indareaext form-control" />
                  <input id="e3_user_area" type="text" name="e3_user_area" placeholder="(1)" value="<?php echo $areat;?>" class="cont-group indareaext form-control" />
                  <input id="e3_user_tel" type="text" name="e3_user_tel" placeholder="Número." value="<?php echo $telf;?>" class="cont-group ntel form-control" />
                  <input id="e3_user_ext" type="text" name="e3_user_ext" placeholder="Ext." value="<?php echo $ext;?>" class="cont-group indareaext form-control" />
                  <i class="mensaje-box">Ind. País + Área + Num + Ext</i>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_cel">Teléfono Celular: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_cel" type="text" name="e3_user_cel" placeholder="Número celular" value="<?php echo $telc;?>" class="cont-group form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_email">Email Principal: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_email" type="email" name="e3_user_email" placeholder="Email Principal" value="<?php echo $emailc;?>" class="cont-group form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_email2">Email Secundario: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_email2" type="email" name="e3_user_email2" placeholder="Email Secundario" value="<?php echo $emailp;?>" class="cont-group form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_fing">Fecha de  Ingreso: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_fing" type="date" name="e3_user_fing" placeholder="dd/mm/aaaa" value="<?php echo $fing;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_perf_id">Mostrar Ent./Sal.: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <div class="radio">
                    <label>
                        <input type="radio" name="e3_user_hora" id="input" value="1" <?php if(($hora == '')||($hora == '1')){echo "checked";} ?>> Sí &nbsp;&nbsp;&nbsp;
                    </label>
                    <label>
                        <input type="radio" name="e3_user_hora" id="input" value="2" <?php if(($hora <> '')&&($hora == '2')){echo "checked";} ?>> No
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_img">Foto carnét:</label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7"><?php 
            if($img <> ''){?>
                <img src="<?php echo $img;?>" class="img-responsive" alt="Image" width="20%"><?php
            }?>
            <input type="file" name="e3_user_img" id="e3_user_img" class="form-control" placeholder="Imagen de perfil y carnét" value="">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_perf_id">Perfil Contacto: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <?php echo campoSelectPerfilEmp($tcont, "e3_perf");?>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_dir">Dirección: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_dir" type="text" name="e3_user_dir" placeholder="Dirección correspondencia" value="<?php echo $dir;?>" class="cont-group form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_fnac">Fecha de  Nacimiento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_fnac" type="date" name="e3_user_fnac" placeholder="dd/mm/aaaa" value="<?php echo $fnac;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_rh">Grupo Sanguíneo y Factor RH: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <select name="e3_user_rh" id="e3_user_rh" class="form-control">
                    <option <?php if($rh == ''){echo "selected";}?> value="">Seleccione...</option>
                    <optgroup label="Grupo Sanguíneo y factor RH">
                        <option <?php if($rh == 'A+'){echo "selected";}?> value="A+">A+</option>
                        <option <?php if($rh == 'A-'){echo "selected";}?> value="A-">A-</option>
                        <option <?php if($rh == 'AB+'){echo "selected";}?> value="AB+">AB+</option>
                        <option <?php if($rh == 'AB-'){echo "selected";}?> value="AB-">AB-</option>
                        <option <?php if($rh == 'B+'){echo "selected";}?> value="B+">B+</option>
                        <option <?php if($rh == 'B-'){echo "selected";}?> value="B-">B-</option>
                        <option <?php if($rh == 'O+'){echo "selected";}?> value="O+">O+</option>
                        <option <?php if($rh == 'O-'){echo "selected";}?> value="O-">O-</option>
                    </optgroup>
                </select>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_est_id">Estado: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <?php echo campoSelectMaster("e3_est", $est, "*", "WHERE e3_mod_id = '1'", "", "") ?>
            </div>
        </div><?php 
            $paisdptociu = explode(",", idCiudadDptoPais($ciu));
            $pais = $paisdptociu[0];
            $dpto = $paisdptociu[1];
            $ciu = $paisdptociu[2];?>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_pais_id">País: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <?php echo campoSelect($pais, "e3_pais");?>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_dpto_id">Departamento: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <?php echo campoSelect($dpto, "e3_dpto");?>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_ciu_id">Ciudad: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <?php echo campoSelect($ciu, "e3_ciu");?>
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_emerg_nom">En caso de Emergencia: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_emerg_nom" type="text" name="e3_user_emerg_nom" placeholder="En caso de emergencia llamar a?" value="<?php echo $nome;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_emerg_tel">Teléfono: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <input id="e3_user_emerg_tel" type="text" name="e3_user_emerg_tel" placeholder="Número en caso de emergencia." value="<?php echo $tele;?>" class="form-control" />
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <label class="col-xs-12 col-sm-5 col-md-5 col-lg-5 control-label" for="e3_user_obs">Observación: </label>
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                <textarea name="e3_user_obs" id="e3_user_obs" rows="3" placeholder="Ingrese una observación del contacto, algo que le ayude a recordar de quien se trata, o tambien puede colocar el horario en que el contacto esta disponible, si cree que no es necesario deje el campo en blanco." class="form-control" ><?php echo $obs;?></textarea>
                <input type="hidden" name="e3_tcont_id" id="e3_tcont_id" class="form-control" value="2">
            </div>
        </div>
        <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <br>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center"><?php 
            if($emp_id != ''){?>
                <input id="id_upd" type="hidden" name="id_upd" value="<?php echo $exp_id;?>">
                <button type="submit" class="btn btn-success">Actualizar</button><?php 
            }
            else{?>
                <button type="submit" class="btn btn-success">Guardar</button><?php

            }?>
            <button id="btn_cancelar" type="button" class="btn btn-info"><i class="glyphicon glyphicon-arrow-left"></i> Cancelar</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                <div class="widget"></div>
            </div>
        </div>
    </form>
</div>
<!-- jQuery -->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script src="../js/bootstrap-datepicker.min.js"></script> <!-- Datepicker -->
<script type="text/javascript" src="../js/bootstrapValidator.min.js"></script>
<script>
    $(document).ready(function() {
        empBasicos();
        $('#form_bas').bootstrapValidator({
            message: 'Este valor no es valido',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                e3_user_nom: {
                    message: 'El nombre del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El nombre del empleado es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El nombre del empleado debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'El nombre del empleado debe contener letras.'
                        }
                    }
                },
                e3_user_ape: {
                    message: 'El apellido del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El apellido del empleado es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 80,
                            message: 'El apellido del empleado debe contener de 3 a 80 characteres'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\_\s\.\-]+$/,
                            message: 'El apellido del empleado debe contener letras.'
                        }
                    }
                },
                e3_user_doc: {
                    message: 'El número de documento del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El número de documento del empleado es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 45,
                            message: 'El número de documento del empleado debe contener de 3 a 45 números'
                        },
                        regexp: {
                            regexp: /^[0-9]+$/,
                            message: 'El número de documento del empleado debe contener solo números.'
                        }
                    }
                },
                e3_user_dir: { 
                    message: 'La dirección del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'La dirección del empleado es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 100,
                            message: 'La dirección del empleado debe contener de 3 a 100 characteres'
                        }
                    }
                },
                e3_user_tel: {
                    message: 'El teléfono del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El teléfono del empleado es requerido'
                        },
                        stringLength: {
                            min: 3,
                            max: 45,
                            message: 'El teléfono del empleado debe contener de 3 a 45 characteres'
                        }
                    }
                },
                e3_perf_id: {
                    message: 'El perfil del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El perfil del empleado es requerido'
                        }
                    }
                },
                e3_est_id: {
                    message: 'El estado del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El estado del empleado es requerido'
                        }
                    }
                },
                e3_tdoc_id: {
                    message: 'El tipo de documento del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El tipo de documento del empleado es requerido'
                        }
                    }
                },
                e3_user_sal: {
                    message: 'El salario del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El salario del empleado es requerido'
                        }
                    }
                },
                e3_user_email: {
                    message: 'El email del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El email del empleado es requerido'
                        },
                        emailAddress: {
                            message: 'El email del empleado no es valido'
                        }
                    }
                },
                e3_user_fing: {
                    message: 'La fecha de ingreso del empleado no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La fecha de ingreso del empleado es requerida'
                        }
                    }
                },
                e3_tcon_id: {
                    message: 'El salario del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'El salario del empleado es requerido'
                        }
                    }
                },
                e3_emp_id: {
                    message: 'La empresa de labores del empleado no es valida',
                    validators: {
                        notEmpty: {
                            message: 'La empresa de labores del empleado es requerida'
                        }
                    }
                },
                e3_user_door: {
                    message: 'La puerta de ingreso del empleado no es valido',
                    validators: {
                        notEmpty: {
                            message: 'La puerta de ingreso del empleado es requerido'
                        }
                    }
                }
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            var id_emp = $("#id_emp").val();
            if(id_emp != ''){
                $("#id_upd").val(id_emp);
            }
            var datos_form = new FormData($("#form_bas")[0]);
            $.ajax({
                url:"../php/ins_upd_bas.php",
                cache:false,
                type:"POST",
                contentType:false,
                data:datos_form,
                processData:false,
                success: function(datos){
                    if(datos !== ''){
                        // alert(datos);
                        // $("#col-md-12").load("./rrhh.php");
                        swal({
                            title: "Felicidades!",
                            text: "El registro se ha guardado correctamente!",
                            type: "success",
                            confirmButtonText: "Continuar",
                            confirmButtonColor: "#94B86E"
                        });
                        $("#emp_det").load("./emp_det_ed.php?emp_id="+datos);
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
    $(function () {
        $('#e3_user_fing').datepicker({format: "yyyy-mm-dd", autoclose: true});
    });
</script>
