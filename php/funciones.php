<?php 
// date_default_timezone_set('America/Bogota');
class EnLetras { 
  var $Void = ""; 
  var $SP = " "; 
  var $Dot = "."; 
  var $Zero = "0"; 
  var $Neg = "Menos";    
  function ValorEnLetras($x, $Moneda){ 
    $s=""; 
    $Ent=""; 
    $Frc=""; 
    $Signo="";         
    if(floatVal($x) < 0) 
     $Signo = $this->Neg . " "; 
    else 
     $Signo = "";       
    if(intval(number_format($x,2,'.','') )!=$x) //<- averiguar si tiene decimales 
      $s = number_format($x,2,'.',''); 
    else 
      $s = number_format($x,2,'.','');        
    $Pto = strpos($s, $this->Dot);         
    if ($Pto === false){ 
      $Ent = $s; 
      $Frc = $this->Void; 
    } 
    else{ 
      $Ent = substr($s, 0, $Pto ); 
      $Frc =  substr($s, $Pto+1); 
    }
    //echo $Ent."<br>";
    if($Ent == $this->Zero || $Ent == $this->Void) 
       $s = "Cero "; 
    elseif((strlen($Ent) == 13)&&(intval(substr($Ent, 0,  strlen($Ent) - 12)) == 1)){ 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 12))) . "Billón " . $this->SubValLetra(intval(substr($Ent,-12, 12))); 
    }
    elseif(strlen($Ent) > 12){ 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 12))) . "Billones " . $this->SubValLetra(intval(substr($Ent,-12, 12))); 
    }
    elseif((strlen($Ent) > 7)){ 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) . "Millones " . $this->SubValLetra(intval(substr($Ent,-6, 6))); 
    }
    elseif((strlen($Ent) == 7)&&(intval(substr($Ent, 0,  strlen($Ent) - 6)) == 1)){ 
       $s = $this->SubValLetra(intval( substr($Ent, 0,  strlen($Ent) - 6))) . "Millón " . $this->SubValLetra(intval(substr($Ent,-6, 6))); 
    }
    else{ 
      $s = $this->SubValLetra(intval($Ent)); 
    }
    if (substr($s,-9, 9) == "Millones " || substr($s,-7, 7) == "Millón " || substr($s,-8, 8) == "Millón " || substr($s,-8, 8) == "Billón " || substr($s,-9, 9) == "Billones ")
       $s = $s . "de ";
    $s = $s . $Moneda;
    /*if($Frc != $this->Void){ 
       $s = $s . " " . $Frc. "/100"; 
       $s = $s . " " . $Frc . "/100"; 
    }*/
    //$letrass=$Signo . $s . " M.N."; 
    return ($Signo . $s);
  }
  function SubValLetra($numero){ 
    $Ptr=""; 
    $n=0; 
    $i=0; 
    $x =""; 
    $Rtn =""; 
    $Tem ="";
    $x = trim($numero);
    $n = strlen($x);
    $Tem = $this->Void;
    $i = $n;
    while( $i > 0){ 
      $Tem = $this->Parte(intval(substr($x, $n - $i, 1).str_repeat($this->Zero, $i - 1 ))); 
      //echo intval(substr($x, $n - $i, 1).str_repeat($this->Zero, $i - 1 ))." - ".$x."<br>";
      if( $Tem != "Cero" )
        $Rtn .= $Tem . $this->SP; 
      $i = $i - 1; 
    }     
    //--------------------- GoSub FiltroMil ------------------------------ 
    $Rtn=str_replace("Mil Mil", " Un Mil", $Rtn );
    $Rtn=str_replace("Diez Un", "Once", $Rtn );
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn ); 
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn ); 
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn ); 
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn ); 
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn ); 
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn ); 
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn ); 
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn ); 
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn ); 
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn ); 
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn ); 
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn ); 
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn ); 
    $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn ); 
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn ); 
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn ); 
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn );
    while(1){ 
      $Ptr = strpos($Rtn, "Mil ");        
      if(!($Ptr===false)){ 
        if(! (strpos($Rtn, "Mil ",$Ptr + 1) === false )) 
          $this->ReplaceStringFrom($Rtn, "Mil ", "", $Ptr); 
        else 
          break; 
      } 
      else break; 
    }
    //--------------------- GoSub FiltroCiento ------------------------------ 
    $Ptr = -1; 
    do{ 
       $Ptr = strpos($Rtn, "Cien ", $Ptr+1); 
       if(!($Ptr===false)){ 
          $Tem = substr($Rtn, $Ptr + 5 ,1); 
          if( $Tem == "M" || $Tem == $this->Void) 
             ;
          else           
            $this->ReplaceStringFrom($Rtn, "Cien", "Ciento", $Ptr); 
       } 
    }while(!($Ptr === false));
    //--------------------- FiltroEspeciales ------------------------------ 
    $Rtn=str_replace("Diez Un", "Once", $Rtn ); 
    $Rtn=str_replace("Diez Dos", "Doce", $Rtn ); 
    $Rtn=str_replace("Diez Tres", "Trece", $Rtn ); 
    $Rtn=str_replace("Diez Cuatro", "Catorce", $Rtn ); 
    $Rtn=str_replace("Diez Cinco", "Quince", $Rtn ); 
    $Rtn=str_replace("Diez Seis", "Dieciseis", $Rtn ); 
    $Rtn=str_replace("Diez Siete", "Diecisiete", $Rtn ); 
    $Rtn=str_replace("Diez Ocho", "Dieciocho", $Rtn ); 
    $Rtn=str_replace("Diez Nueve", "Diecinueve", $Rtn ); 
    $Rtn=str_replace("Veinte Un", "Veintiun", $Rtn ); 
    $Rtn=str_replace("Veinte Dos", "Veintidos", $Rtn ); 
    $Rtn=str_replace("Veinte Tres", "Veintitres", $Rtn ); 
    $Rtn=str_replace("Veinte Cuatro", "Veinticuatro", $Rtn ); 
    $Rtn=str_replace("Veinte Cinco", "Veinticinco", $Rtn ); 
    $Rtn=str_replace("Veinte Seis", "Veintiseís", $Rtn ); 
    $Rtn=str_replace("Veinte Siete", "Veintisiete", $Rtn ); 
    $Rtn=str_replace("Veinte Ocho", "Veintiocho", $Rtn ); 
    $Rtn=str_replace("Veinte Nueve", "Veintinueve", $Rtn );
    $Rtn=str_replace("Un Mil", "Mil", $Rtn );
    //--------------------- FiltroUn ------------------------------ 
    if(substr($Rtn,0,1) == "M") $Rtn = "" . $Rtn; 
    //--------------------- Adicionar Y ------------------------------ 
    for($i=65; $i<=88; $i++){ 
      if($i != 77) 
        $Rtn=str_replace("a " . Chr($i), "* y " . Chr($i), $Rtn); 
    } 
    $Rtn=str_replace("*", "a" , $Rtn); 
    return($Rtn); 
  }
  function ReplaceStringFrom(&$x, $OldWrd, $NewWrd, $Ptr){ 
    $x = substr($x, 0, $Ptr)  . $NewWrd . substr($x, strlen($OldWrd) + $Ptr); 
  }
  function Parte($x){ 
    $Rtn=''; 
    $t=''; 
    $i=''; 
    do{ 
      switch($x){ 
        Case 0:  $t = "Cero";break; 
        Case 1:  $t = "Un";break; 
        Case 2:  $t = "Dos";break; 
        Case 3:  $t = "Tres";break; 
        Case 4:  $t = "Cuatro";break; 
        Case 5:  $t = "Cinco";break; 
        Case 6:  $t = "Seis";break; 
        Case 7:  $t = "Siete";break; 
        Case 8:  $t = "Ocho";break; 
        Case 9:  $t = "Nueve";break; 
        Case 10: $t = "Diez";break; 
        Case 20: $t = "Veinte";break; 
        Case 30: $t = "Treinta";break; 
        Case 40: $t = "Cuarenta";break; 
        Case 50: $t = "Cincuenta";break; 
        Case 60: $t = "Sesenta";break; 
        Case 70: $t = "Setenta";break; 
        Case 80: $t = "Ochenta";break; 
        Case 90: $t = "Noventa";break; 
        Case 100: $t = "Cien";break; 
        Case 200: $t = "Doscientos";break; 
        Case 300: $t = "Trescientos";break; 
        Case 400: $t = "Cuatrocientos";break; 
        Case 500: $t = "Quinientos";break; 
        Case 600: $t = "Seiscientos";break; 
        Case 700: $t = "Setecientos";break; 
        Case 800: $t = "Ochocientos";break; 
        Case 900: $t = "Novecientos";break;
        Case 1000: $t = "Mil";break;
        Case 1000000: $t = "Millón";break;
        Case 1000000000000: $t = "Billón";break;
      }
      if($t == $this->Void){ 
        $i = $i + 1; 
        $x = $x / 1000; 
        if($x== 0) $i = 0; 
      } 
      else 
        break;            
    }while($i != 0); 
    
    $Rtn = $t; 
    switch($i){ 
      Case 0: $t = $this->Void;break; 
      Case 1: $t = " Mil";break; 
      Case 2: $t = " Millones";break; 
      Case 3: $t = " Billones";break; 
    } 
    return($Rtn . $t); 
  }
}

