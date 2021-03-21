<?php

/**
 * Acción para visualizar un profesional.
 *  
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class VerProfesionalAction extends OutputAction {

    /**
     * consulta un profesional.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_profesional = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_profesional', $id, '=');

                $manager = new ProfesionalManager();
                $oProfesional = $manager->getProfesional($criterio);
            } catch (GenericException $ex) {
                $oProfesional = new Profesional();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el profesional.
            $this->parseEntidad($xtpl, $oProfesional);
        }

        $xtpl->assign('titulo', 'Detalle de Profesional');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Profesional";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_PROFESIONAL);
    }

    public function parseEntidad($xtpl, $oProfesional) {


        $xtpl->assign('cd_profesional', stripslashes($oProfesional->getCd_profesional()));
        $xtpl->assign('cd_profesional_label', RYT_PROFESIONAL_CD_PROFESIONAL);

        $xtpl->assign('ds_tipodocumento', stripslashes($oProfesional->getTipoDocumento()->getDs_tipodocumento()));
        $xtpl->assign('cd_tipodocumento_label', RYT_PROFESIONAL_CD_TIPODOCUMENTO);

        $xtpl->assign('nu_documento', stripslashes($oProfesional->getNu_documento()));
        $xtpl->assign('nu_documento_label', RYT_PROFESIONAL_NU_DOCUMENTO);

        $xtpl->assign('ds_nombre', stripslashes($oProfesional->getDs_nombre()));
        $xtpl->assign('ds_nombre_label', RYT_PROFESIONAL_DS_NOMBRE);

        $xtpl->assign('nu_matricula', stripslashes($oProfesional->getNu_matricula()));
        $xtpl->assign('nu_matricula_label', RYT_PROFESIONAL_NU_MATRICULA);

        $xtpl->assign('ds_domicilio', stripslashes($oProfesional->getDs_domicilio()));
        $xtpl->assign('ds_domicilio_label', RYT_PROFESIONAL_DS_DOMICILIO);

        $xtpl->assign('ds_telefono', stripslashes($oProfesional->getDs_telefono()));
        $xtpl->assign('ds_telefono_label', RYT_PROFESIONAL_DS_TELEFONO);

        $xtpl->assign('ds_email', stripslashes($oProfesional->getDs_email()));
        $xtpl->assign('ds_email_label', RYT_PROFESIONAL_DS_EMAIL);
    }

}
