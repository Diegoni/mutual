
<?php
include_once("menu.php");
?>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Cuerpo de la pagina
----------------------------------------------------------------------
--------------------------------------------------------------------->		
<div class="span9">
		

<?php
       

	
/*--------------------------------------------------------------------
----------------------------------------------------------------------
					Primer Paso... busco los usuarios
----------------------------------------------------------------------
--------------------------------------------------------------------*/	


	if (isset($_POST['buscar']) && !isset($_POST['conciliar']))
 	{
	//asigno las variables
 	$cliente = $_POST['cliente'];
	//echo "Buscado: ".$cliente;

	$query="SELECT * FROM `clientes` where dni LIKE '%".$cliente."%' OR nombre LIKE '%".$cliente."%' OR apellido LIKE '%".$cliente."%' ORDER BY apellido ASC";   
	$result=mysql_query($query);
	mysql_query("SET NAMES 'utf8'");
	$numero_filas = mysql_num_rows($result);
		
		if($numero_filas==0){
			echo '<h4>No hay registros que coincidan con los datos ingresados</h4><a class="btn btn-danger" href="buscar.php">Volver</a>';
		}else{
		
		echo "$numero_filas Registros\n";
		echo '<br>';
        echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post" name="form1">'; //Del boton conciliar

	echo '<table class="table table-striped">';
	//Titulos de la tabla
	echo '<tr class="info">';
	echo '<td></td>';	
	echo '<td>DNI</td>';
	echo '<td>Nombre</td>';
	echo '<td>Apellido</td>';
	echo '<td>Tel</td>';
	echo '<td>Direccion</td>';
	echo '<td>ID</td>';
	
	echo '</tr>';
	while ($rows = mysql_fetch_array($result))
 	{
 	echo '<tr>';
 	//echo '<td><input type="checkbox" value="'.$rows['idclientes'] . '"name="check[]" size="1"></td>';
 	//echo '<td><input type="radio" value="'.$rows['idclientes'] . '"name="check[]" size="1"></td>';
 	echo '<td><input type="radio" onclick="document.form1.conciliar.disabled=false;"  value="'.$rows['idclientes'] . '"name="radio" size="1"></td>';
 	echo '<td>' . $rows['dni'] . '</td>';
 	echo '<td>' . $rows['nombre'] . '</td>';
 	echo '<td>' . $rows['apellido'] . '</td>';
 	echo '<td>' . $rows['telefono'] . '</td>';
 	echo '<td>' . $rows['Direccion'] . '</td>';
 	echo '<td>' . $rows['idclientes'] . '</td>';
 	echo '</tr>';
 	}
 	echo '</table>';
	//	echo $rows;
	// Boton de conciliar
        echo '<input type="submit" class="btn" name="conciliar" value="Conciliar"  id="conciliar" disabled>';
	echo '<input type="hidden" name="busqueda" value="'.$cliente.'">';
        echo '</form>';
	}
 	}
	
	
	
