<?php

/**
 * Acción para visualizar un paciente.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class VerPacienteAction extends OutputAction {

    /**
     * consulta un paciente.
     */
    protected function getContenido() {

        $xtpl = $this->getXTemplate();

        if (isset($_GET ['id'])) {
            $cd_paciente = FormatUtils::getParam('id');


            try {
                $id = FormatUtils::getParam('id');

                $criterio = new CriterioBusqueda();
                $criterio->addFiltro('cd_paciente', $id, '=');

                $manager = new PacienteManager();
                $oPaciente = $manager->getPaciente($criterio);
            } catch (GenericException $ex) {
                $oPaciente = new Paciente();
                //TODO ver si se muestra un mensaje de error.
            }

            //se muestra el paciente.
            $this->parseEntidad($xtpl, $oPaciente);
        }

        $xtpl->assign('titulo', 'Detalle de Paciente');
        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    protected function getTitulo() {
        return "Ver Paciente";
    }

    public function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_VER_PACIENTE);
    }

    public function parseEntidad($xtpl, $oPaciente) {

        $xtpl->assign('cd_paciente', stripslashes($oPaciente->getCd_paciente()));
        $xtpl->assign('cd_paciente_label', RYT_PACIENTE_CD_PACIENTE);

        $xtpl->assign('ds_apynom', stripslashes($oPaciente->getDs_apynom()));
        $xtpl->assign('ds_apynom_label', RYT_PACIENTE_DS_APYNOM);

        $xtpl->assign('ds_tipodoc', stripslashes($oPaciente->getTipodoc()->getDs_tipodocumento()));
        $xtpl->assign('cd_tipodoc_label', RYT_PACIENTE_CD_TIPODOC);

        $xtpl->assign('nu_doc', stripslashes($oPaciente->getNu_doc()));
        $xtpl->assign('nu_doc_label', RYT_PACIENTE_NU_DOC);

        $xtpl->assign('ds_direccion', stripslashes($oPaciente->getDs_direccion()));
        $xtpl->assign('ds_direccion_label', RYT_PACIENTE_DS_DIRECCION);

        $xtpl->assign('ds_telefono', stripslashes($oPaciente->getDs_telefono()));
        $xtpl->assign('ds_telefono_label', RYT_PACIENTE_DS_TELEFONO);

        $xtpl->assign('ds_email', stripslashes($oPaciente->getDs_email()));
        $xtpl->assign('ds_email_label', RYT_PACIENTE_DS_EMAIL);

        $this->parseObrassociales($oPaciente->getCd_paciente(), $xtpl);
    }

    protected function parseObrassociales($cd_paciente, XTemplate $xtpl) {
        $manager = new PacienteobrasocialManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("cd_paciente", $cd_paciente, "=");
        $pacientesobrassociales = $manager->getPacientesobrasociales($criterio);
        foreach ($pacientesobrassociales as $key => $oPacienteObrasocial) {
            $xtpl->assign('ds_obrasocial', $oPacienteObrasocial->getObrasocial()->getDs_obrasocial());
            $xtpl->parse('main.pacientesobrassociales');
        }
    }

}
