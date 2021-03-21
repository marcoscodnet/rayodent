<?php

/**
 * Acción listar obrasociales.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ListarObrasocialesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new ObrasocialTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaobrasocial', 'Agregar Obra Social', 'alta_obrasocial_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        $filtros[] = $this->buildFiltro('cd_obrasocial', RYT_OBRASOCIAL_CD_OBRASOCIAL);

        $filtros[] = $this->buildFiltro('ds_obrasocial', RYT_OBRASOCIAL_DS_OBRASOCIAL);
        
        $filtros[] = $this->buildFiltro('bl_activa', RYT_OBRASOCIAL_BL_ACTIVA);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        if ($item->getCd_obrasocial() == CD_OBRASOCIAL_PARTICULAR) {
            $this->parseAccionesDefault($xtpl, $item, $item->getCd_obrasocial(), 'obrasocial', 'obrasocial', true, false, false);
        } else {
            $this->parseAccionesDefault($xtpl, $item, $item->getCd_obrasocial(), 'obrasocial', 'obrasocial', true, true, true);
        }
    }

    protected function getEntidadManager() {
        return new ObrasocialManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_obrasocial';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Obras Sociales';
    }

    protected function getUrlAccionListar() {
        return 'listar_obrasociales';
    }

    protected function getForwardError() {
        return 'listar_obrasociales_error';
    }

    protected function getMenuActivo() {
        return "Obrasociales";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_OBRASOCIAL);
        $xtpl->assign('cd_obrasocial', $entidad->getCd_obrasocial());
        $xtpl->assign('ds_obrasocial', $entidad->getDs_obrasocial());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
