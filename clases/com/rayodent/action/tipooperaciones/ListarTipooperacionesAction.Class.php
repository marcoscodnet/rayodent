<?php

/**
 * Acción listar tipooperaciones.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ListarTipooperacionesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new TipooperacionTableModel($items);
    }

    protected function getOpciones() {
        $opciones = array();
        // $opciones[] = $this->buildOpcion('altatipooperacion', 'Agregar Tipo de operaci&oacute;n', 'alta_tipooperacion_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        $filtros[] = $this->buildFiltro('cd_tipooperacion', RYT_TIPOOPERACION_CD_TIPOOPERACION);

        $filtros[] = $this->buildFiltro('ds_tipooperacion', RYT_TIPOOPERACION_DS_TIPOOPERACION);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_tipooperacion(), 'tipooperacion', 'tipooperacion', true, false, false);
    }

    protected function getEntidadManager() {
        return new TipooperacionManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_tipooperacion';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Tipo de operaciones';
    }

    protected function getUrlAccionListar() {
        return 'listar_tipooperaciones';
    }

    protected function getForwardError() {
        return 'listar_tipooperaciones_error';
    }

    protected function getMenuActivo() {
        return "Tipooperaciones";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_TIPOOPERACION);
        $xtpl->assign('cd_tipooperacion', $entidad->getCd_tipooperacion());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
