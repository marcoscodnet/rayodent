<?php

/**
 * Acción para visualizar un contacto.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class VerContactoAction extends OutputAction {

    /**
     * consulta un contacto.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_contacto = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_contacto', $id, '=');

                $manager = new ContactoManager();
                $oContacto = $manager->getContacto($criterio);
            } catch (GenericException $ex) {
                $oContacto = new Contacto();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el contacto.
            $this->parseEntidad($xtpl, $oContacto);
        }

        $xtpl->assign('titulo', 'Detalle de Contacto');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Contacto";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_CONTACTO);
    }

    public function parseEntidad($xtpl, $oContacto) {

        $xtpl->assign('cd_contacto', stripslashes($oContacto->getCd_contacto()));
        $xtpl->assign('cd_contacto_label', RYT_CONTACTO_CD_CONTACTO);

        $xtpl->assign('ds_apynom', stripslashes($oContacto->getDs_apynom()));
        $xtpl->assign('ds_apynom_label', RYT_CONTACTO_DS_APYNOM);

        $xtpl->assign('ds_movil', stripslashes($oContacto->getDs_movil()));
        $xtpl->assign('ds_movil_label', RYT_CONTACTO_DS_MOVIL);

        $xtpl->assign('ds_telefonotrabajo', stripslashes($oContacto->getDs_telefonotrabajo()));
        $xtpl->assign('ds_telefonotrabajo_label', RYT_CONTACTO_DS_TELEFONOTRABAJO);

        $xtpl->assign('ds_direccion', stripslashes($oContacto->getDs_direccion()));
        $xtpl->assign('ds_direccion_label', RYT_CONTACTO_DS_DIRECCION);

        $xtpl->assign('ds_telefono', stripslashes($oContacto->getDs_telefono()));
        $xtpl->assign('ds_telefono_label', RYT_CONTACTO_DS_TELEFONO);

        $xtpl->assign('ds_email', stripslashes($oContacto->getDs_email()));
        $xtpl->assign('ds_email_label', RYT_CONTACTO_DS_EMAIL);
        
        $xtpl->assign('nu_documento', stripslashes($oContacto->getNu_documento()));
        $xtpl->assign('nu_documento_label', RYT_CONTACTO_NU_DOCUMENTO);
        
        $xtpl->assign('nu_cuit', stripslashes($oContacto->getNu_cuit()));
        $xtpl->assign('nu_cuit_label', RYT_CONTACTO_NU_CUIT);

        
    }

    

}
