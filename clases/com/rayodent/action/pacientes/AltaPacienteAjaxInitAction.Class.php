<?php

/**
 * Acci�n para inicializar el contexto para dar de alta
 * un paciente.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class AltaPacienteAjaxInitAction extends EditarPacienteInitAction {

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/SecureOutputAction#getTitulo()
     */
    protected function getTitulo() {
        return "Alta Paciente";
    }

     /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getAccionSubmit()
     */
    protected function getAccionSubmit() {
        return "alta_paciente_ajax";
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#getMostrarCodigo()
     */
    protected function getMostrarCodigo() {
        return false;
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_EDITAR_PACIENTE_AJAX);
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

    protected function getEntidad() {

        //se construye el paciente a modificar.
        $oPaciente = new Paciente ( );


        $oPaciente->setCd_paciente(FormatUtils::getParamPOST('cd_paciente'));

        $oPaciente->setDs_apynom(FormatUtils::getParamPOST('ds_apynom'));

        $oPaciente->setCd_tipodoc(FormatUtils::getParamPOST('cd_tipodoc'));

        $oPaciente->setNu_doc(FormatUtils::getParamPOST('nu_doc'));

        $oPaciente->setDs_direccion(FormatUtils::getParamPOST('ds_direccion'));

        $oPaciente->setDs_telefono(FormatUtils::getParamPOST('ds_telefono'));

        $oPaciente->setDs_email(FormatUtils::getParamPOST('ds_email'));
        
        $oPaciente->setDt_nacimiento(FormatUtils::getParamPOST('dt_nacimiento'));


        return $oPaciente;
    }

    /**
     * (non-PHPdoc)
     * @see clases/com/cdt/action/generic/EditarInitAction#parseEntidad($entidad, $xtpl)
     */
    protected function parseEntidad($entidad, XTemplate $xtpl) {
        $oPaciente = FormatUtils::ifEmpty($entidad, new Paciente());


        $xtpl->assign('cd_paciente', stripslashes($oPaciente->getCd_paciente()));
        $xtpl->assign('cd_paciente_label', RYT_PACIENTE_CD_PACIENTE);

        $xtpl->assign('ds_apynom', stripslashes($oPaciente->getDs_apynom()));
        $xtpl->assign('ds_apynom_label', RYT_PACIENTE_DS_APYNOM);

        $xtpl->assign('nu_doc', stripslashes($oPaciente->getNu_doc()));
        $xtpl->assign('nu_doc_label', RYT_PACIENTE_NU_DOC);

        $xtpl->assign('ds_direccion', stripslashes($oPaciente->getDs_direccion()));
        $xtpl->assign('ds_direccion_label', RYT_PACIENTE_DS_DIRECCION);

        $xtpl->assign('ds_telefono', stripslashes($oPaciente->getDs_telefono()));
        $xtpl->assign('ds_telefono_label', RYT_PACIENTE_DS_TELEFONO);

        $xtpl->assign('ds_email', stripslashes($oPaciente->getDs_email()));
        $xtpl->assign('ds_email_label', RYT_PACIENTE_DS_EMAIL);
        
        if ($oPaciente->getDt_nacimiento() == "") {
            $xtpl->assign('dt_nacimiento', "");
        } else {
            $xtpl->assign('dt_nacimiento', FuncionesComunes:: fechaMysqlaPHP(stripslashes($oPaciente->getDt_nacimiento())));
        }
        $xtpl->assign('dt_nacimiento_label', RYT_PACIENTE_DT_PACIENTE);

        //Tipodocumento
        $xtpl->assign('cd_tipodoc_label', RYT_PACIENTE_CD_TIPODOC);
        $selected = $oPaciente->getCd_tipodoc();
        $this->parseTipoDocumento($selected, $xtpl);
        $cd_paciente = $oPaciente->getCd_paciente();
        $this->parseObrassociales($cd_paciente, $xtpl);
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

    protected function parseObrassociales($cd_paciente, XTemplate $xtpl) {
        $_SESSION['pacientesobrasociales_session'] = new ItemCollection();
        if ($cd_paciente != "" && $cd_paciente != null) {
            $manager = new PacienteobrasocialManager();
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("cd_paciente", $cd_paciente, "=");
            $pacientesobrassociales = $manager->getPacientesobrasociales($criterio);
            foreach ($pacientesobrassociales as $key => $oPacienteObrasocial) {
                $_SESSION['pacientesobrasociales_session']->addItem($oPacienteObrasocial->getObrasocial()->getCd_obrasocial());
            }

            foreach ($pacientesobrassociales as $key => $oPacienteObrasocial) {
                $xtpl->assign('ds_obrasocial', $oPacienteObrasocial->getObrasocial()->getDs_obrasocial());
                $xtpl->parse('main.pacientesobrassociales');
            }
        }
    }

}
