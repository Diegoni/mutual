
<?php
include_once("menu.php");
?>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Cuerpo de la pagina
----------------------------------------------------------------------
--------------------------------------------------------------------->		
<div class="span9">

 	
	<form class="form-horizontal" action="respuestabuscar.php" method="post" onsubmit="return control();" name="buscar">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Datos</label>
		<div class="controls">
			<input type="text" name="cliente" class="span4" id="tags" placeholder="Ingrese datos">
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

