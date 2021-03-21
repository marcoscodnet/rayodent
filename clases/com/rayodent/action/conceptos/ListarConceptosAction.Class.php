<?php

/**
 * Acción listar conceptos.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ListarConceptosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new ConceptoTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaconcepto', 'Agregar Concepto', 'alta_concepto_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        $filtros[] = $this->buildFiltro('TC.ds_tipoconcepto', RYT_CONCEPTO_CD_TIPOCONCEPTO);

        $filtros[] = $this->buildFiltro('T_O.ds_tipooperacion', RYT_CONCEPTO_CD_TIPOOPERACION);

        $filtros[] = $this->buildFiltro('ds_concepto', RYT_CONCEPTO_DS_CONCEPTO);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        if ($item->getTipoconcepto()->getBl_oculto() == 1 || $item->getCd_concepto() == CD_CONCEPTO_PRACTICA_PARTICULAR) {
            $this->parseAccionesDefault($xtpl, $item, $item->getCd_concepto(), 'concepto', 'concepto', true, false, false);
        } else {
            $this->parseAccionesDefault($xtpl, $item, $item->getCd_concepto(), 'concepto', 'concepto', true, true, true);
        }
    }

    protected function getEntidadManager() {
        return new ConceptoManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_concepto';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Conceptos';
    }

    protected function getUrlAccionListar() {
        return 'listar_conceptos';
    }

    protected function getForwardError() {
        return 'listar_conceptos_error';
    }

    protected function getMenuActivo() {
        return "Conceptos";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_CONCEPTO);
        $xtpl->assign('cd_concepto', $entidad->getCd_concepto());
        $xtpl->assign('ds_concepto', $entidad->getDs_concepto());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
