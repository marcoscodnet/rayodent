INSERT INTO funcion (ds_funcion) VALUES ( 'Alta Empleado');
INSERT INTO funcion (ds_funcion) VALUES ( 'Eliminar Empleado');
INSERT INTO funcion (ds_funcion) VALUES ( 'Ver Empleado');
INSERT INTO funcion (ds_funcion) VALUES ( 'Modificar Empleado');
INSERT INTO funcion (ds_funcion) VALUES ( 'Listar Empleado');
INSERT INTO funcion (ds_funcion) VALUES ( 'Alta Profesional');
INSERT INTO funcion (ds_funcion) VALUES ( 'Eliminar Profesional');
INSERT INTO funcion (ds_funcion) VALUES ( 'Ver Profesional');
INSERT INTO funcion (ds_funcion) VALUES ( 'Modificar Profesional');
INSERT INTO funcion (ds_funcion) VALUES ( 'Listar Profesional');
INSERT INTO funcion (ds_funcion) VALUES ( 'Alta Medio');
INSERT INTO funcion (ds_funcion) VALUES ( 'Eliminar TipoDocumento');
INSERT INTO funcion (ds_funcion) VALUES ( 'Ver TipoDocumento');
INSERT INTO funcion (ds_funcion) VALUES ( 'Modificar TipoDocumento');
INSERT INTO funcion (ds_funcion) VALUES ( 'Listar TipoDocumento');
INSERT INTO funcion (ds_funcion) VALUES ( 'Alta TipoPersonal');
INSERT INTO funcion (ds_funcion) VALUES ( 'Eliminar TipoPersonal');
INSERT INTO funcion (ds_funcion) VALUES ( 'Ver TipoPersonal');
INSERT INTO funcion (ds_funcion) VALUES ( 'Modificar TipoPersonal');
INSERT INTO funcion (ds_funcion) VALUES ( 'Listar TipoPersonal');

INSERT INTO menugroup VALUES (10, 10, 65, 'Builder', 'panel_control&menuGroupActivo=10', 'builder');

INSERT INTO menuoption (nombre, href, cd_funcion, orden, cd_menugroup, cssclass) VALUES ('Empleados', 'doAction?action=listar_empleados', , 5, 10, 'empleados');
INSERT INTO menuoption (nombre, href, cd_funcion, orden, cd_menugroup, cssclass) VALUES ('Profesionales', 'doAction?action=listar_profesionales', , 5, 10, 'profesionales');
INSERT INTO menuoption (nombre, href, cd_funcion, orden, cd_menugroup, cssclass) VALUES ('TipoDocumentos', 'doAction?action=listar_tipodocumentos', , 5, 10, 'tipodocumentos');
INSERT INTO menuoption (nombre, href, cd_funcion, orden, cd_menugroup, cssclass) VALUES ('TipoPersonales', 'doAction?action=listar_tipopersonales', , 5, 10, 'tipopersonales');

######################## Eliminar profesionales ################################
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1040;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1056;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1608;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1733;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1801;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1804;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1929;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 2010;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 2105;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 2127;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 539 WHERE ordenpractica.cd_profesional = 1616;


DELETE FROM profesional WHERE cd_profesional = 1040;
DELETE FROM profesional WHERE cd_profesional = 1056;
DELETE FROM profesional WHERE cd_profesional = 1608;
DELETE FROM profesional WHERE cd_profesional = 1733;
DELETE FROM profesional WHERE cd_profesional = 1801;
DELETE FROM profesional WHERE cd_profesional = 1804;
DELETE FROM profesional WHERE cd_profesional = 1929;
DELETE FROM profesional WHERE cd_profesional = 2010;
DELETE FROM profesional WHERE cd_profesional = 2105;
DELETE FROM profesional WHERE cd_profesional = 2127;
DELETE FROM profesional WHERE cd_profesional = 1616;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 246 WHERE ordenpractica.cd_profesional = 316;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 246 WHERE ordenpractica.cd_profesional = 1549;

DELETE FROM profesional WHERE cd_profesional =316;
DELETE FROM profesional WHERE cd_profesional =1549;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 931 WHERE ordenpractica.cd_profesional = 1215;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 931 WHERE ordenpractica.cd_profesional = 1748;

DELETE FROM profesional WHERE cd_profesional =1215;
DELETE FROM profesional WHERE cd_profesional =1748;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 2099 WHERE ordenpractica.cd_profesional = 1583;

