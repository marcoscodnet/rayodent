<?php

/**
 * Acción para dar de alta un profesional.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaProfesionalAjaxAction extends EditarProfesionalAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        try {
            $manager = new ProfesionalManager();
            $manager->agregarProfesional($oEntidad);
            CdtUtils::log_debug('cd_pro = '.$oEntidad->getCd_profesional());
            if ($oEntidad->getCd_profesional() != "" && $oEntidad->getCd_profesional() != 0 && $oEntidad->getCd_profesional() != null) {
                $cd_profesional = $oEntidad->getCd_profesional();
                $ds_profesional = utf8_encode($oEntidad->getDs_nombre());
                //$rta = $cd_profesional . " | " . $ds_profesional;
                $jsondata['error'] = false;
                $jsondata['cd_profesional'] = $cd_profesional;
                $jsondata['ds_profesional'] = $ds_profesional;
            }
        } catch (GenericException $ex) {
            $msj = utf8_encode($ex->getMessage());
            $jsondata['error'] = true;
            $jsondata['msg'] = str_replace("\"", "", $msj);
        }
        echo json_encode($jsondata);
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardSuccess()
     */
    protected function getForwardSuccess() {
        return null;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#getForwardError()
     */
    protected function getForwardError() {
        return null;
    }

    protected function getActionForwardFailure() {
        return 'alta_profesional_ajax_init';
    }

    protected function getEntidad() {

//se construye el profesional a modificar.
        $oProfesional = new Profesional ( );

        $oProfesional->setCd_profesional(utf8_decode(FormatUtils::getParamPOST('cd_profesional')));
        $oProfesional->setDs_nombre(utf8_decode(FormatUtils::getParamPOST('ds_nombre')));
        $oProfesional->setCd_tipodocumento(utf8_decode(FormatUtils::getParamPOST('cd_tipodocumento')));
        $oProfesional->setNu_documento(utf8_decode(FormatUtils::getParamPOST('nu_documento')));
        $oProfesional->setNu_matricula(utf8_decode(FormatUtils::getParamPOST('nu_matricula')));
        $oProfesional->setDs_domicilio(utf8_decode(FormatUtils::getParamPOST('ds_domicilio')));
        $oProfesional->setDs_telefono(utf8_decode(FormatUtils::getParamPOST('ds_telefono')));
        $oProfesional->setDs_email(utf8_decode(FormatUtils::getParamPOST('ds_email')));
        
        return $oProfesional;
    }

}
