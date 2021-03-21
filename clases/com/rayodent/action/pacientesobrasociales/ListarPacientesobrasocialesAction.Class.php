<?php

/**
 * Acción listar pacientesobrasociales.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ListarPacientesobrasocialesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new PacienteobrasocialTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altapacienteobrasocial', 'Agregar Pacienteobrasocial', 'alta_pacienteobrasocial_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_pacienteobrasocial', RYT_PACIENTEOBRASOCIAL_CD_PACIENTEOBRASOCIAL);
				
		$filtros[] = $this->buildFiltro('cd_paciente', RYT_PACIENTEOBRASOCIAL_CD_PACIENTE);
				
		$filtros[] = $this->buildFiltro('cd_obrasocial', RYT_PACIENTEOBRASOCIAL_CD_OBRASOCIAL);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_pacienteobrasocial(), 'pacienteobrasocial', 'pacienteobrasocial', true, true, true);
    }


    protected function getEntidadManager() {
        return new PacienteobrasocialManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_pacienteobrasocial';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Pacientesobrasociales';
    }

    protected function getUrlAccionListar() {
        return 'listar_pacientesobrasociales';
    }

    protected function getForwardError() {
        return 'listar_pacientesobrasociales_error';
    }

    protected function getMenuActivo() {
        return "Pacientesobrasociales";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_PACIENTEOBRASOCIAL);
        $xtpl->assign('cd_pacienteobrasocial', $entidad->getCd_pacienteobrasocial());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
