
<?php
include_once("menu.php");
?>

<?php      


	// Hago la busqueda

 	//if (isset($_POST['buscar']))
 	if ($_POST['dninput'])
 	{
	//asigno las variables
 	$dni = $_POST['dninput'];
	echo $dni;

 	//$nombre=$_POST['nombre'];

	$query="SELECT * FROM `clientes` where dni=".$dni." ORDER BY apellido ASC";
        $result=mysql_query($query);

	while ($rows = mysql_fetch_array($result))

 	{
 	echo '<tr>';
 	echo '<td><input type="checkbox" value="' . $rows['nombre'] . '" name="RFQ[]"></td>';
 	echo '<td>' . $rows['nombre'] . '</td>';
 	echo '<td>' . $rows['apellido'] . '</td>';
 	echo '<td>' . $rows['dni'] . '</td>';
 	echo '</tr>';
 	}
 	echo '</table>';
 	echo $rows;

 	}
 	else
 	{
 	echo 'Ingrese el numero de DNI para buscar<br /><br />';
 	echo '<a href="index.php">Volver</a> <br /><br />';
 	}

?>


<?php
include_once("footer.php");
?>