/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Segundo paso Seleccion de usuarios a conciliar
----------------------------------------------------------------------
--------------------------------------------------------------------*/	



	else if (isset($_POST['conciliar']))
	{
	
	$idsel=$_POST['radio'];
	$busqueda=$_POST['busqueda'];

	// Busco el usuario a mantener
	$query="SELECT * FROM `clientes` WHERE idclientes=".$idsel." ORDER BY apellido ASC";
    mysql_query("SET NAMES 'utf8'");
	$result=mysql_query($query);
	//echo $query;

	echo "<h2>Usuario a mantener:</h2><br><br>";
	echo '<table class="table table-striped">';
	//Titulos de la tabla
	echo '<tr class="info">';
	echo '<td>DNI</td>';
	echo '<td>Nombre</td>';
	echo '<td>Apellido</td>';
	echo '<td>Tel</td>';
	echo '<td>Direccion</td>';
	echo '<td>ID</td>';
	
	echo '</tr>';
	while ($rows = mysql_fetch_array($result))
 	{
	
	$dni=$rows['dni'];
 	echo '<tr>';
 	echo '<td>' . $rows['dni'] . '</td>';
 	echo '<td>' . $rows['nombre'] . '</td>';
 	echo '<td>' . $rows['apellido'] . '</td>';
 	echo '<td>' . $rows['telefono'] . '</td>';
 	echo '<td>' . $rows['Direccion'] . '</td>';
 	echo '<td>' . $rows['idclientes'] . '</td>';
 	echo '</tr>';
 	}
 	echo '</table>';
 	echo '<br>';
 	echo '<br>';
 	echo '<hr>';
	echo "<h2>Conciliar con estos usuarios:</h2><br><br>";

	// Busco el resto para poder seleccionarlo	
	$query="SELECT * FROM `clientes` where (dni LIKE '%".$busqueda."%' OR nombre LIKE '%".$busqueda."%' OR apellido LIKE '%".$busqueda."%') AND `idclientes`!=".$idsel." ORDER BY apellido ASC";
	//echo $query;
    mysql_query("SET NAMES 'utf8'");
	$result=mysql_query($query);

    echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">'; //Del boton confirmar

	echo '<table class="table table-striped">';
	//Titulos de la tabla
	echo '<tr class="info">';
	echo '<td></td>';	
	echo '<td>DNI</td>';
	echo '<td>Nombre</td>';
	echo '<td>Apellido</td>';
	echo '<td>Tel</td>';
	echo '<td>Direccion</td>';
	echo '<td>ID</td>';
	
	echo '</tr>';
	while ($resultado= mysql_fetch_array($result))
 	{
 	
	if($resultado['dni']==$dni){
	echo '<tr class="warning">';
	echo '<td><input type="checkbox" name="check[]" value="'.$resultado['idclientes'].'" checked></td>';
	echo '<td>' . $resultado['dni'] . '</td>';
 	echo '<td>' . $resultado['nombre'] . '</td>';
 	echo '<td>' . $resultado['apellido'] . '</td>';
 	echo '<td>' . $resultado['telefono'] . '</td>';
 	echo '<td>' . $resultado['Direccion'] . '</td>';
 	echo '<td>' . $resultado['idclientes'] . '</td>';
 	echo '</tr>';
	}
	else{
	echo '<tr>';
 	echo '<td><input type="checkbox" name="check[]" value="'.$resultado['idclientes'].'" ></td>';
	echo '<td>' . $resultado['dni'] . '</td>';
 	echo '<td>' . $resultado['nombre'] . '</td>';
 	echo '<td>' . $resultado['apellido'] . '</td>';
 	echo '<td>' . $resultado['telefono'] . '</td>';
 	echo '<td>' . $resultado['Direccion'] . '</td>';
 	echo '<td>' . $resultado['idclientes'] . '</td>';
 	echo '</tr>';
	}
 	
 	}
 	echo '</table>';
	
	// Boton de confirmar
	echo '<input type="hidden" name="idsel" value="'.$idsel.'">';
	echo '<input type="hidden" name="busqueda" value="'.$busqueda.'">';
    echo '<input type="submit" class="btn" name ="confirmar" value="Confirmar">';
	// Aca hacer funcion para sacar los ids de los checkboxes!!
        echo '</form>';
	
	}
	
	
	
