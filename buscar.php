
<?php
include_once("menu.php");

//recibo bandera
$bandera = $_GET['bandera'];
$dato = $_GET['dato'];
?>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Cuerpo de la pagina
----------------------------------------------------------------------
--------------------------------------------------------------------->		
<div class="span9">
	
	
	
 	<? if($bandera==1){?>
	<h3> Buscar y Conciliar </h3>
	<form class="form-horizontal" action="respuestabuscar.php" method="post" onsubmit="return control();" name="buscar">
	<? } else {?>
	<h3> Saldo clientes </h3>
	<form class="form-horizontal" action="respuestabuscarsaldo.php" method="post" onsubmit="return control();" name="buscar">
	<? } ?>
	<div class="control-group">
		<label class="control-label" for="inputEmail">Datos</label>
		<div class="controls">
			<? if(empty($dato)){?>
			<input type="text" name="cliente" class="span4" id="tags" placeholder="Ingrese datos">
			<? } else {?>
			<input type="text" name="cliente" class="span4" id="tags" value="<?=$dato;?>">
			<? } ?>
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
		<input type="submit" class="btn" name ="buscar" value="Buscar">
		<a class="btn btn-danger" href="index.php">Volver</a>
		</div>
	</div>
 	</form>
	<script>
		document.buscar.cliente.focus();
	</script>
 	

</div><!-- cierra clase span9-->

</div><!-- cierra clase row-->
	
	
	
<?php
include_once("footer.php");
?>

