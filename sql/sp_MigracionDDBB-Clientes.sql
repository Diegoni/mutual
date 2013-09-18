/***********************************************************************
Autor: Alejandro Weber
Fecha: 27/07/2013
Proyecto: Mutual
Empresa: TMS Group SA.
Vamos a crear un StoreProcedure para migrar las bases de datos a una sola
Corre sin errores
************************************************************************/
DELIMITER //
DROP PROCEDURE IF EXISTS sp_MigracionDDBBClientes // 
CREATE PROCEDURE sp_MigracionDDBBClientes ()

-- Acordarse de pasar el barrio que falta antes de hacer el traspaso de clientes


/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
							DECLARACION DE VARIABLES
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/

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
SET nombrecliente = NULL;
SET apellidocliente = NULL;
SET telefonocliente = NULL;
SET Direccioncliente = NULL;
SET dnicliente = NULL;
SET emailcliente = NULL;
SET grupofamiliarcliente = NULL;
SET idbarriocliente = NULL;


/*USE barrios1; esta linea daba error al ejecutarlo*/
CREATE TABLE ClientesImportados (
	IdClienteViejo INT NOT NULL,
	IdClienteNuevo INT);
	
/*-------------------------------------------------------------------------------------
---------------------------------------------------------------------------------------
										LOOP
---------------------------------------------------------------------------------------										
-------------------------------------------------------------------------------------*/	

read_loop: LOOP
	FETCH FROM 	ImportarClientes 
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
INSERT INTO barrios1.clientes (
			nombre,
			apellido,
			telefono,
			Direccion,
			dni,
			email,
			grupofamiliar,
			idbarrio)
	VALUES (
			nombrecliente,
			apellidocliente,
			telefonocliente,
			Direccioncliente,
			dnicliente,
			emailcliente,
			grupofamiliarcliente,
			idbarriocliente);
			
INSERT INTO barrios1.ClientesImportados (IdClienteViejo,IdClienteNuevo)
	VALUES (IdClienteOLD,
			LAST_INSERT_ID());/*Devuelve el último valor generado automáticamente que fue insertado en una columna AUTO_INCREMENT.*/
	IF  Terminado THEN LEAVE read_loop; END IF;
	
END LOOP;




CLOSE ImportarClientes;

 END //
DELIMITER ;
