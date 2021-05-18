<?php

/**
 * se definen los labels para las columnas
 * de las tablas.
 *
 * @author modelBuilder
 *
 */
define('RYT_YES', 'SI');
define('RYT_NO', 'NO');

//labels para empleado
define('RYT_EMPLEADO_CD_EMPLEADO', 'C&oacute;digo');
define('RYT_EMPLEADO_CD_TIPODOCUMENTO', 'Tipo Doc');
define('RYT_EMPLEADO_NU_DOCUMENTO', 'Nro. Doc');
define('RYT_EMPLEADO_DS_NOMBRE', 'Apellido y Nombre');
define('RYT_EMPLEADO_CD_TIPOPERSONAL', 'Tipo personal');
define('RYT_EMPLEADO_DS_DOMICILIO', 'Direcci&oacute;n');
define('RYT_EMPLEADO_DS_TELEFONO', 'Tel&eacute;fono');
define('RYT_EMPLEADO_DS_EMAIL', 'Email');

//labels para profesional
define('RYT_PROFESIONAL_CD_PROFESIONAL', 'C&oacute;digo');
define('RYT_PROFESIONAL_CD_TIPODOCUMENTO', 'Tipo Doc');
define('RYT_PROFESIONAL_NU_DOCUMENTO', 'Nro. Doc');
define('RYT_PROFESIONAL_DS_NOMBRE', 'Apellido y Nombre');
define('RYT_PROFESIONAL_NU_MATRICULA', 'Nro. Matr&iacute;cula');
define('RYT_PROFESIONAL_DS_DOMICILIO', 'Direcci&oacute;n');
define('RYT_PROFESIONAL_DS_TELEFONO', 'Tel&eacute;fono');
define('RYT_PROFESIONAL_DS_EMAIL', 'Email');

//labels para tipodocumento
define('RYT_TIPODOCUMENTO_CD_TIPODOCUMENTO', 'C&oacute;digo');
define('RYT_TIPODOCUMENTO_DS_TIPODOCUMENTO', 'Descripci&oacute;n');

//labels para medio
define('RYT_MEDIO_CD_MEDIO', 'C&oacute;digo');
define('RYT_MEDIO_DS_MEDIO', 'Descripci&oacute;n');

//labels para tipopersonal
define('RYT_TIPOPERSONAL_CD_TIPOPERSONAL', 'C&oacute;digo');
define('RYT_TIPOPERSONAL_DS_TIPOPERSONAL', 'Descripci&oacute;n');


//labels para obrasocial
define('RYT_OBRASOCIAL_CD_OBRASOCIAL', 'C&oacute;digo');
define('RYT_OBRASOCIAL_DS_OBRASOCIAL', 'Descripci&oacute;n');
define('RYT_OBRASOCIAL_BL_ACTIVA', 'Activa');


//labels para practica
define('RYT_PRACTICA_CD_PRACTICA', 'c&oacute;digo');
define('RYT_PRACTICA_DS_PRACTICA', 'Descripci&oacute;n');

//labels para practicaobrasocial
define('RYT_PRACTICAOBRASOCIAL_CD_PRACTICAOBRASOCIAL', 'C&oacute;digo');
define('RYT_PRACTICAOBRASOCIAL_CD_PRACTICA', 'Pr&aacute;ctica');
define('RYT_PRACTICAOBRASOCIAL_CD_OBRASOCIAL', 'Obra Social');
define('RYT_PRACTICAOBRASOCIAL_NU_PRACTICAOS', 'c&oacute;digo para la O.S.');
define('RYT_PRACTICAOBRASOCIAL_NU_LIMITEREPETICIONES', 'Nro. de repeticiones anuales');
define('RYT_PRACTICAOBRASOCIAL_NU_IMPORTE', 'Importe');
define('RYT_PRACTICAOBRASOCIAL_DT_VIGENCIA', 'Fecha de vigencia');

//labels para concepto
define('RYT_CONCEPTO_CD_CONCEPTO', 'c&oacute;digo');
define('RYT_CONCEPTO_CD_TIPOCONCEPTO', 'Tipo Concepto');
define('RYT_CONCEPTO_CD_TIPOOPERACION', 'Tipo Operaci&oacute;n');
define('RYT_CONCEPTO_DS_CONCEPTO', 'Concepto');

