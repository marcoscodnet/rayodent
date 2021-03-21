<?php

/**
 * Acción listar tipoconceptos.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ListarTipoconceptosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new TipoconceptoTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altatipoconcepto', 'Agregar Tipo de concepto', 'alta_tipoconcepto_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        $filtros[] = $this->buildFiltro('cd_tipoconcepto', RYT_TIPOCONCEPTO_CD_TIPOCONCEPTO);

        $filtros[] = $this->buildFiltro('ds_tipoconcepto', RYT_TIPOCONCEPTO_DS_TIPOCONCEPTO);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        if (($item->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_PRACTICA) || ($item->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_BONO) || ($item->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_REINTEGRO)|| ($item->getCd_tipoconcepto() == CD_TIPO_CONCEPTO_GASTOS)) {
            $this->parseAccionesDefault($xtpl, $item, $item->getCd_tipoconcepto(), 'tipoconcepto', 'tipoconcepto', true, false, false);
        } else {
            $this->parseAccionesDefault($xtpl, $item, $item->getCd_tipoconcepto(), 'tipoconcepto', 'tipoconcepto', true, true, true);
        }
    }

    protected function getEntidadManager() {
        return new TipoconceptoManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_tipoconcepto';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Tipo de conceptos';
    }

    protected function getUrlAccionListar() {
        return 'listar_tipoconceptos';
    }

    protected function getForwardError() {
        return 'listar_tipoconceptos_error';
    }

    protected function getMenuActivo() {
        return "Tipoconceptos";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_TIPOCONCEPTO);
        $xtpl->assign('cd_tipoconcepto', $entidad->getCd_tipoconcepto());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    protected function addSelectedFiltro($criterio, $campoFiltro, $filtro) {
        $criterio->addFiltro("bl_oculto", 0, "=");

        if (substr($campoFiltro, 0, 3) == 'dt_') {
            if (!empty($filtro))
                $criterio->addFiltro($campoFiltro, $filtro, '=', new FormatValorDate());
        }
        else
            $criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLike());
    }

}
