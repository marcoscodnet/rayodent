<?php

/**
 * Acci�n listar medios.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class ListarMediosAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new MedioTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altamedio', 'Agregar Medio', 'alta_medio_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

		$filtros[] = $this->buildFiltro('cd_medio', RYT_MEDIO_CD_MEDIO);

		$filtros[] = $this->buildFiltro('ds_medio', RYT_MEDIO_DS_MEDIO);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_medio(), 'medio', 'medio', true, true, true);
    }


    protected function getEntidadManager() {
        return new MedioManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_medio';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Medios';
    }

    protected function getUrlAccionListar() {
        return 'listar_medios';
    }

    protected function getForwardError() {
        return 'listar_medios_error';
    }

    protected function getMenuActivo() {
        return "Medios";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_MEDIO);
        $xtpl->assign('cd_medio', $entidad->getCd_medio());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
