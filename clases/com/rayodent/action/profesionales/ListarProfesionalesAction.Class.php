<?php

/**
 * Acción listar profesionales.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ListarProfesionalesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new ProfesionalTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaprofesional', 'Agregar Profesional', 'alta_profesional_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_profesional', RYT_PROFESIONAL_CD_PROFESIONAL);
				
		$filtros[] = $this->buildFiltro('TD.ds_tipodocumento', RYT_PROFESIONAL_CD_TIPODOCUMENTO);
				
		$filtros[] = $this->buildFiltro('nu_documento', RYT_PROFESIONAL_NU_DOCUMENTO);
				
		$filtros[] = $this->buildFiltro('ds_nombre', RYT_PROFESIONAL_DS_NOMBRE);
				
		$filtros[] = $this->buildFiltro('nu_matricula', RYT_PROFESIONAL_NU_MATRICULA);
				
		$filtros[] = $this->buildFiltro('ds_domicilio', RYT_PROFESIONAL_DS_DOMICILIO);
				
		$filtros[] = $this->buildFiltro('ds_telefono', RYT_PROFESIONAL_DS_TELEFONO);
				
		$filtros[] = $this->buildFiltro('ds_email', RYT_PROFESIONAL_DS_EMAIL);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_profesional(), 'profesional', 'profesional', true, true, true);
    }


    protected function getEntidadManager() {
        return new ProfesionalManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_profesional';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Profesionales';
    }

    protected function getUrlAccionListar() {
        return 'listar_profesionales';
    }

    protected function getForwardError() {
        return 'listar_profesionales_error';
    }

    protected function getMenuActivo() {
        return "Profesionales";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_PROFESIONAL);
        $xtpl->assign('cd_profesional', $entidad->getCd_profesional());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
