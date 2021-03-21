<?php

class BuscarPracticasObrasSocialesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new PracticaobrasocialTableModel($items);
    }

    protected function getOpciones() {
        $opciones = array();
        return $opciones;
    }

    protected function getFiltros() {
        $filtros = array();
        $filtros[] = $this->buildFiltro('P.ds_practica', RYT_PRACTICAOBRASOCIAL_CD_PRACTICA);
        $filtros[] = $this->buildFiltro('nu_practicaos', RYT_PRACTICAOBRASOCIAL_NU_PRACTICAOS);
        $filtros[] = $this->buildFiltro('dt_vigencia', RYT_PRACTICAOBRASOCIAL_DT_VIGENCIA);
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {
        $xtpl->assign('cd_practicaobrasocial', $item->getCd_practicaobrasocial());
        $xtpl->assign('nu_practicaos', $item->getNu_practicaos() . "  (" . $item->getPractica()->getDs_practica() . ")");
        $xtpl->assign('nu_importe', $item->getNu_importe());

        $xtpl->parse("main.row.accion");
    }

    protected function getEntidadManager() {
        return new PracticaobrasocialManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_practicaobrasocial';
    }

    protected function getTitulo() {
        return 'Buscar Practicas';
    }

    protected function getUrlAccionListar() {
        return 'buscar_practicasobrassociales';
    }

    protected function getForwardError() {
        return 'listar_pacientes_error';
    }

    protected function getMenuActivo() {
        return "Pacientes";
    }

    protected function getLayout() {
        return new LayoutSimpleAjax();
    }

    protected function getXTemplate() {
        if ($this->isAjax() && (isset($_GET['filtro']) || isset($_GET['page']))) {
            return new XTemplate(RYT_BUSCAR_PRATICASOBRASSOCIALES_RTA_AJAX);
        } else {
            return new XTemplate(RYT_BUSCAR_PRATICASOBRASSOCIALES);
        }
    }

    protected function isAjax() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    protected function getCriterioBusqueda() {
        //recuperamos los par�metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $criterio = new CriterioBusqueda();


        $this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        //Siempre tomo el id de la obra social que viene por get
        $id = FormatUtils::getParam('id', '0');
        $criterio->addFiltro("PO.cd_obrasocial", $id, "=");
        $criterio->addFiltro('PO.dt_vigencia', "(SELECT MAX(dt_vigencia) FROM practicaobrasocial POS WHERE POS.cd_practica = PO.cd_practica AND POS.cd_obrasocial = PO.cd_obrasocial)", "=");
		//$criterio->addFiltro("PO.dt_vigencia",FuncionesComunes::fechaPHPaMysql(date('d/m/Y')), ">=", new FormatValorString());
        
        $criterio->addFiltro("P.bl_activa", 1, "=");
		$criterio->addFiltro("PO.bl_activa", 1, "=");
        $criterio->addOrden($campoOrden, $orden);
        $criterio->setPage($page);
        $criterio->setRowPerPage(ROW_PER_PAGE_LISTADO_POPUP);
        return $criterio;
    }

    protected function getPaginador($num_rows, $orden, $campoFiltro, $filtro, $campoOrden, $page) {
        $num_pages = ceil($num_rows / ROW_PER_PAGE_LISTADO_POPUP);

        //$url = 'index.php?orden=' . $orden . '&campo=' . $campo . '&filtro=' . $filtro;
        $id = FormatUtils::getParam('id', '0');
        $filtro .= "&id=$id"; 

        $url = $this->getUrlPaginador($orden, $campoFiltro, $filtro, $campoOrden);
        $cssclassotherpage = 'paginadorOtraPagina';
        $cssclassactualpage = 'paginadorPaginaActual';
        $ds_pag_anterior = 0; //$gral['pag_ant'];
        $ds_pag_siguiente = 2; //$gral['pag_sig'];
        return new Paginador($url, $num_pages, $page, $cssclassotherpage, $cssclassactualpage, $num_rows);
    }

    protected function parseContenido(XTemplate $xtpl, $filtro, $oPaginador, $query_string, $entidades, CriterioBusqueda $criterio) {

        $xtpl->assign('txt_filtro', $filtro);

        //paginaci�n.
        $xtpl->assign('resultado', $oPaginador->imprimirResultados());
        $xtpl->parse('main.resultado');

        $xtpl->assign('PAG', $oPaginador->imprimirPaginadoConAjax("listado_practicasobrassociales"));
        $xtpl->parse('main.PAG');

        //botones sobre el listado.
        $excel = $this->getUrlAccionExportarExcel();
        if (!empty($excel)) {
            $xtpl->assign('accion_excel', $excel);
            $xtpl->parse('main.export_excel');
        }

        $pdf = $this->getUrlAccionExportarPdf();
        if (!empty($pdf)) {
            $xtpl->assign('accion_pdf', $pdf);
            $xtpl->parse('main.export_pdf');
        }

        $this->parseOpciones($xtpl);

        //filtros de b�squeda
        if (isset($_GET ['campoFiltro']))
            $campoFiltro = FormatUtils::getParam('campoFiltro');
        else
            $campoFiltro = $this->getCampoFiltroDefault();
        $this->parseOpcionesFiltro($xtpl, $campoFiltro);

        $this->parseFiltrosEspeciales($xtpl);
        $id = FormatUtils::getParam('id', '0');
        $xtpl->assign('cd_obrasocial', $id);

        //si se mostraron filtros, parseamos para que se vean.
        if ($this->hayFiltros)
            $xtpl->parse('main.botones_tabla');


        //manejo de errores.
        $this->parseErrores($xtpl);

        //header del listado.
        $this->parseHeader($xtpl, $entidades, $criterio);

        //encabezados (ths) de la tabla.
        $this->parseTHs($xtpl, $query_string);

               
        //se parsean los elementos a mostrar
        $this->parseRows($xtpl, $entidades);

        //footer del listado.
        $this->parseFooter($xtpl, $entidades, $criterio);

        $xtpl->parse('main');
        return $xtpl->text('main');
    }

}
