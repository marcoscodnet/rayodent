<?php

/**
 * Acción listar practicaordenpracticas.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ListarPracticaordenpracticasAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new PracticaordenpracticaTableModel($items);
    }

    protected function getOpciones() {
        $opciones = array();
        //$opciones[] = $this->buildOpcion('altapracticaordenpractica', 'Agregar Practicaordenpractica', 'alta_practicaordenpractica_init');
        return $opciones;
    }

    protected function getFiltros() {
        $filtros = array();
        $filtros[] = $this->buildFiltro('OP.cd_ordenpractica', RYT_PRACTICAORDENPRACTICA_CD_ORDENPRACTICA);
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        $this->parseAccionesDefault($xtpl, $item, $item->getCd_practicaordenpractica(), 'practicaordenpractica', 'practicaordenpractica', false, true, true);
    }

    protected function parseAccionesDefault(XTemplate $xtpl, $entidad, $id, $nombre_entidad, $lbl_entidad=null, $ver=true, $modificar=true, $imprimir=true) {

        if (empty($lbl_entidad))
            $lbl_entidad = $nombre_entidad;

        if ($ver) {
            $href = 'doAction?action=ver_' . $nombre_entidad . '&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'search.gif', 'detalles de ' . $lbl_entidad);
        }

        if ($modificar) {
            $href = 'doAction?action=modificar_' . $nombre_entidad . '_init&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'edit.gif', 'editar datos de ' . $lbl_entidad);
        }
       
        if ($imprimir && $entidad->getInforme()->getCd_informe() != "") {
            $href = 'doAction?action=pdf_informe_practicaordenpractica&id=' . $id;
            $this->parseAccion($xtpl, '', $href, 'print.gif', 'Imprimir Informe');
        }
    }

    protected function getEntidadManager() {
        return new PracticaordenpracticaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'OP.cd_ordenpractica';
    }

    protected function getTitulo() {
        return 'Carga de informes';
    }

    protected function getUrlAccionListar() {
        return 'listar_practicaordenpracticas';
    }

    protected function getForwardError() {
        return 'listar_practicaordenpracticas_error';
    }

    protected function getMenuActivo() {
        return "Practicaordenpracticas";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_PRACTICAORDENPRACTICA);
        $xtpl->assign('cd_practicaordenpractica', $entidad->getCd_practicaordenpractica());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    protected function getContenido() {

        $xtpl = $this->getXTemplate();
        $xtpl->assign('WEB_PATH', WEB_PATH);

        //recuperamos los parï¿½metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));

        $page = $this->getPagePaginacion();

        $orden = FormatUtils::getParam('orden', 'DESC');

        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());
        $xtpl->assign('campoOrden', $campoOrden);
        $xtpl->assign('accion_listar', $this->getUrlAccionListar());
        $xtpl->assign('orden', $orden);
        $xtpl->assign('campoFiltro', $campoFiltro);
        $xtpl->assign('filtro', $filtro);

        //tï¿½tulo del listado.
        $xtpl->assign('titulo', $this->getTituloListado());

        //armamos el query string (para la paginaciï¿½n y la ordenaciï¿½n).
        $query_string = $this->getQueryString($filtro, $campoFiltro) . "id=" . FormatUtils::getParam('id') . $this->getFiltrosEspecialesQueryString() . "&";

        //obtenemos los elementos a mostrar.
        $criterio = $this->getCriterioBusqueda();

        try {

            $entidades = $this->getEntidadManager()->getPracticaordenpracticasTablemodel($criterio);
            $num_rows = $this->getEntidadManager()->getCantPracticaordenpracticasTableModel($criterio);
        } catch (GenericException $ex) {
            //capturamos la excepción para terminar de parsear el contenido y luego la volvemos a lanzar para mostrar el error.
            $entidades = new ItemCollection();
            $num_rows = 0;
            $this->getLayoutInstance()->setException($ex);
        }


        $this->tableModel = $this->getListarTableModel($entidades);

        //construimos el paginador.
        $oPaginador = $this->getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $page);

        //generamos el contenido.
        $content = $this->parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);

        return $content;
    }

}
