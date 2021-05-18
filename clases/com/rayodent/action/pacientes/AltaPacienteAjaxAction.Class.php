<?php

/**
 * Acci�n para dar de alta un paciente.
 *
 * @author modelBuilder
 * @since 12-12-2011
 *
 */
class AltaPacienteAjaxAction extends EditarPacienteAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarAction#editar($oEntidad)
     */
    protected function editar($oEntidad) {
        try {
            $manager = new PacienteManager();
            $manager->agregarPaciente($oEntidad);
            if ($oEntidad->getCd_paciente() != "" && $oEntidad->getCd_paciente() != 0 && $oEntidad->getCd_paciente() != null) {
                $cd_paciente = $oEntidad->getCd_paciente();
                $ds_paciente = utf8_encode($oEntidad->getDs_apynom());
                //$rta = $cd_paciente . " | " . $ds_paciente;
                $jsondata['error'] = false;
                $jsondata['cd_paciente'] = $cd_paciente;
                $jsondata['ds_paciente'] = $ds_paciente;
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
        return 'alta_paciente_ajax_init';
    }

    protected function getEntidad() {

//se construye el paciente a modificar.
        $oPaciente = new Paciente ( );

        $oPaciente->setCd_paciente(utf8_decode(FormatUtils::getParamPOST('cd_paciente')));
        $oPaciente->setDs_apynom(utf8_decode(FormatUtils::getParamPOST('ds_apynom')));
        $oPaciente->setCd_tipodoc(utf8_decode(FormatUtils::getParamPOST('cd_tipodoc')));
        $oPaciente->setNu_doc(utf8_decode(FormatUtils::getParamPOST('nu_doc')));
        $oPaciente->setDs_direccion(utf8_decode(FormatUtils::getParamPOST('ds_direccion')));
        $oPaciente->setDs_telefono(utf8_decode(FormatUtils::getParamPOST('ds_telefono')));
        $oPaciente->setDs_email(utf8_decode(FormatUtils::getParamPOST('ds_email')));
        $oPaciente->setDt_nacimiento(FuncionesComunes::fechaPHPaMysql(FormatUtils::getParamPOST('dt_nacimiento')));
        $oPaciente->setCd_medio(utf8_decode(FormatUtils::getParamPOST('cd_medio')));
        $oPaciente->setDs_otroMedio(utf8_decode(FormatUtils::getParamPOST('ds_otroMedio')));
        return $oPaciente;
    }

}
