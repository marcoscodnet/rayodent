<?php

/**
 * Acci�n para visualizar un paciente.
 *  
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ListarPracticasPacienteAction extends OutputAction {

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

       

        $xtpl->assign('ds_apynom', stripslashes($oPaciente->getDs_apynom()));
       

        $xtpl->assign('ds_tipodoc', stripslashes($oPaciente->getTipodoc()->getDs_tipodocumento()));
       

        $xtpl->assign('nu_doc', stripslashes($oPaciente->getNu_doc()));
       
        $this->parsePracticas($oPaciente->getCd_paciente(), $xtpl);
    }

    protected function parsePracticas($cd_paciente, XTemplate $xtpl) {
        $manager = new MovcajaManager();
        $criterio = new CriterioBusqueda();
        $criterio->addFiltro("OP.cd_paciente", $cd_paciente, "=");
        $criterio->addOrden("dt_movcaja", "DESC");
        $movcajas = $manager->getListadoMovcajas($criterio);
        $nu_total = 0;
        foreach ($movcajas as $oMovCaja) {
            $xtpl->assign('dt_movcaja', FuncionesComunes::fechaHoraMysqlaPHP($oMovCaja->getDt_movcaja()));
            $xtpl->assign('ds_detalle', ($oMovCaja->getDs_detalle()));
            $xtpl->assign('nu_importe', ($oMovCaja->getNu_total()));
            
            	//$nu_total +=($oMovCaja->getNu_total());
            $xtpl->parse('main.movscajas_conceptos');
        }
        $xtpl->assign('nu_total', $nu_total);
    }
    
	protected function getLayout() {
        return new LayoutSimpleAjax();
    }

}