/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Tercer paso... Confirmacion de datos
----------------------------------------------------------------------
--------------------------------------------------------------------*/	



	else if (isset($_POST['confirmar']))
	{
	
	$idsel=$_POST['idsel'];
	$busqueda=$_POST['busqueda'];


	echo "<strong>ID Seleccionado: </strong>".$idsel."<br>"; 
	echo "<strong>Busqueda: </strong>".$busqueda."<br>"; 
	echo "<h4>Los siguientes clientes han sido modificado <a href='#' class='show_hide' title='ver facturas'><i class='icon-chevron-sign-down'></i></a></h4>";
	echo "<br>";

	
	
	foreach($_POST['check'] as $valor){
		
		
		//busco las facturas con el id del cliente seleccionados
		$query="SELECT * FROM `factura` WHERE idclien='".$valor."' ";
		mysql_query("SET NAMES 'utf8'");
		$result=mysql_query($query);
		
		//-------------------------------------------------------------
		//	Cambio de tabla a clientes conciliados - 3 passos        //
		//-------------------------------------------------------------
		
		// 1 - selecciono el cliente
		$query_cliente="SELECT * FROM `clientes` WHERE idclientes='".$valor."' ";
		mysql_query("SET NAMES 'utf8'");
		$cliente=mysql_query($query_cliente) or die(mysql_error());
		$row_cliente = mysql_fetch_assoc($cliente);
		
		echo '<table class="table table-striped">';
		echo '<tr class="info">';
		echo '<td>ID</td>';	
		echo '<td>Apellido</td>';	
		echo '<td>Nombre</td>';
		echo '<td>Telefono</td>';
		echo '</tr>';
		
		echo '<tr>';
		echo '<td>' . $row_cliente['idclientes'] . '</td>';
		echo '<td>' . $row_cliente['apellido'] . '</td>';
		echo '<td>' . $row_cliente['nombre'] . '</td>';
		echo '<td>' . $row_cliente['telefono'] . '</td>';
		echo '</tr>';
		echo "</table>";
	

		// 2 - pasa el cliente a la tabla de log_clientes_conciliados
		mysql_query("INSERT INTO `log_clientes_conciliados` (
				idclientes,
				idclientes_asignado,
				nombre,
				apellido,
				telefono,
				direccion,
				dni,
				email,
				grupofamiliar,
				idbarrio)
			VALUES (
				'".$row_cliente['idclientes']."',
				'".$idsel."',
				'".$row_cliente['nombre']."',
				'".$row_cliente['apellido']."',
				'".$row_cliente['telefono']."',
				'".$row_cliente['Direccion']."',
				'".$row_cliente['dni']."',
				'".$row_cliente['email']."',
				'".$row_cliente['grupofamiliar']."',
				'".$row_cliente['idbarrio']."')	
			") or die(mysql_error());
			
		// 3 - elimino el cliente de la tabla clientes			
		/*mysql_query("DELETE FROM `clientes` WHERE idclientes='".$valor."' ") or die(mysql_error());*/
		
		echo "<div class='slidingDiv'>";
		echo '<table>';
		echo '<tr>';
		echo '<td bgcolor="#fcf8e3">';
		echo "Facturas: ";
		echo '</td>';
		
		echo '<td colspan="3">';
		while ($resultado= mysql_fetch_array($result)){
			echo " - ";
			echo $resultado['idfactura'];
			//esta consulta	cambia el id del cliente en la factura
			mysql_query("UPDATE `factura` SET idclien='".$idsel."' WHERE idfactura='".$resultado['idfactura']."' ") or die(mysql_error());
		}
		echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo "</div>";

	}//cierra el foreach
	
	
	}
 	else
 	{
	// Boton de busqueda
	?>
	
 	
	<form class="form-horizontal" action="<?=$_SERVER['PHP_SELF']?>" method="post">
	<div class="control-group">
		<label class="control-label" for="inputEmail">Datos</label>
		<div class="controls">
			<input type="text" name="cliente" class="span4" placeholder="Ingrese datos">
		</div>
	</div>
	
	<div class="control-group">
		<div class="controls">
		<input type="submit" class="btn" name ="buscar" value="Buscar">
		</div>
	</div>
 	</form>
 	<a href="index.php">Volver</a>
	<? 	} ?>

	</div><!-- cierra clase span9-->
	</div><!-- cierra clase row-->
	
	
<?php
include_once("footer.php");
?>

