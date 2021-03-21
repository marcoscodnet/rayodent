<?php

/**
 * Acci�n para visualizar un email.
 *  
 * @author Marcos
 * @since 10-10-2018
 * 
 */
class VerEmailAction extends OutputAction {

    /**
     * consulta un email.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_email = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_email', $id, '=');

                $manager = new EmailManager();
                $oEmail = $manager->getEmail($criterio);
            } catch (GenericException $ex) {
                $oEmail = new Email();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el email.
            $this->parseEntidad($xtpl, $oEmail);
        }

        $xtpl->assign('titulo', 'Detalle de E-mail');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver E-mail";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_EMAIL);
    }

    public function parseEntidad($xtpl, $oEmail) {

        $xtpl->assign('cd_email', stripslashes($oEmail->getCd_email()));
        $xtpl->assign('cd_email_label', RYT_EMAIL_CD_EMAIL);

        $xtpl->assign('ds_remitente', stripslashes($oEmail->getDs_remitente()));
        $xtpl->assign('ds_remitente_label', RYT_EMAIL_DS_REMITENTE);

        $xtpl->assign('ds_destinatario', stripslashes($oEmail->getDs_destinatario()));
        $xtpl->assign('ds_destinatario_label', RYT_EMAIL_DS_DESTINATARIO);

        $xtpl->assign('dt_fecha', stripslashes($oEmail->getDt_fecha()));
        $xtpl->assign('dt_fecha_label', RYT_EMAIL_DT_FECHA);

        $xtpl->assign('ds_asunto', stripslashes($oEmail->getDs_asunto()));
        $xtpl->assign('ds_asunto_label', RYT_EMAIL_DS_ASUNTO);

        $xtpl->assign('ds_cuerpo', '<a href="doAction?action=ver_cuerpo&id='.$oEmail->getCd_email().'" target="_blank">Ver mensaje</a>');
        $xtpl->assign('ds_cuerpo_label', RYT_EMAIL_DS_CUERPO);
        
        $xtpl->assign('ds_adjuntos_label', RYT_EMAIL_DS_ADJUNTOS);
        $adjuntos = '';
    	$dir = APP_PATH.'/'.RYT_PATH_ADJUNTOS.'/'.$oEmail->getNu_email().'/';
		$dirREL = WEB_PATH.'/'.RYT_PATH_ADJUNTOS.'/'.$oEmail->getNu_email().'/';
		if (file_exists($dir)){
				
		      
	     $handle=opendir($dir);
			while ($archivo = readdir($handle))
			{
				if (is_file($dir.$archivo))
	         	{
		         	$adjuntos .='<a href="'.$dirREL.$archivo.'" target="_blank">'.$archivo.'</a>'."<br>";
	         	}	
		         	
					
			}
			closedir($handle);
		}
		$xtpl->assign('ds_adjuntos', $adjuntos);
       

        
    }

    

}
