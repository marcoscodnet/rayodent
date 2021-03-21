<?php

class ValidarDniPacientesAction extends Action {

    protected function getFiltro() {
        $nu_doc = urldecode(FormatUtils::getParam('nu_doc', '0'));
        $cd_tipodoc = urldecode(FormatUtils::getParam('cd_tipodoc'));
        $cd_paciente = urldecode(FormatUtils::getParam('cd_paciente'));
        $oCriterio = new CriterioBusqueda();
        $oCriterio->addFiltro("P.cd_tipodoc", $cd_tipodoc, "=");
        $oCriterio->addFiltro("P.nu_doc", $nu_doc, "=");
        if (isset($cd_paciente) && ($cd_paciente != "")) {
            $oCriterio->addFiltro("P.cd_paciente", $cd_paciente, "<>");
        }
        return $oCriterio;
    }

    public function validar($oCriterioBusqueda) {
        $nu_doc = urldecode(FormatUtils::getParam('nu_doc', null));
        $oPacienteManager = new PacienteManager();
        $cant = $oPacienteManager->getCantidadEntidades($oCriterioBusqueda);

        if ($nu_doc == null || $nu_doc == '0') {
            $msj = utf8_encode("<div class='ui-state-error ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p style='text-align:center;margin-bottom: 5px;margin-top: 0;'><span id='msg-valid' class='ui-icon ui-icon-alert' style='margin-right: 0.3em;'></span>El Nº de documento no puede ser 0.</p></div>");
            echo $msj;
            return $msj;
        }
        if ($cant > 0) {
            $msj = utf8_encode("<div class='ui-state-error ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'><p style='text-align:center;margin-bottom: 5px;margin-top: 0;'><span id='msg-valid' class='ui-icon ui-icon-alert' style='margin-right: 0.3em;'></span>El tipo y Nº de documento ya existe para otro paciente</p></div>");
            echo $msj;
            return $msj;
        } else {
            echo "";
            return "";
        }
    }

    public function execute() {

        //se inicia una transacci�n.
        DbManager::begin_tran();

        try {
            $oFiltro = $this->getFiltro();
            $this->validar($oFiltro);
            //commit de la transacci�n.
            DbManager::save();
        } catch (GenericException $ex) {
            //rollback de la transacci�n.
            DbManager::undo();
            CdtUtils::log_debug('failure en ValidarDniPacientesAction');
        }

        return $forward;
    }

}
