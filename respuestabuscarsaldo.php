
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
					Primer paso busco los clientes
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
		
		//si no hay registros que coincidan con la busqueda se informa al usuario mediante un cartel
		if($numero_filas==0){
			echo '<h4>No hay registros que coincidan con los datos ingresados</h4><a class="btn btn-danger" href="buscar.php?bandera=1">Volver</a>';
		}else{
		
		//muestra la cantidad de registros que trajo la consulta
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
	
	//muestro todos los clientes que cohinciden con el filtro aplicado
	while ($rows = mysql_fetch_array($result))
 	{
 	echo '<tr>';
 	echo '<td><input type="radio" onclick="document.form1.conciliar.disabled=false;"  value="'.$rows['idclientes'] . '" name="radio" size="1"></td>';
	echo '<td>' . $rows['dni'] . '</td>';
 	echo '<td>' . $rows['nombre'] . '</td>';
 	echo '<td>' . $rows['apellido'] . '</td>';
 	echo '<td>' . $rows['telefono'] . '</td>';
 	echo '<td>' . $rows['Direccion'] . '</td>';
 	echo '<td>' . $rows['idclientes'] . '</td>';
 	echo '</tr>';
 	}
 	echo '</table>';
	
	//fin de la tabla, mando la el id del cliente seleccionado
    echo '<input type="submit" class="btn" name="conciliar" value="conciliar"  id="conciliar" disabled>';
	echo '<input type="hidden" name="busqueda" value="'.$cliente.'">';
	echo '</form>';
	}
 	}
	
	
	
/*--------------------------------------------------------------------
----------------------------------------------------------------------
			Segundo paso Seleccion de usuarios a conciliar
----------------------------------------------------------------------
--------------------------------------------------------------------*/	


	//opcion que permite ingresar a esta segunda parte del codigo
	else if (isset($_POST['conciliar']))
	{
	$idsel=$_POST['radio'];
	$busqueda=$_POST['busqueda'];
	
	//Busco el usuario a mantener
	$query="SELECT * FROM `clientes` WHERE idclientes='".$idsel."' ";
	$cliente=mysql_query($query) or die(mysql_error());
	
	//Guardo el DNI del cliente seleccionado en una variable para usarla mas adelante
	while ($clientes = mysql_fetch_array($cliente)){
	$dni=$clientes['dni'];
	}
	
	//Busco dentro de las facturas aquellas que pertenescan al cliente
	$query="SELECT * FROM `factura` WHERE idclien='".$idsel."' AND anulada='--N--' ORDER BY idfactura ASC";
    mysql_query("SET NAMES 'utf8'");
	$result=mysql_query($query);
	
	//Titulos de la tabla
	echo "<h2>Facturas de ".$busqueda.":</h2><br><br>";
		
	//recorro el arraw de las facturas
	while ($rows = mysql_fetch_array($result))
 	{
	echo '<table class="table table-striped">';
	echo '<tr class="info">';
	echo '<td><strong>Factura</strong></td>';
	echo '<td>' . $rows['numerofactura'] . '</td>';
	echo '<td><strong>Fecha</strong></td>';
	echo '<td>' . $rows['fecha'] . '</td>';
	echo '</tr>';
	echo '</table>';
		
		//cominenzo de la tabla de detalle factura
		echo '<table class="table table-striped table-hover">';
		echo '<tr class="warning">';
		echo '<td>Concepto</td>';
		echo '<td>Monto</td>';
		echo '<td>Forma de $</td>';
		echo '</tr>';
		
		//asigno el id de la factura a un variable, y con esta consulto dentro de la tabla detalle los registros que sean de la factura
		$idfactura=$rows['idfactura'];
		
		$query="SELECT * FROM `detalle` WHERE idfactura=".$idfactura." ORDER BY iddetalle ASC";
		mysql_query("SET NAMES 'utf8'");
		$detalle=mysql_query($query);	

		//recorro el arraw de los detalles de la factura
		while ($detalles = mysql_fetch_array($detalle))
		{
			echo '<tr>';
			echo '<td>' . $detalles['nombreconcepto'] . '</td>';
			echo '<td>$ ' . $detalles['monto'] . '</td>';
			echo '<td>' . $detalles['formapago'] . '</td>';
			$subtotal=$detalles['monto']+$subtotal;
			echo '</tr>';	
		}
		echo '<tr>';
		echo '<td><strong> Suma total </strong></td>';
		echo '<td><strong>$ ' . $subtotal . '</strong></td>';
		$total=$total+$subtotal;//total acumulado de las facturas
		echo '<td>acum: $ ' . $total . ' </td>';
		$subtotal=0;//subtotal reiniciado para comenzar un nuevo bucle, con una nueva factura
		echo '</tr>';	 
		echo '</table>';
		echo '<br>';	
		}
 	
 	echo '<br>';
 	echo '<br>';
 	echo '<hr>';
	
		
	//Busco en la tabla clientes, clientes que tengan el mismo dni que el seleccionado
	$query="SELECT * FROM `clientes` where dni='".$dni."' ";
	//echo $query;
    mysql_query("SET NAMES 'utf8'");
	$result=mysql_query($query);
	$numero_filas = mysql_num_rows($result);
	
	//si me trajo registros es porque la tabla contiene registros que cohincidan con el dni, muestro cartel y envio datos para colocar en el formulario
	if($numero_filas>0){
	echo "<h4>Hay clientes con el mismo dni: <a class='btn btn-danger' href='buscar.php?bandera=1&dato=".$dni."'>Conciliarlos</a></h4>";
	}

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

