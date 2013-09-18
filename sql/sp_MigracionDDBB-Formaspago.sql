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

DROP PROCEDURE IF EXISTS sp_MigracionDDBBFormaspago // 
CREATE PROCEDURE sp_MigracionDDBBFormaspago ()

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
DECLARE IDFORMASPAGO INT;
DECLARE NOMBRE VARCHAR (45);
DECLARE MONTO DOUBLE;
DECLARE NUMEROCHEQUE VARCHAR (45);
DECLARE BANCO VARCHAR (45);
DECLARE TITULAR VARCHAR (45);
DECLARE FECHAVENCIMIENTO DATE;
DECLARE IDADJUDICACION INT;


-- Facturas
DECLARE ImportarFormaspago CURSOR FOR
SELECT		c.idformaspago,
			c.nombre,
			c.monto,
			c.numerocheque,
			c.banco,
			c.titular,
			c.fechavencimiento,
			c.idadjudicacion
FROM barrios.formaspago c;
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET Terminado = 1; -- Salimos del loop cuando no encuentre nada

Open ImportarFormaspago;

SET IDFORMASPAGO = NULL;
SET NOMBRE = NULL;
SET MONTO = NULL;
SET NUMEROCHEQUE = NULL;
SET BANCO = NULL;
SET TITULAR = NULL;
SET FECHAVENCIMIENTO = NULL;
SET IDADJUDICACION = NULL;


	
/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
										LOOP
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/	

read_loop: LOOP
	FETCH FROM 	ImportarFormaspago 
		INTO 	IDFORMASPAGO,
				NOMBRE, 
				MONTO, 
				NUMEROCHEQUE, 
				BANCO,
				TITULAR,
				FECHAVENCIMIENTO,
				IDADJUDICACION;

-- Inserto formaspago
INSERT INTO barrios1.formaspago (
			idformaspago,
			nombre,
			monto,
			numerocheque,
			banco,
			titular,
			fechavencimiento,
			idadjudicacion)
	VALUES (
			IDFORMASPAGO,
			NOMBRE,
			MONTO,
			NUMEROCHEQUE,
			BANCO,
			TITULAR,
			FECHAVENCIMIENTO,
			IDADJUDICACION);
				
END LOOP;




CLOSE ImportarFormaspago;

 END //
DELIMITER ;
