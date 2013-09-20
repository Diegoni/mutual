/***********************************************************************
Autor: Alejandro Weber
Fecha: 27/07/2013
Proyecto: Mutual
Empresa: TMS Group SA.
Vamos a crear un StoreProcedure para migrar las bases de datos a una sola
Corre sin problemas
************************************************************************/
USE barrios1;

DELIMITER //

DROP PROCEDURE IF EXISTS sp_MigracionDDBBOtrosPagos // 
CREATE PROCEDURE sp_MigracionDDBBOtrosPagos ()

-- Acordarse de pasar el barrio que falta antes de hacer el traspaso de clientes


/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
							DECLARACION DE VARIABLES
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/

BEGIN
-- End loop flag
DECLARE Terminado INT DEFAULT 0;

-- Para otrospagos
DECLARE IDOTROSPAGOS INT;
DECLARE TIPO VARCHAR (45);
DECLARE MONTO VARCHAR (45);
DECLARE FECHA VARCHAR (45);
DECLARE IDCLIEN INT;
DECLARE FORMAPAGO VARCHAR (50);
DECLARE NROCHEQUE VARCHAR (50);
DECLARE BANCO VARCHAR (50);
DECLARE TITULAR VARCHAR (100);
DECLARE FECHAVENC VARCHAR (100);
DECLARE NROCUOTA VARCHAR (10);
DECLARE MESCOBRO VARCHAR (45);
DECLARE ClienteNuevo INT;
DECLARE IdOtrosPagosNEW INT;
DECLARE IdOtrosPagosOLD INT;

-- OtrosPagos
DECLARE ImportarOtrosPagos CURSOR FOR
SELECT		c.idotrospagos,
			c.tipo,
			c.monto,
			c.fecha,
			c.idcliente,
			c.formapago,
			c.nrocheque,
			c.banco,
			c.titular,
			c.fechavenc,
			c.nrocuota,
			c.mescobro
FROM barrios.otrospagos c;
	DECLARE CONTINUE HANDLER 
	FOR NOT FOUND SET Terminado = 1; -- Salimos del loop cuando no encuentre nada

Open ImportarOtrosPagos;

SET IDOTROSPAGOS = 0 ;
SET TIPO = NULL;
SET MONTO = NULL;
SET FECHA = NULL;
SET IDCLIEN =0;
SET FORMAPAGO = NULL;
SET NROCHEQUE = NULL;
SET BANCO = NULL;
SET TITULAR = NULL;
SET FECHAVENC = NULL;
SET NROCUOTA = NULL;
SET MESCOBRO = NULL;
SET ClienteNuevo = 0;


/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
										LOOP
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/

read_loop: LOOP
	FETCH FROM 	ImportarOtrosPagos 
		INTO 	IDOTROSPAGOS,
				TIPO,
				MONTO,
				FECHA, 
				IDCLIEN, 
				FORMAPAGO,
				NROCHEQUE,
				BANCO,
				TITULAR,
				FECHAVENC,
				NROCUOTA,
				MESCOBRO;

SET ClienteNuevo = (SELECT IdClienteNuevo FROM barrios1.ClientesImportados WHERE IdClienteViejo = IDCLIEN);

INSERT 	INTO barrios1.otrospagos (
			tipo,
			monto,
			fecha,
			idcliente,
			formapago,
			nrocheque,
			banco,
			titular,
			fechavenc,
			nrocuota,
			mescobro)
		VALUES (
			TIPO,
			MONTO,
			FECHA, 
			ClienteNuevo, 
			FORMAPAGO,
			NROCHEQUE,
			BANCO,
			TITULAR,
			FECHAVENC,
			NROCUOTA,
			MESCOBRO);
		IF  Terminado THEN LEAVE read_loop; END IF;

END LOOP;






CLOSE ImportarOtrosPagos;

 END //
DELIMITER ;
