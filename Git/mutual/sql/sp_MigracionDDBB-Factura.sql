/***********************************************************************
Autor: Alejandro Weber
Fecha: 27/07/2013
Proyecto: Mutual
Empresa: TMS Group SA.
Vamos a crear un StoreProcedure para migrar las bases de datos a una sola
Corre sin errores
************************************************************************/
USE barrios1;

DELIMITER //

DROP PROCEDURE IF EXISTS sp_MigracionDDBBFactura // 
CREATE PROCEDURE sp_MigracionDDBBFactura ()

-- Acordarse de pasar el barrio que falta antes de hacer el traspaso de clientes


/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
							DECLARACION DE VARIABLES
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/

BEGIN
-- End loop flag
DECLARE Terminado INT DEFAULT 0;



-- Para facturas
DECLARE IDFACTURA INT;
DECLARE FECHA VARCHAR (45);
DECLARE NUMEROFACTURA INT;
DECLARE IDCLIEN INT;
DECLARE ANULADA VARCHAR (45);
DECLARE IDUSUARIO INT;
DECLARE ClienteNuevo INT;
DECLARE IdFacturaNEW INT;
DECLARE IdFacturaOLD INT;

-- Facturas
DECLARE ImportarFacturas CURSOR FOR
SELECT		c.idfactura,
			c.fecha,
			c.numerofactura,
			c.idclien,
			c.anulada,
			c.idusuario
FROM barrios.factura c;
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET Terminado = 1; -- Salimos del loop cuando no encuentre nada

Open ImportarFacturas;

SET IDFACTURA = 0 ;
SET FECHA = NULL;
SET NUMEROFACTURA = 0;
SET IDCLIEN =0;
SET ANULADA = NULL;
SET IDUSUARIO = 0;
SET ClienteNuevo = 0;
SET IdFacturaOLD = 0;


CREATE TABLE FacturasImportadas (
	IdFacturaViejo INT NOT NULL,
	IdFacturaNuevo INT);
	
/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
										LOOP
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/	


read_loop: LOOP
	FETCH FROM 	ImportarFacturas 
		INTO 	IDFACTURA,
				FECHA, 
				NUMEROFACTURA, 
				IDCLIEN, 
				ANULADA,
				IDUSUARIO;

SET ClienteNuevo = (SELECT IdClienteNuevo FROM barrios1.ClientesImportados WHERE IdClienteViejo = IDCLIEN);

INSERT INTO barrios1.factura (
			fecha,
			numerofactura,
			idclien,
			anulada,
			idusuario,
			idseries)
	VALUES (
			FECHA,
			NUMEROFACTURA,
			ClienteNuevo,
			ANULADA,
			IDUSUARIO,
			2);

INSERT INTO barrios1.FacturasImportadas (
			IdFacturaViejo,
			IdFacturaNuevo)
	VALUES (
			IDFACTURA,
			LAST_INSERT_ID());/*Devuelve el último valor generado automáticamente que fue insertado en una columna AUTO_INCREMENT.*/

	IF  Terminado THEN LEAVE read_loop; END IF;

END LOOP;

CLOSE ImportarFacturas;

 END //
DELIMITER ;
