
<?php
include_once("menu.php");
?>
<div class="span9">

 	<!-- Boton de busqueda-->			  	
	<form class="form-horizontal" action="respuestaconciliados.php" method="post">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Datos</label>
		<div class="controls">
		<input type="text" name="dninput" class="span4" placeholder="Ingrese el DNI que esta buscando">
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
		<input type="submit" class ="btn" name ="buscar" value="Buscar">
		<a class="btn btn-danger" href="index.php">Volver</a>
		</div>
	</div>
 	</form>

</div><!-- cierra clase span9-->

</div><!-- cierra clase row-->

<?php
include_once("footer.php");
?>

