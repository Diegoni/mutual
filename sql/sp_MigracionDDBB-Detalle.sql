
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

DROP PROCEDURE IF EXISTS sp_MigracionDDBBDetalle // 
CREATE PROCEDURE sp_MigracionDDBBDetalle ()

-- Acordarse de pasar el barrio que falta antes de hacer el traspaso de clientes


/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
							DECLARACION DE VARIABLES
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/

BEGIN
-- End loop flag
DECLARE Terminado INT DEFAULT 0;

-- Para detalle
DECLARE IDDETALLE INT;
DECLARE FORMAPAGO VARCHAR (45);
DECLARE MONTO VARCHAR (45);
DECLARE NOMBRECONCEPTO VARCHAR(200);
DECLARE IDFACTURA INT;
DECLARE IDFACTURANUEVA INT;

-- Detalles
DECLARE ImportarDetalle CURSOR FOR
SELECT 		d.iddetalle,
			d.formapago,
			d.monto,
			d.nombreconcepto,
			d.idfactura
FROM barrios.detalle d;
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET Terminado = 1; -- Salimos del loop cuando no encuentre nada

Open ImportarDetalle;

SET IDDETALLE = NULL;
SET FORMAPAGO = NULL;
SET MONTO = NULL;
SET NOMBRECONCEPTO = NULL;
SET IDFACTURA = NULL;
SET IDFACTURANUEVA = NULL;

/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
										LOOP
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/


read_loop: LOOP
	FETCH FROM 	ImportarDetalle
		INTO 	IDDETALLE,
				FORMAPAGO, 
				MONTO, 
				NOMBRECONCEPTO, 
				IDFACTURA;

SET IDFACTURANUEVA = (SELECT IdFacturaNuevo FROM barrios1.FacturasImportadas WHERE IdFacturaViejo = IDFACTURA);

INSERT INTO barrios1.detalle(
			formapago,
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
