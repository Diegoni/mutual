/***********************************************************************
Autor: Alejandro Weber
Fecha: 27/07/2013
Proyecto: Mutual
Empresa: TMS Group SA.
Vamos a crear un StoreProcedure para migrar las bases de datos a una sola
************************************************************************/
DELIMITER //
DROP PROCEDURE IF EXISTS sp_MigracionDDBB // 
CREATE PROCEDURE sp_MigracionDDBB ()

-- Acordarse de pasar el barrio que falta antes de hacer el traspaso de clientes

BEGIN
-- End loop flag
DECLARE Terminado INT DEFAULT 0;

-- Para clientes
DECLARE nombrecliente VARCHAR(45);
DECLARE apellidocliente VARCHAR(45);
DECLARE telefonocliente VARCHAR(45);
DECLARE Direccioncliente VARCHAR(200);
DECLARE dnicliente VARCHAR(45);
DECLARE emailcliente VARCHAR(45);
DECLARE grupofamiliarcliente VARCHAR(500);
DECLARE idbarriocliente INT;
DECLARE IdClienteNEW INT;
DECLARE IdClienteOLD INT;

-- Para facturas
DECLARE IDFACTURA INT;
DECLARE FECHA VARCHAR (45);
DECLARE NUMEROFACTURA INT;
DECLARE IDCLIEN INT;
DECLARE ANULADA VARCHAR (45);
DECLARE IDUSUARIO INT;
DECLARE ClienteNuevo INT;

-- Para detalle
DECLARE IDDETALLE INT;
DECLARE FORMAPAGO VARCHAR (45);
DECLARE MONTO VARCHAR (45);
DECLARE NOMBRECONCEPTO VARCHAR(200);
DECLARE IDFACTURANUEVA INT;

DECLARE ImportarDetalle CURSOR FOR
SELECT 		d.iddetalle,
			d.formapago,
			d.monto,
			d.nombreconcepto,
			d.idfactura
FROM barrios.detalle d;

DECLARE ImportarFacturas CURSOR FOR
SELECT		c.idfactura,
			c.fecha,
			c.numerofactura,
			c.idclien,
			c.anulada,
			c.idusuario
FROM barrios.factura c;

-- Empezamos con los clientes
DECLARE ImportarClientes CURSOR FOR
SELECT		b.idclientes,
			b.nombre,
			b.apellido,
			b.telefono,
			b.Direccion,
			b.dni,
			b.email,
			b.grupofamiliar,
			b.idbarrio
FROM barrios.clientes b;

	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET Terminado = 1; -- Salimos del loop cuando no encuentre nada

Open ImportarClientes;

SET IdClienteOLD = NULL;
SET nombrecliente= NULL;
SET apellidocliente=NULL;
SET telefonocliente = NULL;
SET Direccioncliente = NULL;
SET dnicliente = NULL;
SET emailcliente = NULL;
SET grupofamiliarcliente = NULL;
SET idbarriocliente = NULL;


USE barrios1;
CREATE TABLE ClientesImportados (
	IdClienteViejo INT NOT NULL,
	IdClienteNuevo INT);

read_loop: LOOP
	FETCH FROM ImportarClientes 
		INTO 	IdClienteOLD,
				nombrecliente, 
				apellidocliente, 
				telefonocliente, 
				Direccioncliente,
				dnicliente,
				emailcliente,
				grupofamiliarcliente,
				idbarriocliente;

-- Inserto el cliente
INSERT INTO barrios1.clientes (nombre,apellido,telefono,Direccion,dni,email,grupofamiliar,idbarrio)
	VALUES (nombrecliente,
			apellidocliente,
			telefonocliente,
			Direccioncliente,
			dnicliente,
			emailcliente,
			grupofamiliarcliente,
			idbarriocliente);
INSERT INTO ClientesImportados (IdClienteViejo,IdClienteNuevo)
	VALUES (IdClienteOLD,LAST_INSERT_ID());

	IF  Terminado THEN LEAVE read_loop; END IF;
END LOOP;

CLOSE ImportarClientes;

SET Terminado = 0;

Open ImportarFacturas;

-- Los usuarios son los mismos, no hace falta importarlos.

SET IDFACTURA = 0 ;
SET FECHA = NULL;
SET NUMEROFACTURA = 0;
SET IDCLIEN =0;
SET ANULADA = NULL;
SET IDUSUARIO = 0;
SET ClienteNuevo = 0;

USE barrios1;
CREATE TABLE ClientesImportados (
	IdClienteNuevo INT NOT NULL,
	IdClienteViejo INT);

read_loop: LOOP
	FETCH FROM ImportarFacturas 
		INTO 	IDFACTURA,
				FECHA, 
				NUMEROFACTURA, 
				IDCLIEN, 
				ANULADA,
				IDUSUARIO;
SET ClienteNuevo = (SELECT IdClienteNuevo FROM barrios1.ClientesImportados WHERE IdClienteViejo = IDCLIEN);

-- Importamos las que NO existen
IF NOT EXISTS (SELECT * FROM barrios1.factura WHERE barrios1.factura.numerofacutra = NUMEROFACTURA)
	THEN
		INSERT INTO barrios1.factura
			(fecha,
			numerofactura,
			idclien,
			anulada,
			idusuario)
		VALUES
			(FECHA,
			NUMEROFACTURA,
			ClienteNuevo,
			ANULADA,
			IDUSUARIO);
	INSERT INTO FacturasImportadas (IdFacturaViejo,IdFacturaNuevo)
	VALUES (IDFACTURA,LAST_INSERT_ID());
	
	END IF;

	IF  Terminado THEN LEAVE read_loop; END IF;
END LOOP;

CLOSE ImportarFacturas;

SET Terminado = 0;

Open ImportarDetalle;

SET IDDETALLE = NULL;
SET FORMAPAGO = NULL;
SET MONTO = NULL;
SET NOMBRECONCEPTO = NULL;
SET IDFACTURA = NULL;
SET IDFACTURANUEVA = NULL;

USE barrios1;
CREATE TABLE FacturasImportadas (
	IdFacturaViejo INT NOT NULL,
	IdFacturaNuevo INT);

read_loop: LOOP
	FETCH FROM ImportarDetalle 
		INTO 	IDDETALLE,
				FORMAPAGO, 
				MONTO, 
				NOMBRECONCEPTO, 
				IDFACTURA;
SET IDFACTURANUEVA = (SELECT IdFacturaNuevo FROM barrios1.FacturasImportadas WHERE IdFacturaViejo = IDFACTURA);

INSERT INTO barrios1.detalle
		(formapago,
		monto,
		nombreconcepto,
		idfactura)
		VALUES (
		FORMAPAGO,
		MONTO,
		NOMBRECONCEPTO,
		IDFACTURANUEVA);

	IF  Terminado THEN LEAVE read_loop; END IF;
END LOOP;

CLOSE ImportarDetalle;
 END //
DELIMITER ;




