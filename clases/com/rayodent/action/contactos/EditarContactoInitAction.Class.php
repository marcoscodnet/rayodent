<?php

/**
 * Acción para inicializar el contexto para editar
 * un contacto.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
abstract class EditarContactoInitAction extends EditarInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getXTemplate()
     */
    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_CONTACTO);
    }

    protected function getEntidad() {

        //se construye el contacto a modificar.
        $oContacto = new Contacto ( );


        $oContacto->setCd_contacto ( FormatUtils::getParamPOST('cd_contacto') );	
				
		$oContacto->setDs_apynom ( FormatUtils::getParamPOST('ds_apynom') );	
				
		$oContacto->setDs_movil ( FormatUtils::getParamPOST('ds_movil') );	
				
		$oContacto->setDs_telefonotrabajo ( FormatUtils::getParamPOST('ds_telefonotrabajo') );	
				
		$oContacto->setDs_direccion ( FormatUtils::getParamPOST('ds_direccion') );	
				
		$oContacto->setDs_telefono ( FormatUtils::getParamPOST('ds_telefono') );	
				
		$oContacto->setDs_email ( FormatUtils::getParamPOST('ds_email') );	

		$oContacto->setNu_documento ( FormatUtils::getParamPOST('nu_documento') );	
		
		$oContacto->setNu_cuit ( FormatUtils::getParamPOST('nu_cuit') );	

        return $oContacto;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oContacto = FormatUtils::ifEmpty($entidad, new Contacto());


        $xtpl->assign('cd_contacto', stripslashes($oContacto->getCd_contacto()));
        $xtpl->assign('cd_contacto_label', RYT_CONTACTO_CD_CONTACTO);

        $xtpl->assign('ds_apynom', stripslashes($oContacto->getDs_apynom()));
        $xtpl->assign('ds_apynom_label', RYT_CONTACTO_DS_APYNOM);

        $xtpl->assign('ds_movil', stripslashes($oContacto->getDs_movil()));
        $xtpl->assign('ds_movil_label', RYT_CONTACTO_DS_MOVIL);

        $xtpl->assign('ds_direccion', stripslashes($oContacto->getDs_direccion()));
        $xtpl->assign('ds_direccion_label', RYT_CONTACTO_DS_DIRECCION);

        $xtpl->assign('ds_telefono', stripslashes($oContacto->getDs_telefono()));
        $xtpl->assign('ds_telefono_label', RYT_CONTACTO_DS_TELEFONO);
        
        $xtpl->assign('ds_telefonotrabajo', stripslashes($oContacto->getDs_telefonotrabajo()));
        $xtpl->assign('ds_telefonotrabajo_label', RYT_CONTACTO_DS_TELEFONOTRABAJO);

        $xtpl->assign('ds_email', stripslashes($oContacto->getDs_email()));
        $xtpl->assign('ds_email_label', RYT_CONTACTO_DS_EMAIL);
        
        $xtpl->assign('nu_documento', stripslashes($oContacto->getNu_documento()));
        $xtpl->assign('nu_documento_label', RYT_CONTACTO_NU_DOCUMENTO);
        
        $xtpl->assign('nu_cuit', stripslashes($oContacto->getNu_cuit()));
        $xtpl->assign('nu_cuit_label', RYT_CONTACTO_NU_CUIT);

        
    }

   

   

}
