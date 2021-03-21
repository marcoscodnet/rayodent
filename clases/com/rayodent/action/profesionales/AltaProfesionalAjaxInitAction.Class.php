<?php

/**
 * Acción para inicializar el contexto para dar de alta
 * un profesional.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaProfesionalAjaxInitAction extends EditarProfesionalInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Alta Profesional";
    }

     /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "alta_profesional_ajax";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_PROFESIONAL_AJAX);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

protected function getEntidad() {

        //se construye el profesional a modificar.
        $oProfesional = new Profesional ( );


        $oProfesional->setCd_profesional(FormatUtils::getParamPOST('cd_profesional'));

        $oProfesional->setCd_tipodocumento(FormatUtils::getParamPOST('cd_tipodocumento'));

        $oProfesional->setNu_documento(FormatUtils::getParamPOST('nu_documento'));

        $oProfesional->setDs_nombre(FormatUtils::getParamPOST('ds_nombre'));

        $oProfesional->setNu_matricula(FormatUtils::getParamPOST('nu_matricula'));

        $oProfesional->setDs_domicilio(FormatUtils::getParamPOST('ds_domicilio'));

        $oProfesional->setDs_telefono(FormatUtils::getParamPOST('ds_telefono'));

        $oProfesional->setDs_email(FormatUtils::getParamPOST('ds_email'));


        return $oProfesional;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oProfesional = FormatUtils::ifEmpty($entidad, new Profesional());


        $xtpl->assign('cd_profesional', stripslashes($oProfesional->getCd_profesional()));
        $xtpl->assign('cd_profesional_label', RYT_PROFESIONAL_CD_PROFESIONAL);

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



        $xtpl->assign('cd_tipodocumento_label', RYT_PROFESIONAL_CD_TIPODOCUMENTO);
        $selected = $oProfesional->getCd_tipodocumento();
        $this->parseTipoDocumento($selected, $xtpl);
    }

    protected function parseTipoDocumento($selected, XTemplate $xtpl) {

        $manager = new TipoDocumentoManager();
        $criterio = new CriterioBusqueda();
        $tipodocumentos = $manager->getTipoDocumentos($criterio);

        foreach ($tipodocumentos as $key => $oTipoDocumento) {

            $xtpl->assign('ds_tipoDocumento', $oTipoDocumento->getDs_tipodocumento());
            $xtpl->assign('cd_tipoDocumento', FormatUtils::selected($oTipoDocumento->getCd_tipodocumento(), $selected));

            $xtpl->parse('main.tipodocumentos_option');
        }
    }

   

}
