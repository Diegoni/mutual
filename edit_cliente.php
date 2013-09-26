<!--------------------------------------------------------------------
----------------------------------------------------------------------
						Editar al cliente
----------------------------------------------------------------------
--------------------------------------------------------------------->		

		

<?php
include_once("head.php");      

	
/*--------------------------------------------------------------------
----------------------------------------------------------------------
					Primer Paso... busco al cliente
----------------------------------------------------------------------
--------------------------------------------------------------------*/	
	if (isset($_POST['Modificar']))
	{
		$id = $_POST['id'];
		
		mysql_query("UPDATE `clientes` SET 
		nombre='".$_POST['nombre']."', 
		apellido='".$_POST['apellido']."' ,
		telefono='".$_POST['telefono']."' ,
		Direccion='".$_POST['direccion']."', 
		email='".$_POST['email']."' 
		WHERE idclientes='".$id."' ") or die(mysql_error()); ?>
		<script>
		window.close();
		</script>
	<? }
	else if (!(isset($_POST['Modificar']))){

	//asigno las variables
 	$id = $_GET['id'];

	$query="SELECT * FROM `clientes` WHERE idclientes='".$id."'";   
	$result=mysql_query($query) or die(mysql_error());
	mysql_query("SET NAMES 'utf8'");
	while ($rows = mysql_fetch_array($result))
 	{ ?>	
	
	<div class="container; celeste">

	<form class="form-horizontal" action="edit_cliente.php" method="post">
	<div class="control-group">
		<label class="control-label" for="inputNombre" title="Obligatorio"><i class="icon-user"></i> Nombre</label>
		<div class="controls">
			<input type="text" class="span4" name="nombre" value="<?echo $rows['nombre']?>" required>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputApellido" title="Obligatorio"><i class="icon-group"></i> Apellido</label>
		<div class="controls">
			<input type="text" class="span4" name="apellido" value="<?echo $rows['apellido']?>" required>	
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputTelefono" title="Solo números y espacios"><i class="icon-phone"></i> Telefono</label>
		<div class="controls">
			<input type="text" class="span4" name="telefono" onkeypress="return isNumberKey(event)" value="<?echo $rows['telefono']?>">
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputDireccion"><i class="icon-truck"></i> Direccion</label>
		<div class="controls">
			<input type="text" class="span4" name="direccion" value="<?echo $rows['Direccion']?>">
	</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputEmail" title="Solo email"><i class="icon-envelope-alt"></i> Email</label>
		<div class="controls">
			<input type="email" class="span4" name="email" value="<?echo $rows['email']?>">
	</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<input type="hidden" name="id" value="<?echo $id?>">
			<input type="submit" class="btn" name="Modificar" value="modificar"  id="modificar">
			<a class="btn btn-danger" href="" title="no guarda los cambios realizados" onClick="cerrarse()">volver</a>
		</div>
	</div>

	</form>
	</div> 
 	<? 	} // cierra el while
		} //cierra else?>
 
