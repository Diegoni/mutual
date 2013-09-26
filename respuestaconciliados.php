
<?php
include_once("menu.php");
?>
<div class="span9">
<?php      


	// Hago la busqueda

 	//if (isset($_POST['buscar']))
 	if ($_POST['dninput'])
 	{
	//asigno las variables
 	$dni = $_POST['dninput'];

 	//$nombre=$_POST['nombre'];

	$query="SELECT * FROM `log_clientes_conciliados` where dni=".$dni." ORDER BY apellido ASC";
    $result=mysql_query($query);
	$numero_filas = mysql_num_rows($result);
	
	if($numero_filas==0){
			echo '<h4>No hay registros que coincidan con ' . $dni . '</h4><a class="btn btn-danger" href="conciliados.php">Volver</a>';
		}
	
	echo '<table class="table table-striped">';
	//Titulos de la tabla
	echo '<tr class="info">';
	echo '<td>ID-anterior</td>';
	echo '<td>ID-nuevo</td>';
	echo '<td>Nombre</td>';
	echo '<td>Apellido</td>';
	echo '<td>DNI</td>';
		
	echo '</tr>';
	
	
	while ($rows = mysql_fetch_array($result))
 	{
 	echo '<tr>';
	echo '<td>' . $rows['idclientes'] . '</td>';
	?>
	<td><a href="#" title="Permite ver al cliente asignado" onClick="abrirVentana('view_cliente.php?id=<?echo $rows['idclientes_asignado'];?>')"><? echo $rows['idclientes_asignado'];?></td>
	<?
 	echo '<td>' . $rows['nombre'] . '</td>';
 	echo '<td>' . $rows['apellido'] . '</td>';
 	echo '<td>' . $rows['dni'] . '</td>';
 	echo '</tr>';
 	}
 	echo '</table>';
	
 	echo $rows;
	echo '<a class="btn btn-danger" href="conciliados.php">Volver</a>';
 	}
 	else
 	{
 	echo 'Ingrese el numero de DNI para buscar<br /><br />';
 	echo '<a href="index.php">Volver</a> <br /><br />';
 	}

?>
</div><!-- cierra clase span9-->

</div><!-- cierra clase row-->

<?php
include_once("footer.php");
?>