########### Funcion que corta el texto a un tamaño dado
function getSubString($string, $length=NULL)
{
    //Si no se especifica la longitud por defecto es 50
    if ($length == NULL)
        $length = 50;
    //Primero eliminamos las etiquetas html y luego cortamos el string
    $stringDisplay = substr(strip_tags($string), 0, $length);
    //Si el texto es mayor que la longitud se agrega puntos suspensivos
    if (strlen(strip_tags($string)) > $length)
        $stringDisplay .= ' ...';
    return $stringDisplay;
}

########### Trae los datos de los partidos y devuelve el query rmas2784_admon ###########
function ColumnasTabla($tabla)
{
  $partidos = "";
  $sql=("SELECT COLUMN_NAME, COLUMN_COMMENT FROM information_schema.columns WHERE table_schema = 'rmb_admon' AND table_name = '$tabla' ORDER BY ORDINAL_POSITION ASC");
  $query=mysql_query($sql, conexion());
  if($query){
    $partidos=$query;
  } 
  return $partidos;
}
########### Trae los datos de los partidos y devuelve el query ###########
function ColumnasTabla2($tabla)
{
  $partidos = "";
  $sql=("SELECT COLUMN_NAME, IS_NULLABLE, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.columns WHERE table_schema = 'rmb_admon' AND table_name = '$tabla' ORDER BY ORDINAL_POSITION ASC");
  $query=mysql_query($sql, conexion());
    if($query){
    $partidos=$query;
  } 
  return $partidos;
}
########### Trae los datos de los partidos y devuelve el query ###########
function DatosTabla($tabla, $campos)
{
  $partidos = "";
  $sql=("SELECT $campos FROM $tabla");
  //echo $sql;
  $query=mysql_query($sql, conexion());
    if($query){
    $partidos=$query;
  } 
  return $partidos;
}
########### Funcion que genera contraseña o codigo alfanumerico aleatorio ###########
function generaPass(){
  //Se define una cadena de caractares. Te recomiendo que uses esta.
  $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890@#$%&*-_.";
  //Obtenemos la longitud de la cadena de caracteres
  $longitudCadena = strlen($cadena);
   
  //Se define la variable que va a contener la contraseña
  $pass = "";
  //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
  $longitudPass = 8;
   
  //Creamos la contraseña
  for($i = 1; $i <= $longitudPass; $i++){
      //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
      $pos = rand(0, $longitudCadena - 1);
   
      //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
      $pass .= substr($cadena, $pos, 1);
  }
  return $pass;
}
########### Trae los datos de los usuarios y devuelve el query ###########
function ValUser($email, $passw)
{
  $result = false;
  if(($email <> '')&&($passw <> '')){
    $sql=("SELECT e3_user_id, e3_user_nom, e3_user_ape, e3_perf_id FROM e3_user WHERE e3_user_email = '$email' AND e3_user_pass = '$passw' AND e3_est_id = '1' ORDER BY e3_user_nom ASC");
    // echo $sql;
    $query=mysql_query($sql, conexion());
    if($query){
      $result=$query;
    }
  }
  return $result;
}
########### Trae los datos de los contactos y devuelve el query ###########
function contactoBuscar($texto)
{
  $result = false;
  $texto = trim($texto);
  $sql = ("SELECT u.e3_user_id, u.e3_user_nom, u.e3_user_ape FROM e3_user u LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)");
  if($texto <> ''){
    $sql .= " AND (u.e3_user_nom LIKE '%$texto%' OR u.e3_user_ape LIKE '%$texto%' OR u.e3_user_doc LIKE '%$texto%' OR u.e3_user_email LIKE '%$texto%' OR u.e3_user_email2 LIKE '%$texto%' OR u.e3_user_obs LIKE '%$texto%' OR e.e3_emp_nom LIKE '%$texto%') AND u.e3_user_pub = 1";
  }
  $sql .= " ORDER BY u.e3_user_nom ASC";
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos de los contactos y devuelve el query ###########
function contactoBuscarId($id)
{
  $result = false;  
  if($id <> ''){
    $sql = ("SELECT * FROM e3_user WHERE e3_user_id = $id ORDER BY e3_user_nom ASC");
    // echo $sql;
    $query = mysql_query($sql, conexion());
    if($query){
      $result = $query;
    }
  }
  return $result;
}
########### Trae los datos de los contactos de los contactos y devuelve el query ###########
function contactoBuscarContactoId($id)
{
  $result = false;
  if($id <> ''){
    $sql = ("SELECT * FROM e3_user WHERE e3_user_pad = $id ORDER BY e3_user_nom ASC");
    // echo $sql;
    $query = mysql_query($sql, conexion());
    if($query){
      $result = $query;
    }
  }
  return $result;
}
########### Trae los datos de los contactos y devuelve el query ###########
function nombreCampo($id, $tabla)
{
  $result = "";
  if(($id <> '') && ($tabla <> '')){
    $sql = ("SELECT ".$tabla."_nom FROM ".$tabla." WHERE ".$tabla."_id = $id ORDER BY ".$tabla."_nom ASC");
    //echo $sql;
    $query = mysql_query($sql, conexion());
    if($query){
      if(mysql_num_rows($query) > 0){
        $row = mysql_fetch_array($query);
        $result = $row[0];
      }
    }
  }
  else{$result = "Sin información";}
  return $result;
}
########### Trae los datos de la ciudad, dpto y pais con el id de la ciudad y devuelve el query ###########
function nombreCiudadDptoPais($id)
{
  $result = "";
  
  if($id <> ''){$id_ciu = $id;}
  else{$id_ciu = 1;}
  $sql = ("SELECT p.e3_pais_nom, d.e3_dpto_nom, c.e3_ciu_nom FROM e3_ciu c LEFT JOIN e3_dpto d ON d.e3_dpto_id = c.e3_dpto_id LEFT JOIN e3_pais p ON p.e3_pais_id = d.e3_pais_id WHERE e3_ciu_id = $id_ciu");
  
  //echo $sql;
  $query = mysql_query($sql, conexion());
  if($query){
    if(mysql_num_rows($query) > 0){
      $row = mysql_fetch_array($query);
      $result = $row[0].",".$row[1].",".$row[2];
    }
  }
  return $result;
}
########### Trae los datos de la ciudad, dpto y pais con el id de la ciudad y devuelve el query ###########
function idCiudadDptoPais($id)
{
  $result = "";
  
  if($id <> ''){$id_ciu = $id;}
  else{$id_ciu = 2;}
  $sql = ("SELECT p.e3_pais_id, d.e3_dpto_id, c.e3_ciu_id FROM e3_ciu c LEFT JOIN e3_dpto d ON d.e3_dpto_id = c.e3_dpto_id LEFT JOIN e3_pais p ON p.e3_pais_id = d.e3_pais_id WHERE e3_ciu_id = $id_ciu");
  
  //echo $sql;
  $query = mysql_query($sql, conexion());
  if($query){
    if(mysql_num_rows($query) > 0){
      $row = mysql_fetch_array($query);
      $result = $row[0].",".$row[1].",".$row[2];
    }
  }
  return $result;
}
########### muestra el select de los grupos para ser seleccionado ############
function campoSelect($tdoc, $tabla)
{
	$sql = "SELECT * FROM $tabla";

  if($tdoc == ''){
    if($tabla == 'e3_perf'){
      $tdoc = 6;
      $sql .= " WHERE e3_perf_id != 1 ";
    }
    else if(($tabla == 'e3_tdoc')||($tabla == 'e3_tcont')||($tabla == 'e3_tper')){
      $tdoc = 1;
    }
  }

  $sql .= " ORDER BY ".$tabla."_nom ASC";

  $query=mysql_query($sql, conexion());
  $array=mysql_fetch_array($query);

	?>
	<select name="<?php echo $tabla.'_id';?>"  id="<?php echo $tabla.'_id';?>" class="form-control">
		<option value="" <?php if($tdoc == ''){echo 'selected="selected"';} ?> >Seleccione...</option>
		<?php do {  ?>
			<option value="<?php echo $array[0];?>" <?php if($tdoc == $array[0]){echo 'selected="selected"';} ?>><?php echo $array[1];?></option>
		<?php } while ($array = mysql_fetch_array($query));
			$rows = mysql_num_rows($query);
			if($rows > 0) {
			  mysql_data_seek($query, 0);
			  $array = mysql_fetch_array($query);
			}
		?>
    </select>
	<?php
}
########### muestra el select de los grupos para ser seleccionado ############
function campoSelectPerfilEmp($tdoc, $tabla)
{
  $sql = "SELECT * FROM $tabla";

  if($tdoc == ''){
    if($tabla == 'e3_perf'){
      $tdoc = 5;
      $sql .= " WHERE e3_perf_id != 1 AND e3_perf_id != 6 ";
    }
    else if(($tabla == 'e3_tdoc')||($tabla == 'e3_tcont')||($tabla == 'e3_tper')){
      $tdoc = 1;
    }
  }

  $sql .= " ORDER BY ".$tabla."_nom ASC";

  $query=mysql_query($sql, conexion());
  $array=mysql_fetch_array($query);

  ?>
  <select name="<?php echo $tabla.'_id';?>"  id="<?php echo $tabla.'_id';?>" class="form-control">
    <option value="" <?php if($tdoc == ''){echo 'selected="selected"';} ?> >Seleccione...</option>
    <?php do {  ?>
      <option value="<?php echo $array[0];?>" <?php if($tdoc == $array[0]){echo 'selected="selected"';} ?>><?php echo $array[1];?></option>
    <?php } while ($array = mysql_fetch_array($query));
      $rows = mysql_num_rows($query);
      if($rows > 0) {
        mysql_data_seek($query, 0);
        $array = mysql_fetch_array($query);
      }
    ?>
    </select>
  <?php
}
########### muestra el select de los grupos para ser seleccionado ############
function campoSelectPadre($tdoc, $tabla)
{
  $sql = "SELECT ".$tabla."_id, ".$tabla."_nom, ".$tabla."_ape FROM $tabla ORDER BY ".$tabla."_nom ASC";
  //echo $sql;
  $query=mysql_query($sql, conexion());
  $array=mysql_fetch_array($query);

  ?>
  <select name="e3_user_pad"  id="e3_user_pad" class="form-control">
    <option value="" <?php if($tdoc == ''){echo 'selected="selected"';} ?> >Seleccione...</option>
    <?php do {  ?>
      <option value="<?php echo $array[0];?>" <?php if($tdoc == $array[0]){echo 'selected="selected"';} ?>><?php echo $array[1]. " " .$array[2];?></option>
    <?php } while ($array = mysql_fetch_array($query));
      $rows = mysql_num_rows($query);
      if($rows > 0) {
        mysql_data_seek($query, 0);
        $array = mysql_fetch_array($query);
      }
    ?>
    </select>
  <?php
}
########### Trae los datos de los contactos y devuelve el query ###########
function menuBuscar()
{
  $result = false;
  $sql = ("SELECT e3_mod_nom, e3_mod_pag, e3_mod_id FROM e3_mod WHERE e3_est_id > 0 ORDER BY e3_mod_nom ASC");
  //echo $sql;
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos de los empleados y devuelve el query ###########
function empleadosBuscar($texto)
{
  $result = false;
  $texto = trim($texto);
  $sql = ("SELECT u.e3_user_id, u.e3_user_nom, u.e3_user_ape, u.e3_user_doc, u.e3_user_email, u.e3_user_email2, u.e3_user_tel, u.e3_user_cel, u.e3_user_img, carg.e3_carg_nom, e.e3_emp_nom FROM e3_user u LEFT JOIN e3_cont c USING(e3_user_id) LEFT JOIN e3_carg carg USING(e3_carg_id) LEFT JOIN e3_emp e USING(e3_emp_id) WHERE u.e3_tcont_id = '2' AND u.e3_est_id = '1'");
  if($texto <> ''){
    $sql .= " AND (u.e3_user_nom LIKE '%$texto%' OR u.e3_user_ape LIKE '%$texto%' OR u.e3_user_doc LIKE '%$texto%' OR u.e3_user_email LIKE '%$texto%' OR u.e3_user_email2 LIKE '%$texto%' OR u.e3_user_obs LIKE '%$texto%' OR e.e3_emp_nom LIKE '%$texto%')";
    //  AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)
  }
  $sql .= " GROUP BY u.e3_user_id ORDER BY u.e3_user_ape ASC, c.e3_cont_fini DESC";
  // echo $sql;
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos de los contactos y devuelve el query ###########
function empleadoBuscarId($id)
{
  $result = false;  
  if($id <> ''){
    $sql = ("SELECT u.e3_user_id, u.e3_user_nom, u.e3_user_ape, u.e3_user_doc, u.e3_user_dir, u.e3_user_ind, u.e3_user_area, u.e3_user_tel, u.e3_user_ext, u.e3_user_cel, u.e3_user_email, u.e3_user_email2, u.e3_user_fnac, u.e3_user_obs, u.e3_user_pub, u.e3_user_pad, u.e3_user_emerg_nom, u.e3_user_emerg_tel, u.e3_user_fecha, u.e3_user_user, u.e3_tdoc_id, u.e3_perf_id, u.e3_user_perf, u.e3_est_id, u.e3_ciu_id, u.e3_tper_id, u.e3_user_emp, u.e3_user_gen, u.e3_user_fing, u.e3_user_hora, u.e3_user_img, u.e3_user_rh, c.e3_carg_id, c.e3_area_id, u.e3_tcont_id, c.e3_emp_id, c.e3_cont_sal, card.e3_card_nom, c.e3_cont_door, c.e3_cont_cta, c.e3_ban_id, c.e3_cont_pval, c.e3_cont_pent, c.e3_cont_pfch, c.e3_tcon_id, u.e3_user_cdoc FROM e3_user u LEFT JOIN e3_cont c ON c.e3_user_id = u.e3_user_id LEFT JOIN e3_card card ON card.e3_user_id = u.e3_user_id WHERE u.e3_user_id = $id AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL) ORDER BY u.e3_user_ape ASC");
    //  AND (c.e3_cont_ffin = '0000-00-00' OR c.e3_cont_ffin IS NULL)
    // echo $sql;
    $query = mysql_query($sql, conexion());
    if($query){
      $result = $query;
    }
  }
  return $result;
}
########### Trae los datos de los contactos de los contactos y devuelve el query ###########
function empleadoBuscarEmpleadoId($id)
{
  $result = false;
  if($id <> ''){
    $sql = ("SELECT * FROM e3_user WHERE e3_user_pad = '$id' ORDER BY e3_user_nom ASC");
    //echo $sql;
    $query = mysql_query($sql, conexion());
    if($query){
      $result = $query;
    }
  }
  return $result;
}
########### Trae los datos de los contactos y devuelve el query ###########
function otrosDatos($id_user, $tabla)
{
  $result = false;
  $sql = ("SELECT * FROM $tabla WHERE e3_user_id = '$id_user' ORDER BY ".$tabla."_fini DESC");
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos de los contactos y devuelve el query ###########
function otrosDatos2($id, $tabla)
{
  $result = false;
  $sql = ("SELECT * FROM $tabla WHERE ".$tabla."_id = $id");
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos segun los campos solicitados de la tabla solicitada con el id enviado y devuelve el query ###########
function otrosDatos3($id, $tabla, $campos)
{
  $result = false;
  $sql = ("SELECT $campos FROM $tabla WHERE ".$tabla."_id = $id");
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos segun los campos solicitados de la tabla solicitada con el id enviado y con la condicion presentada y devuelve el query ###########
function otrosDatos4($id, $tabla, $campos, $where)
{
  $result = false;
  $sql = ("SELECT $campos FROM $tabla WHERE e3_user_id = $id ".$where);
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
########### Trae los datos del proximo id de la tabla y devuelve el query ###########
function NextID($base, $tabla)
{
  $partidos = "";
  $sql = ("SELECT auto_increment FROM information_schema.tables WHERE table_schema='$base' and table_name='$tabla'");
  $query = mysql_query($sql, conexion());
    if($query){
      if(mysql_num_rows($query) > 0){
        $row_query = mysql_fetch_array($query);
        $partidos = $row_query[0];
      }     
  }
  return $partidos;
}
### Consultar si existe un valor en un campo de una tabla dada ###
function consultaCampo($valor, $campo, $tabla)
{
  $result = 0;
  $sql = "SELECT $campo FROM $tabla WHERE $campo = '$valor'";
  $query = mysql_query($sql, conexion());
  if($query){
    if(mysql_num_rows($query) > 0){
      $result = mysql_num_rows($query);
    }
  }
  return $result;
}
### Consultar registros de un valor en un campo de una tabla dada ###
function registroCampo($tabla, $campos, $where, $group, $order)
{
  $result = false;
  $sql = "SELECT $campos FROM $tabla $where $group $order";
  // echo $sql."<br />";
  $query = mysql_query($sql, conexion());
  if($query){
    $result = $query;
  }
  return $result;
}
// diferencia entre dos horas
function restaHours($inicio, $fin)
{
  $new_hour = ((strtotime($fin) - strtotime($inicio)) + strtotime("00:00:00"));
  return $new_hour;
}
// Suma entre dos horas
function sumarHours($inicio, $fin)
{
  $new_hour = ((strtotime($inicio) + strtotime($fin)) - strtotime("00:00:00"));
  return $new_hour;
}
// funcion que convierte fecha en timestamp a formado dias minutos segundos
function human_time($input_seconds) {
  $days = 0;$hours = 0;$minutes = 0;$seconds = 0;
  $input_seconds = $input_seconds - strtotime('00:00:00');
  $days=floor($input_seconds / 86400);
  $remainder=floor($input_seconds % 86400);
  $hours=floor($remainder / 3600);
  $remainder=floor($remainder % 3600);
  $minutes=floor($remainder / 60);
  $seconds=floor($remainder % 60);
  if($days>0){
    $days = agregaceros($days, 2)."día(s) ";
  }
  else{$days = "";}
  $hours = agregaceros($hours, 2).":";
  $minutes = agregaceros($minutes, 2).":";
  $seconds = agregaceros($seconds, 2);
  return $days.$hours.$minutes.$seconds;
}
// funcion que agrega ceros a una variable
function agregaceros($value="0", $ceros="2")
{
  $new_valor = $value;
  for($i=0; $i<$ceros; $i++){
    if(strlen($new_valor) < $ceros){
      $new_valor = "0".$new_valor;
    }
  }
  return $new_valor;
}
########### muestra el select de los usuarios registrados segun parametro enviado para ser seleccionado ############
function campoSelectMaster($tabla, $id, $campos, $where, $group, $order){
  $sql = "SELECT $campos FROM $tabla $where $group $order";
  // echo $sql;
  $query=mysql_query($sql, conexion());
  $array=mysql_fetch_array($query);
  if($tabla == 'e3_user u'){
    $name = "e3_user_card";
  }
  else{
    $name = $tabla."_id";
  }
  ?>
  <select name="<?php echo $name;?>"  id="<?php echo $name;?>" class="form-control">
    <option value="" <?php if($id == ''){echo 'selected="selected"';} ?> >Seleccione...</option><?php 
    do { 
      $value = $array[0];
      if($tabla == 'e3_user u'){
        $valor = $array[1]." ".$array[2];
      }
      elseif($tabla == 'e3_cont'){
        $valor = $array[0]." - ".$array[1]." - ".$array[2];
      }
      else{
        $valor = $array[1];
      }
      if(mysql_num_rows($query) > 0){?>
        <option value="<?php echo $value;?>" <?php if(($id == $value) && ($id <> '')){echo 'selected="selected"';} ?>><?php echo $valor;?></option><?php 
      }
    } while ($array = mysql_fetch_array($query));
      $rows = mysql_num_rows($query);
      if($rows > 0) {
        mysql_data_seek($query, 0);
        $array = mysql_fetch_array($query);
      }
    ?>
    </select>
  <?php
}
// funcion que convierte hora en formato HH:MM:SS a segundos
function hora_a_segundos($hora) { 
    list($h, $m, $s) = explode(':', $hora);
    $segundos = ($h * 3600) + ($m * 60) + $s;
    $minutos = $segundos / 60;
    return $segundos;
} 
// funcion que convierte segundos a hora en formato HH:MM:SS
function segundos_a_hora($segundos) { 
    $h = floor($segundos / 3600); 
    $m = floor(($segundos % 3600) / 60); 
    $s = $segundos - ($h * 3600) - ($m * 60); 
    return sprintf('%02d:%02d:%02d', $h, $m, $s); 
}
// funcion que convierte hora formato timestamp a numero de minutos
function timestamp_a_minutos($timestamp)
{
  // $days = 0;
  // $hours = 0;
  $minutes = 0;
  // $seconds = 0;
  $timestamp = $timestamp - strtotime('00:00:00');
  // $days=floor($timestamp / 86400);
  // $remainder=floor($timestamp % 86400);
  // $hours=floor($timestamp / 3600);
  // $remainder=floor($remainder % 3600);
  $minutes=floor($timestamp / 60);
  // $seconds=floor($remainder % 60);
  return $minutes;
}
// funcion que devuelve los dias en letras 3
function diasTres($ndia)
{
  $dias = array("", "Lun","Mar","Mie","Jue","Vie","Sáb","Dom");
  $dia = $dias[$ndia];
  return $dia;
}
// funcion que devuelve los dias en letras 3
function diasTodos($ndia)
{
  $dias = array("", "Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
  $dia = $dias[$ndia];
  return $dia;
}
// funcion que devuelve los mese en letras todas
function mesesLetras($nmes)
{
  $meses = array("", "Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $mes = $meses[(int) $nmes];
  return $mes;
}
// Funcion que se ejecuta para establecer el numero de periodos de vacaciones que un empleado tiene
function vacasPeriodos($fing_anio, $nperiodos)
{
  if($nperiodos == ''){$nperiodos = 0;}
  if($fing_anio <> ''){
    $fact_anio = date("Y");
    if($fing_anio < $fact_anio){
      $fing_anio += 1;
      $nperiodos += 1;
      return vacasPeriodos2($fing_anio, $nperiodos);
    }
    else{
      return $nperiodos;
    }
  }
}// Funcion que se ejecuta para establecer el numero de periodos de vacaciones que un empleado tiene para completa el bucle
function vacasPeriodos2($fing_anio, $nperiodos)
{
  if($nperiodos == ''){$nperiodos = 0;}
  if($fing_anio <> ''){
    $fact_anio = date("Y");
    if($fing_anio < $fact_anio){
      $fing_anio += 1;
      $nperiodos += 1;
      return vacasPeriodos($fing_anio, $nperiodos);
    }
    else{
      return $nperiodos;
    }
  }
}
// Funcion que devuelve el numero de dias diferencia entre dos fechas
function diferenciaDias($inicio, $fin)
{
    $inicio = strtotime($inicio);
    $fin = strtotime($fin);
    $dif = $fin - $inicio;
    $diasFalt = ((( $dif / 60 ) / 60 ) / 24 );
    return round($diasFalt);
}
####  Trae los campos y la meta data de la tabla  ####
function schemaTabla($tabla){
  $res = false;
  if($tabla <> ''){
    //Select que me trae la metadata de la tabla
    $sql= "SELECT COLUMN_NAME, COLUMN_KEY, COLUMN_COMMENT, IS_NULLABLE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = '".$tabla."' AND table_schema = 'hache_eco_empresarial' ";// cambiar eco_empresarial por hache_eco_empresarial para la base de datos de editoreshache
    // echo $sql;
    $res = mysql_query($sql, conexion());
  }
  return $res;
}
















?>