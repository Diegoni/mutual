
<?php
include_once("menu.php");
?>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Cuerpo de la pagina
----------------------------------------------------------------------
--------------------------------------------------------------------->		
<div class="span9">

 	
	<form class="form-horizontal" action="respuestabuscarsaldo.php" method="post" onsubmit="return controlsaldo();" name="buscar">
	<div class="control-group">
		<label class="control-label" for="inputApellido">Apellido</label>
		<div class="controls">
			<input type="text" name="apellido" class="span4" id="tags" placeholder="Ingrese apellido">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="inputNombre">Nombre</label>
		<div class="controls">
			<input type="text" name="nombre" class="span4" id="tags" placeholder="Ingrese nombre">
		</div>
	</div>
	
	<div class="control-group">
		<label class="control-label" for="inputDNI">DNI</label>
		<div class="controls">
			<input type="text" name="DNI" class="span4" id="tags" onkeypress="return soloNumeros(event)" placeholder="Ingrese DNI">
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
		<input type="submit" class="btn" name ="buscar" value="Buscar">
		<a class="btn btn-danger" href="index.php">Volver</a>
		</div>
	</div>
 	</form>
 	

</div><!-- cierra clase span9-->

</div><!-- cierra clase row-->
	
	
	
<?php
include_once("footer.php");
?>

