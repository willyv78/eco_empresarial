<!-- columna derecha del contenido contactos -->
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 column">
  <!-- Search formulario -->
  <div class="input-group input-group-md">
    <span id="search_cont_icon" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
    <input id="search_cont" type="search" class="form-control" placeholder="Buscar Contacto">
    <span id="new_cont" class="input-group-addon" title="Agregar Nuevo Contacto"><i class="glyphicon glyphicon-plus"></i></span>
  </div>
  <!-- div que carga el detalle del contacto para agregar nuevo -->
  <div id="col_der" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"></div>
  <!-- Cintenido resultado de la busqueda en una lista -->
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="contenido_lista"></div>
</div>

<script>cargaLista();</script>