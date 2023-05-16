ALTER TABLE obrasocial
	ADD COLUMN bl_activa TINYINT(1) NOT NULL DEFAULT '1' AFTER ds_obrasocial;
ALTER TABLE liquidacionprofesional
	ADD CONSTRAINT FK_liquidacionprofesional_movcaja FOREIGN KEY (cd_movcaja) REFERENCES movcaja (cd_movcaja);
ALTER TABLE liquidacionprofesional
	ADD CONSTRAINT FK_liquidacionprofesional_profesional FOREIGN KEY (cd_profesional) REFERENCES profesional (cd_profesional);
ALTER TABLE movcaja
	ADD CONSTRAINT FK_movcaja_usuario FOREIGN KEY (cd_usuario) REFERENCES usuario (cd_usuario);
ALTER TABLE movcajaconcepto
	ADD CONSTRAINT FK_movcajaconcepto_movcaja FOREIGN KEY (cd_movcaja) REFERENCES movcaja (cd_movcaja);
ALTER TABLE movcajaconcepto
	ADD CONSTRAINT FK_movcajaconcepto_concepto FOREIGN KEY (cd_concepto) REFERENCES concepto (cd_concepto);
ALTER TABLE ordenpractica
	ADD CONSTRAINT FK_ordenpractica_obrasocial FOREIGN KEY (cd_obrasocial) REFERENCES obrasocial (cd_obrasocial);
ALTER TABLE ordenpractica
	ADD CONSTRAINT FK_ordenpractica_movcaja FOREIGN KEY (cd_movcaja) REFERENCES movcaja (cd_movcaja);
ALTER TABLE paciente
	ADD INDEX cd_tipodoc (cd_tipodoc);
ALTER TABLE practicaordenpractica
	ADD CONSTRAINT FK_practicaordenpractica_practicaobrasocial FOREIGN KEY (cd_practicaobrasocial) REFERENCES practicaobrasocial (cd_practicaobrasocial);
ALTER TABLE practicaordenpractica
	ADD CONSTRAINT FK_practicaordenpractica_movcajaconcepto FOREIGN KEY (cd_movcajaconcepto) REFERENCES movcajaconcepto (cd_movcajaconcepto);
ALTER TABLE practicaordenpractica
	ADD INDEX cd_liquidacionprofesional (cd_liquidacionprofesional);
ALTER TABLE practicaordenpractica
	ADD INDEX cd_aporteos (cd_aporteos);
ALTER TABLE procesocaja
	ADD CONSTRAINT FK_procesocaja_turno FOREIGN KEY (cd_turno) REFERENCES turno (cd_turno);
ALTER TABLE procesocaja
	ADD CONSTRAINT FK_procesocaja_usuario FOREIGN KEY (cd_usuario) REFERENCES usuario (cd_usuario);
ALTER TABLE procesocaja
	ADD CONSTRAINT FK_procesocaja_movcaja FOREIGN KEY (cd_movcaja) REFERENCES movcaja (cd_movcaja);
	
##################################### 12-08-2014 ##########################################################
ALTER TABLE practica
	ADD COLUMN bl_activa TINYINT(1) NOT NULL DEFAULT '1' AFTER ds_practica;

##################################### 05-09-2014 ##########################################################
CREATE TABLE contacto (
	cd_contacto INT(11) NOT NULL AUTO_INCREMENT,
	ds_apynom VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_direccion VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_email VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_telefono VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_movil VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_telefonotrabajo VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	PRIMARY KEY (cd_contacto)
)
COLLATE='utf8_spanish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

##################################### 11-09-2014 ##########################################################
CREATE TABLE movcajacontrolpractica (
	cd_movcajacontrolpractica INT(11) NOT NULL AUTO_INCREMENT,
	`cd_obrasocial` INT(11) NOT NULL,
	`cd_practica1` INT(11) NOT NULL,
	`cd_practica2` INT(11) NOT NULL,
	PRIMARY KEY (cd_movcajacontrolpractica)
)
COLLATE='utf8_spanish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