//labels para tipoconcepto
define('RYT_TIPOCONCEPTO_CD_TIPOCONCEPTO', 'C&oacute;digo');
define('RYT_TIPOCONCEPTO_DS_TIPOCONCEPTO', 'Tipo de Concepto');

//labels para tipooperacion
define('RYT_TIPOOPERACION_CD_TIPOOPERACION', 'C&oacute;digo');
define('RYT_TIPOOPERACION_DS_TIPOOPERACION', 'Tipo de Operaci&oacute;n');

//labels para paciente
define('RYT_PACIENTE_CD_PACIENTE', 'C&oacute;digo');
define('RYT_PACIENTE_DS_APYNOM', 'Apellido y Nombre');
define('RYT_PACIENTE_CD_TIPODOC', 'Tipo documento');
define('RYT_PACIENTE_NU_DOC', 'Documento');
define('RYT_PACIENTE_DS_DIRECCION', 'Direcci&oacute;n');
define('RYT_PACIENTE_DS_TELEFONO', 'Tel&eacute;fono');
define('RYT_PACIENTE_DS_EMAIL', 'Mail');
define('RYT_PACIENTE_DT_PACIENTE', 'F. Nacimiento');
define('RYT_PACIENTE_CD_MEDIO', 'Medio de contacto');
define('RYT_PACIENTE_DS_OTRO_MEDIO', 'Otro medio');

//labels para pacienteobrasocial
define('RYT_PACIENTEOBRASOCIAL_CD_PACIENTEOBRASOCIAL', 'c&oacute;digo');
define('RYT_PACIENTEOBRASOCIAL_CD_PACIENTE', 'Paciente');
define('RYT_PACIENTEOBRASOCIAL_CD_OBRASOCIAL', 'Obra Social');

//labels para movcaja

define('RYT_MOVCAJA_CD_MOVCAJA', 'Cod. Mov. Caja');
define('RYT_MOVCAJA_CD_MOVCAJA_ARQUEO', 'Cod.');
define('RYT_MOVCAJA_DT_MOVCAJA', 'Fecha/Hora');
define('RYT_MOVCAJA_NU_TOTAL', 'Total');
define('RYT_MOVCAJA_DS_OBSERVACION', 'Observaci&oacute;n');
define('RYT_MOVCAJA_DS_DETALLE', 'Detalle');
define('RYT_MOVCAJA_NU_CAJA', 'Nro. Caja');
define('RYT_MOVCAJA_CD_USUARIO', 'cd_usuario');
define('RYT_MOVCAJA_CD_TURNO', 'Turno');
define('RYT_MOVCAJA_CD_ANULACION', 'Anulaci&oacute;n');
define('RYT_MOVCAJA_NU_ETIQUETA_SIMPLE', 'Etiquetas simples');
define('RYT_MOVCAJA_NU_ETIQUETA_DOBLE', 'Etiquetas dobles');

define('RYT_MOVCAJA_DS_PACIENTE', 'Paciente');
define('RYT_MOVCAJA_DS_PROFESIONAL', 'Profesional');
define('RYT_MOVCAJA_DS_PERSONAL', 'Personal');

define('RYT_MOVCAJA_DS_OBRASOCIAL', 'Obra Social');
define('RYT_MOVCAJA_DS_PRACTICA', 'Pr&aacute;ctica');
define('RYT_MOVCAJA_DS_APORTE', 'Aporte');
define('RYT_MOVCAJA_NU_IMPORTE', 'Importe');
define('RYT_MOVCAJA_BL_TARJETA', 'PosNet?');
define('RYT_MOVCAJA_NU_RECIBOREINTEGRO', 'Nro. Recibo Reintegro');
define('RYT_MOVCAJA_NU_PLACAS', 'Nro. Placas');
define('RYT_MOVCAJA_ORDEN_PRACTICAS', 'Orden Pr&aacute;ctica');
define('RYT_MOVCAJA_DS_PIEZA', 'Pieza');


