<?php

/**
 * Acción listar practicaobrasociales.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ListarPracticaobrasocialesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new PracticaobrasocialTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altapracticaobrasocial', 'Agregar nomenclador', 'alta_practicaobrasocial_init');
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();
        $filtros[] = $this->buildFiltro('P.ds_practica', RYT_PRACTICAOBRASOCIAL_CD_PRACTICA);

        $filtros[] = $this->buildFiltro('O.ds_obrasocial', RYT_PRACTICAOBRASOCIAL_CD_OBRASOCIAL);

        $filtros[] = $this->buildFiltro('nu_practicaos', RYT_PRACTICAOBRASOCIAL_NU_PRACTICAOS);

        $filtros[] = $this->buildFiltro('dt_vigencia', RYT_PRACTICAOBRASOCIAL_DT_VIGENCIA);

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        $this->parseAccionesDefault($xtpl, $item, $item->getCd_practicaobrasocial(), 'practicaobrasocial', 'practicaobrasocial', true, true, true);
    }

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $eliminar=true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;

        if ($ver) {
            $href = 'doAction?action=ver_' . $nombre_entidad . '&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'search.gif', 'detalles de ' . $lbl_entidad);
        }

        if ($modificar) {
            $href = 'doAction?action=modificar_' . $nombre_entidad . '_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'repeat.png', 'editar datos de ' . $lbl_entidad);
        }

        if ($eliminar) {
            $onclick = "javascript: confirmaEliminar('" . $this->getCartelEliminar($entidad) . "', this,'doAction?action=eliminar_" . $nombre_entidad . "&id=" . $id . "'); return false;";
            $this->parseAccion($xtpl, $onclick, '', 'del.gif', 'eliminar ' . $lbl_entidad);
        }
    }

    protected function getEntidadManager() {
        return new PracticaobrasocialManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_practicaobrasocial';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Nomencladores';
    }

    protected function getUrlAccionListar() {
        return 'listar_practicaobrasociales';
    }

    protected function getForwardError() {
        return 'listar_practicaobrasociales_error';
    }

    protected function getMenuActivo() {
        return "Practicaobrasociales";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_PRACTICAOBRASOCIAL);
        $xtpl->assign('cd_practicaobrasocial', $entidad->getCd_practicaobrasocial());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LISTAR_NOMENCLADORES);

        $list_all = FormatUtils::getParam('list_all');
        if ($list_all == '1')
            $xtpl->assign('checked', "checked='checked'");

        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    /**
     * se obtienen los<filtros especiales para pasar por get (url)
     * @param $xtpl
     */
    protected function getFiltrosEspecialesQueryString() {
        $filtros = "";
        $list_all = FormatUtils::getParam('list_all', '');
        if ($chk_aprobadas != '')
            $filtros .= "&list_all=$list_all";
        return $filtros;
    }

    protected function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());



        //obtenemos las entidades a mostrar.
        $criterio = new CriterioBusqueda();
        //$criterio->put('campoFiltro', $campoFiltro);
        //$criterio->put('filtro', $filtro);

        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);


        //Filtro Especial
        $list_all = FormatUtils::getParam('list_all');
        if ($list_all != '1' && $list_all != 1) {
            $new_criterio = new CriterioBusqueda();
            $this->addSelectedFiltro($new_criterio, $campoFiltro, $filtro);
            $criterio->addFiltro('dt_vigencia', "(SELECT MAX(dt_vigencia) FROM practicaobrasocial POS WHERE POS.cd_practica = PO.cd_practica AND POS.cd_obrasocial = PO.cd_obrasocial)", "=");
        }

        $criterio->addOrden($campoOrden, $orden);
        $criterio->setPage($page);
        $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
    }

}
