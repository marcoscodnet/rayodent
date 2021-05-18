<?php

define("CD_PERFIL_ADMINISTRADOR", 1);

define("CD_OBRASOCIAL_IOMA", 1);
define("CD_OBRASOCIAL_PARTICULAR", 12);
define("DS_OBRASOCIAL_PARTICULAR", 12);

define("CD_PRACTICA_PANORAMICA", 1);
define("CD_PRACTICA_SERIADA", 7);

define("CD_TIPO_CONCEPTO_PRACTICA", 1);
define("CD_TIPO_CONCEPTO_BONO", 2);
define("CD_TIPO_CONCEPTO_REINTEGRO", 3);
define("CD_TIPO_CONCEPTO_GASTOS", 8);

define("CD_TIPO_OPERACION_INGRESO", 1);
define("CD_TIPO_OPERACION_EGRESO", 2);
define("CD_TIPO_OPERACION_SINCOSTO", 3);

//Constantes para nulaci�n de movimientos de caja
define("CD_CONCEPTO_CONTRAASIENTO_POSITIVO", 7);
define("CD_CONCEPTO_CONTRAASIENTO_NEGATIVO", 8);
define("CD_CONCEPTO_PRACTICA_PARTICULAR", 3);


//Constantes para apertura y cierre de caja
define("NU_CAJA_CAJA_CENTRAL", 100);
define("CD_USUARIO_CAJA_CENTRAL", 4);

define("CD_CONCEPTO_INGRESO", 11);
define("CD_CONCEPTO_EXTRACCION_CAJA_CENTRAL", 10);
define("CD_CONCEPTO_INGRESO_CAJA_CENTRAL", 12);
define("CD_CONCEPTO_EGRESO_CIERRE", 13);
define("CD_CONCEPTO_EGRESO_LIQUIDACION_PROFESIONAL", 15);

define("CD_MEDIO_OTRO", 6);



define("CDT_DEBUG_LOG", true);
define("CDT_ERROR_LOG", true);
define("CDT_MESSAGE_LOG", true);
define("CDT_ERROR_HANDLER", true);


ini_set('display_errors', 1);
ini_set('default_charset', 'UTF-8');
ini_set('max_execution_time', 0);
?>