DELETE FROM profesional WHERE cd_profesional =1583;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 619 WHERE ordenpractica.cd_profesional = 1159;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 619 WHERE ordenpractica.cd_profesional = 1334;

DELETE FROM profesional WHERE cd_profesional =1159;
DELETE FROM profesional WHERE cd_profesional =1334;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 418 WHERE ordenpractica.cd_profesional = 1315;

DELETE FROM profesional WHERE cd_profesional =1315;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 284 WHERE ordenpractica.cd_profesional = 2017;

DELETE FROM profesional WHERE cd_profesional =2017;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 986 WHERE ordenpractica.cd_profesional = 995;

DELETE FROM profesional WHERE cd_profesional =995;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 755 WHERE ordenpractica.cd_profesional = 1888;

DELETE FROM profesional WHERE cd_profesional =1888;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 111 WHERE ordenpractica.cd_profesional = 403;

DELETE FROM profesional WHERE cd_profesional =403;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 597 WHERE ordenpractica.cd_profesional = 2371;

DELETE FROM profesional WHERE cd_profesional =2371;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 1051 WHERE ordenpractica.cd_profesional = 1821;

DELETE FROM profesional WHERE cd_profesional =1821;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 582 WHERE ordenpractica.cd_profesional = 996;

DELETE FROM profesional WHERE cd_profesional =996;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 1891 WHERE ordenpractica.cd_profesional = 1873;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 1891 WHERE ordenpractica.cd_profesional = 965;

DELETE FROM profesional WHERE cd_profesional =1873;
DELETE FROM profesional WHERE cd_profesional =965;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 485 WHERE ordenpractica.cd_profesional = 939;
UPDATE ordenpractica SET ordenpractica.cd_profesional = 485 WHERE ordenpractica.cd_profesional = 1228;

DELETE FROM profesional WHERE cd_profesional =939;
DELETE FROM profesional WHERE cd_profesional =1228;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 1790 WHERE ordenpractica.cd_profesional = 2290;

DELETE FROM profesional WHERE cd_profesional =2290;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 307 WHERE ordenpractica.cd_profesional = 1094;

DELETE FROM profesional WHERE cd_profesional =1094;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 36 WHERE ordenpractica.cd_profesional = 682;

DELETE FROM profesional WHERE cd_profesional =682;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 95 WHERE ordenpractica.cd_profesional = 1331;

DELETE FROM profesional WHERE cd_profesional =1331;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 346 WHERE ordenpractica.cd_profesional = 2330;

DELETE FROM profesional WHERE cd_profesional =2330;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 170 WHERE ordenpractica.cd_profesional = 271;

DELETE FROM profesional WHERE cd_profesional =271;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 182 WHERE ordenpractica.cd_profesional = 977;

DELETE FROM profesional WHERE cd_profesional =977;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 13 WHERE ordenpractica.cd_profesional = 383;

DELETE FROM profesional WHERE cd_profesional =383;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 32 WHERE ordenpractica.cd_profesional = 1926;

DELETE FROM profesional WHERE cd_profesional =1926;

UPDATE ordenpractica SET ordenpractica.cd_profesional = 802 WHERE ordenpractica.cd_profesional = 1271;

DELETE FROM profesional WHERE cd_profesional =1271;

######################################18/05/2021##########################################

CREATE TABLE `medio` (
	`cd_medio` INT(11) NOT NULL AUTO_INCREMENT,
	`ds_medio` VARCHAR(50) NOT NULL,
	PRIMARY KEY (`cd_medio`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;



INSERT INTO funcion (ds_funcion) VALUES ( 'Alta Medio');
INSERT INTO funcion (ds_funcion) VALUES ( 'Eliminar Medio');
INSERT INTO funcion (ds_funcion) VALUES ( 'Ver Medio');
INSERT INTO funcion (ds_funcion) VALUES ( 'Modificar Medio');
INSERT INTO funcion (ds_funcion) VALUES ( 'Listar Medio');

INSERT INTO menuoption (nombre, href, cd_funcion, orden, cd_menugroup, cssclass) VALUES ('Medios', 'doAction?action=listar_medios', , 11, 7, 'tipodocumentos');

ALTER TABLE `paciente`
	ADD COLUMN `cd_medio` INT NULL AFTER `dt_nacimiento`,
	ADD COLUMN `ds_otroMedio` VARCHAR(255) NULL DEFAULT NULL AFTER `cd_medio`;







