
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
    echo '<input type="submit" class="btn" name="c" value="conciliar"  id="conciliar" disabled>';
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


	

 	} ?>

	</div><!-- cierra clase span9-->
	</div><!-- cierra clase row-->
	
	
<?php
include_once("footer.php");
?>

