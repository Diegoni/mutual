<html>
<head>
<? include_once("config/database.php"); ?>
<!--BEGIN META TAGS-->
<META NAME="keywords" CONTENT="">
<META NAME="description" CONTENT="Conciliador de BD Mutual San Cayetano by TMS Group">
<META NAME="rating" CONTENT="General">
<META NAME="ROBOTS" CONTENT="ALL">
<!--END META TAGS-->

<!-- Charset tiene que estar en utf-8 para que tome ñ y acentos -->
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title>Conciliador BD Mutual San Cayetano</title>

<link rel="stylesheet" type="text/css" href="css/main.css" media="screen" />
<script src="js/main.js"></script>
<script src="bootstrap/js/jquery.js"></script>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
							JQuery UI
----------------------------------------------------------------------
--------------------------------------------------------------------->

<link rel="stylesheet" href="ui/jquery-ui.css" />
<script src="ui/jquery-ui.js"></script>

<? 
		$query="SELECT * FROM `clientes` GROUP BY apellido ASC";
		mysql_query("SET NAMES 'utf8'");
		$result=mysql_query($query);
		
	?>
	
<!--------------------------------------------------------------------
----------------------------------------------------------------------
					Autocomplete usando jquery ui
----------------------------------------------------------------------
--------------------------------------------------------------------->	

<script>

  $(function() {
		var availableTags = new Array();
		var i=0;
		
	"<? do {?> "
		availableTags[i] = "<? echo $resultado['apellido']; ?>";
		i =i+1
		"<? } while ($resultado= mysql_fetch_array($result));?>"
    
    $( "#tags" ).autocomplete({
      source: availableTags
    });
  });
</script>


<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Bootstrap
----------------------------------------------------------------------
--------------------------------------------------------------------->

<link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet" media="screen">
<link href="font/css/font-awesome.css" rel="stylesheet">

<script src="bootstrap/js/bootstrap.js"></script>

<!------------------------------------------------------------------->
<script>
function control(){
		var cliente = buscar.cliente.value;
			if (cliente.length < 3){
			alert('Debes escribir por lo menos 3 caracteres')
			buscar.cliente.focus()
			return false 
			}

		}
</script>

<script type="text/javascript">
 
$(document).ready(function(){
 
        $(".slidingDiv").hide();
        $(".show_hide").show();
 
    $('.show_hide').click(function(){
    $(".slidingDiv").slideToggle();
    });
 
});
 
</script>





</head>
<center>
<body>

<div class="container">

<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Cabecera
----------------------------------------------------------------------
--------------------------------------------------------------------->

		<div class="cabecera">
		<div class="row">
			<div class="span9">
				<p>Sistema Conciliador Usuarios Mutual</p>
			</div>
			<div class="span2">
				<a href="http://www.tmsgroup.com.ar/" target="_blank"><img class="imagenlogo"src="imagenes/logo.png"></a>
			</div>
		</div>
		</div>
		

<!--------------------------------------------------------------------
----------------------------------------------------------------------
							Menu principal
----------------------------------------------------------------------
--------------------------------------------------------------------->		
		
		<div class="row">	
		<div class="span3; menu">
			<ul class="nav nav-pills nav-stacked">
				<li><a  class="opciones" href="buscar.php"><i class="icon-search"></i> Buscar y Conciliar</a></li>
				<li><a  class="opciones" href="conciliados.php" ><i class="icon-list"></i> Listar Conciliados</a></li>
				<li><a  class="opciones" href="" ><i class="icon-archive"></i> Saldo clientes</a></li>
			</ul>
			
<!--
            <a href="buscardni.php"><img src="imagenes/boton.jpg" width="180" height="40" border="0"></a><br>
			<div style="margin-top:-30px;margin-bottom:13px;width:180px;text-align:center">
			<a style="color: white;text-decoration:none" href="buscardni.php">Buscar por DNI</a></div>


            <a href="buscarnombre.php"><img src="imagenes/boton.jpg" width="180" height="40" border="0"></a><br>
			<div style="margin-top:-30px;margin-bottom:13px;width:180px;text-align:center">
			<a style="color: white;text-decoration:none" href="buscarnombre.php">Buscar por Nombre</a></div>

            <a href="buscarapellido.php"><img src="imagenes/boton.jpg" width="180" height="40" border="0"></a><br>
			<div style="margin-top:-30px;margin-bottom:13px;width:180px;text-align:center">
			<a style="color: white;text-decoration:none" href="buscarapellido.php">Buscar por Apellido</a></div>
-->           
          
        </div>
	
			
		
