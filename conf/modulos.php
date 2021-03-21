<?php

define('RYT_PATH_ADJUNTOS', '/email_adjuntos/');

define('RYT_PATH', APP_PATH . '/clases/com/rayodent/');

/* mvc */
define('MVC_PATH', $_SERVER ['DOCUMENT_ROOT'] . '/codnet_mvc/');


/*+--------------------------------------------------+
 *|             Datos de producci�n                  |
 *+--------------------------------------------------+
 *define('MVC_PATH', '/var/www/codnet_mvc/');
*/




define('CDT_MVC_PATH', MVC_PATH . 'codnet_1_2_18/');
//define('CDT_MVC_PATH', 'F:/xampp/htdocs/codnet_desarrollo/codnet_filtro/');



include_once (CDT_MVC_PATH . 'conf/init.php');
define('DEFAULT_MENU', 'Menu');
define('NOMBRE_APLICACION', 'RAYODENT');
define('NOMBRE_EMPRESA_PDF', 'RAYODENT');
define('CDT_MVC_APP_TITULO', 'RAYODENT');
define('CDT_MVC_APP_SUBTITULO', 'Sistema de gesti�n');

/* seguridad */
define('CDT_SEGURIDAD_PATH', MVC_PATH . 'codnet_seguridad_0_4_8/');
include_once (CDT_SEGURIDAD_PATH . 'conf/init.php');

define('CDT_SEGURIDAD_LOGIN_TITULO', CDT_MVC_APP_TITULO);
define('CDT_SEGURIDAD_LOGIN_SUBTITULO', CDT_MVC_APP_SUBTITULO);
define('CDT_SEGURIDAD_REGISTRARSE_TITULO', CDT_MVC_APP_TITULO);
define('CDT_SEGURIDAD_REGISTRARSE_SUBTITULO', CDT_MVC_APP_SUBTITULO);

/* geo */
define('CDT_GEO_PATH', MVC_PATH . 'codnet_geo_0_4_0/');
include_once (CDT_GEO_PATH . 'conf/init.php' );

/* layout */
define('CDT_LAYOUT_DESKTOP_PATH', MVC_PATH . 'codnet_layout_desktop_0_4_4/');
include_once (CDT_LAYOUT_DESKTOP_PATH . 'conf/init.php');
define('DEFAULT_SECURE_LAYOUT', 'LayoutRYTMenu');
define('DEFAULT_PANEL_LAYOUT', 'LayoutRYTPanel');
define('DEFAULT_LAYOUT', 'LayoutRYT');
define('DEFAULT_LOGIN_LAYOUT', 'LayoutDesktopLogin');
define('DEFAULT_POPUP_LAYOUT', 'LayoutDesktopPopup');

/* componentes */
define('CDT_CMP_PATH', MVC_PATH . 'codnet_componentes_0_2_2/');
include_once (CDT_CMP_PATH . 'conf/init.php');

date_default_timezone_set("America/Argentina/Buenos_Aires");

if (!defined('CLASS_PATH')) {
    $classpath = array();
    $classpath[] = CDT_MVC_PATH;
    $classpath[] = CDT_SEGURIDAD_PATH;
    $classpath[] = CDT_GEO_PATH;
    $classpath[] = CDT_CMP_PATH;
    $classpath[] = CDT_LAYOUT_DESKTOP_PATH;
    $classpath[] = RYT_PATH;
    define('CLASS_PATH', implode(",", $classpath));
}


//para optimizar el class_path.
if (!defined('CLASS_PATH_EXCLUDE')) {
    $exclude = array();
    $exclude[] = CDT_MVC_PATH . 'view/templates';
    $exclude[] = CDT_SEGURIDAD_PATH . 'view/templates';
    $exclude[] = CDT_GEO_PATH . 'view/templates';
    $exclude[] = CDT_LAYOUT_DESKTOP_PATH . 'view/templates';
    $exclude[] = RYT_PATH . 'view/templates';
    define('CLASS_PATH_EXCLUDE', implode(",", $exclude));
}