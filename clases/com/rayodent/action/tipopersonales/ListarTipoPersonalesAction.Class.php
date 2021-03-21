<?php

/**
 * Acción listar tipoPersonales.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ListarTipoPersonalesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new TipoPersonalTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altatipoPersonal', 'Agregar tipo de empleado', 'alta_tipopersonal_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_tipopersonal', RYT_TIPOPERSONAL_CD_TIPOPERSONAL);
				
		$filtros[] = $this->buildFiltro('ds_tipopersonal', RYT_TIPOPERSONAL_DS_TIPOPERSONAL);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_tipopersonal(), 'tipopersonal', 'tipopersonal', true, true, true);
    }


    protected function getEntidadManager() {
        return new TipoPersonalManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_tipopersonal';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Tipo de Empleados';
    }

    protected function getUrlAccionListar() {
        return 'listar_tipopersonales';
    }

    protected function getForwardError() {
        return 'listar_tipopersonales_error';
    }

    protected function getMenuActivo() {
        return "TipoPersonales";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_TIPOPERSONAL);
        $xtpl->assign('cd_tipopersonal', $entidad->getCd_tipopersonal());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