//labels para ordenpractica
define('RYT_ORDENPRACTICA_CD_ORDENPRACTICA', 'C&oacute;d. Orden');
define('RYT_ORDENPRACTICA_DT_CARGA', 'Fecha');
define('RYT_ORDENPRACTICA_CD_TURNO', 'Turno');
define('RYT_ORDENPRACTICA_CD_PACIENTE', 'Paciente');
define('RYT_ORDENPRACTICA_CD_PROFESIONAL', 'Profesional');
define('RYT_ORDENPRACTICA_CD_EMPLEADO', 'Personal');
define('RYT_ORDENPRACTICA_CD_OBRASOCIALBONO', 'Obra Social');
define('RYT_ORDENPRACTICA_BL_BONO', 'Tiene bono?');
define('RYT_ORDENPRACTICA_NU_IMPORTEBONO', 'Importe Bono');
define('RYT_ORDENPRACTICA_NU_RECIBOREINTEGRO', 'Recibo reintegro');

//labels para practicaordenpractica
define('RYT_PRACTICAORDENPRACTICA_CD_PRACTICAORDENPRACTICA', 'C&oacute;digo');
define('RYT_PRACTICAORDENPRACTICA_CD_OBRASOCIAL', 'Obra social');
define('RYT_PRACTICAORDENPRACTICA_CD_PRACTICA', 'Pr&aacute;ctica');
define('RYT_PRACTICAORDENPRACTICA_NU_PRACTICA', 'Nomenclatura');
define('RYT_PRACTICAORDENPRACTICA_DT_CARGA', 'Fecha/Hora');
define('RYT_PRACTICAORDENPRACTICA_CD_PACIENTE', 'Paciente');

define('RYT_PRACTICAORDENPRACTICA_CD_ORDENPRACTICA', 'C&oacute;d. Orden Pr&aacute;ctica');
define('RYT_PRACTICAORDENPRACTICA_NU_CANTPLACAS', 'Cant. Placas');
define('RYT_PRACTICAORDENPRACTICA_CD_APORTEOS', 'Aporte');
define('RYT_PRACTICAORDENPRACTICA_NU_REPETICIONES', 'Repeticiones');
define('RYT_PRACTICAORDENPRACTICA_CD_INFORME', 'cd_informe');
define('RYT_PRACTICAORDENPRACTICA_CD_MOVCAJACONCEPTO', 'cd_movcajaconcepto');

//labels para informe
define('RYT_INFORME_CD_INFORME', 'cd_informe');
define('RYT_INFORME_DS_APYNOM', 'Paciente');
define('RYT_INFORME_DS_PROFESIONAL', 'Profesional');
define('RYT_INFORME_DS_ESTUDIORX', 'Estudio RX');
define('RYT_INFORME_DS_INFORME', 'Informe');

define('RYT_LIQUIDACION_NU_IMPORTE', 'Importe a liquidar');
define('RYT_PRACTICAORDENPRACTICA_NU_IMPORTE', 'Importe');

//labels para paciente
define('RYT_CONTACTO_CD_CONTACTO', 'C&oacute;digo');
define('RYT_CONTACTO_DS_APYNOM', 'Apellido y Nombre');
define('RYT_CONTACTO_DS_MOVIL', 'Celular');
define('RYT_CONTACTO_DS_TELEFONOTRABAJO', 'T. Laboral');
define('RYT_CONTACTO_DS_DIRECCION', 'Direcci&oacute;n');
define('RYT_CONTACTO_DS_TELEFONO', 'Tel&eacute;fono');
define('RYT_CONTACTO_DS_EMAIL', 'Mail');
define('RYT_CONTACTO_NU_DOCUMENTO', 'D.N.I.');
define('RYT_CONTACTO_NU_CUIT', 'C.U.I.L.');

//labels para email
define('RYT_EMAIL_CD_EMAIL', 'C&oacute;digo');
define('RYT_EMAIL_DS_REMITENTE', 'Remitente');
define('RYT_EMAIL_DS_DESTINATARIO', 'Destinatario');
define('RYT_EMAIL_DS_ASUNTO', 'Asunto');
define('RYT_EMAIL_DS_CUERPO', 'Cuerpo');
define('RYT_EMAIL_DT_FECHA', 'Fecha y hora');
define('RYT_EMAIL_DS_ADJUNTOS', 'Archivos Adjuntos');
?>
