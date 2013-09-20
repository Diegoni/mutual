/*
	// Busco el usuario a mantener
	$query="SELECT * FROM `clientes` WHERE idclientes=".$idsel." ORDER BY apellido ASC";
        $result=mysql_query($query);
	//echo $query;

	echo "<h1>UD ESTA SEGURO DE CONCILIAR LOS DATOS?!!!</h1><br><br>";
	echo "<h2>Usuario a mantener:</h2><br><br>";
	echo '<table width="700" align="center" border="0">';
	//Titulos de la tabla
	echo '<tr>';
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
        $result=mysql_query($query);

        echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">'; //Del boton OK

	echo '<table width="700" align="center" border="0">';
	//Titulos de la tabla
	echo '<tr>';
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
 	echo '<td>' . $rows['dni'] . '</td>';
 	echo '<td>' . $rows['nombre'] . '</td>';
 	echo '<td>' . $rows['apellido'] . '</td>';
 	echo '<td>' . $rows['telefono'] . '</td>';
 	echo '<td>' . $rows['Direccion'] . '</td>';
 	echo '<td>' . $rows['idclientes'] . '</td>';
 	echo '</tr>';
 	}
 	echo '</table>';
	
	// Boton OK
 	echo '</br>';
 	echo '</br>';	
        echo '<input type="submit" name ="ok" value="ESTOY SEGURO">';
        echo '</form>';
*/	