INSERT INTO `movcajacontrolpractica` (`cd_obrasocial`, `cd_practica1`, `cd_practica2`) VALUES (1, 6, 1);
INSERT INTO `movcajacontrolpractica` (`cd_obrasocial`, `cd_practica1`, `cd_practica2`) VALUES (1, 6, 2);
INSERT INTO `movcajacontrolpractica` (`cd_obrasocial`, `cd_practica1`, `cd_practica2`) VALUES (1, 1, 4);
INSERT INTO `movcajacontrolpractica` (`cd_obrasocial`, `cd_practica1`, `cd_practica2`) VALUES (1, 7, 1);
INSERT INTO `movcajacontrolpractica` (`cd_obrasocial`, `cd_practica1`, `cd_practica2`) VALUES (1, 7, 2);
INSERT INTO `movcajacontrolpractica` (`cd_obrasocial`, `cd_practica1`, `cd_practica2`) VALUES (1, 2, 4);

##################################### 06-11-2014 ##########################################################
ALTER TABLE contacto
	ADD COLUMN nu_documento VARCHAR(250),
	ADD COLUMN nu_cuit VARCHAR(250);
	
##################################### 09-12-2014 ##########################################################
ALTER TABLE practicaobrasocial
	ADD COLUMN bl_activa TINYINT(1) NOT NULL DEFAULT '1';
	
UPDATE `practicaobrasocial` SET `bl_activa`=0 WHERE  `cd_practicaobrasocial`=32;

##################################### 18-12-2014 ##########################################################
UPDATE `practicaobrasocial` SET `bl_activa`=0 WHERE  `cd_practicaobrasocial`=111;
UPDATE `practicaobrasocial` SET `bl_activa`=0 WHERE  `cd_practicaobrasocial`=107;
UPDATE `practicaobrasocial` SET `bl_activa`=0 WHERE  `cd_practicaobrasocial`=248;


#################################### 01-11-2016 ###########################################################
ALTER TABLE `movcajaconcepto`
	ADD COLUMN `cd_ordenpractica` INT(11) NULL AFTER `nu_importe`;

ALTER TABLE `movcaja`
	ADD COLUMN `nu_etiquetasimple` INT NULL AFTER `bl_anulacion`,
	ADD COLUMN `nu_etiquetadoble` INT NULL AFTER `nu_etiquetasimple`;
	
#################################### 08-06-2017 ###########################################################
ALTER TABLE `movcajaconcepto`
	ADD COLUMN `bl_tarjeta` INT(11) NULL AFTER `nu_importe`;

#################################### 15-03-2018 ###########################################################
ALTER TABLE `paciente`
	ADD COLUMN `dt_nacimiento` VARCHAR(8) NULL DEFAULT NULL AFTER `ds_email`;
	
#################################### 10-10-2018 ###########################################################
CREATE TABLE email (
	cd_email INT(11) NOT NULL AUTO_INCREMENT,
	ds_remitente VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_destinatario VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_asunto VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	ds_cuerpo LONGTEXT NULL DEFAULT NULL COLLATE 'utf8_spanish_ci',
	dt_fecha datetime NULL DEFAULT NULL ,
	nu_email INT (11) NULL,
	PRIMARY KEY (cd_email)
)
COLLATE='utf8_spanish_ci'
ENGINE=InnoDB
AUTO_INCREMENT=1;

#################################### 07-02-2019 ###########################################################
ALTER TABLE `practicaordenpractica`
	ADD COLUMN `ds_pieza` VARCHAR(255) NULL AFTER `cd_aporteos`;
	
#################################### 06-06-2019 ###########################################################
UPDATE `practicaobrasocial` SET `bl_activa`='0' WHERE  `cd_practicaobrasocial`=853;
UPDATE `practicaobrasocial` SET `bl_activa`='0' WHERE  `cd_practicaobrasocial`=1618;
UPDATE `practicaobrasocial` SET `bl_activa`='0' WHERE  `cd_practicaobrasocial`=1213;
UPDATE `practicaobrasocial` SET `bl_activa`='0' WHERE  `cd_practicaobrasocial`=1774;
UPDATE `practicaobrasocial` SET `bl_activa`='0' WHERE  `cd_practicaobrasocial`=1775;
UPDATE `practicaobrasocial` SET `bl_activa`='0' WHERE  `cd_practicaobrasocial`=1235;

################################# 16-05-2023 #################################################################
    INSERT INTO menuoption (nombre, href, cd_funcion, orden, cd_menugroup, cssclass, descripcion_panel) VALUES('Arquear anteriores', 'doAction?action=arquear_caja_anterior', 288, '4', '8', 'arquearcaja', '')