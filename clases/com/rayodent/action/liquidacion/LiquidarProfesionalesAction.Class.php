<?php

/**
 * Acción listar movcajas.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class LiquidarProfesionalesAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new LiquidarProfesionalTableModel($items);
    }

    protected function getOpciones() {
        $opciones = array();
        return $opciones;
    }

    protected function getFiltros() {

        $filtros = array();

        return $filtros;
    }

    protected function getUrlAccionExportarExcel() {
        return 'excel_liquidacion_profesionales';
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_practicaordenpractica(), 'practicaordenpractica', 'practicaordenpractica', true, false, false);
    }

    protected function getEntidadManager() {
        return new PracticaordenpracticaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'POP.cd_practicaordenpractica';
    }

    protected function getTitulo() {
        return 'Liquidaci&oacute;n de profesionales';
    }

    protected function getUrlAccionListar() {
        return 'liquidar_profesional';
    }

    protected function getForwardError() {
        return 'liquidar_profesional_error';
    }

    protected function getMenuActivo() {
        return "Liquidacion";
    }

    //Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LIQUIDACION_PROFESIONALES);
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:01");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_profesional = FormatUtils::getParam('cd_profesional');
        $ds_profesional = urldecode(FormatUtils::getParam('ds_profesional'));
        $valor = addslashes(FormatUtils::getParam('valor', ''));
        $tipo = addslashes(FormatUtils::getParam('tipo', 'p'));

        $xtpl->assign('dt_inicio_filtro', $dt_inicio_filtro);
        $xtpl->assign('dt_fin_filtro', $dt_fin_filtro);
        $xtpl->assign('hs_inicio_filtro', $hs_inicio_filtro);
        $xtpl->assign('hs_fin_filtro', $hs_fin_filtro);
        $xtpl->assign('ds_profesional', stripslashes($ds_profesional));
        $xtpl->assign('cd_profesional', $cd_profesional);
        $xtpl->assign('valor', $valor);
        if ($tipo == "f") {
            $xtpl->assign('checked_f', "checked");
        } elseif ($tipo == "p") {
            $xtpl->assign('checked_p', "checked");
        }

        $xtpl->parse('main');
        return $xtpl->text('main');
    }

    /**
     * se obtienen los<filtros especiales para pasar por get (url)
     * @param $xtpl
     */
    protected function getFiltrosEspecialesQueryString() {
        $filtros = "";
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $ds_profesional = FormatUtils::getParam('ds_profesional', "");
        $valor = addslashes(FormatUtils::getParam('valor', ''));
        $tipo = addslashes(FormatUtils::getParam('tipo', ''));

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&cd_profesional=$cd_profesional&ds_profesional=$ds_profesional&valor=$valor&tipo=$tipo";
        return $filtros;
    }

    protected function getURLQueryString() {
        $filtros = "";
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $valor = addslashes(FormatUtils::getParam('valor', ''));
        $tipo = addslashes(FormatUtils::getParam('tipo', ''));

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&cd_profesional=$cd_profesional&valor=$valor&tipo=$tipo";
        return $filtros;
    }

    protected function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        //obtenemos las entidades a mostrar.
        $criterio = new CriterioBusqueda();
        //$criterio->put('campoFiltro', $campoFiltro);
        //$criterio->put('filtro', $filtro);
        //$this->addSelectedFiltro($criterio, $campoFiltro, $filtro);

        $new_criterio = new CriterioBusqueda();
        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $ds_profesional = FormatUtils::getParam('ds_profesional', "");

        if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
            $dt_inicio_filtro .=$hs_inicio_filtro;
            $criterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        }
        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
            $dt_fin_filtro .=$hs_fin_filtro;

            $criterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
        }

        $criterio->addFiltro('OP.cd_profesional', $cd_profesional, "=");
        $criterio->addFiltro('MC.bl_anulacion', "0", "=");

        $criterio->addFiltro("POP.cd_liquidacionprofesional", "0", "=");

        $criterio->setPage($page);
        $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
    }

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_LISTAR_LIQUIDACION_PROFESIONALES);
    }

    protected function parseContenido(XTemplate $xtpl, $filtro, $oPaginador, $query_string, $entidades, CriterioBusqueda $criterio) {
        $new_criterio = new CriterioBusqueda();
        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_profesional = FormatUtils::getParam('cd_profesional', "0");
        $ds_profesional = FormatUtils::getParam('ds_profesional', "");

        if ($dt_inicio_filtro != '' && $hs_inicio_filtro != "") {
            $hs_inicio_filtro = implode(explode(":", $hs_inicio_filtro)) . "01";
            $dt_inicio_filtro = FuncionesComunes::fechaPHPaMysql($dt_inicio_filtro);
            $dt_inicio_filtro .=$hs_inicio_filtro;
            $new_criterio->addFiltro('dt_movcaja', $dt_inicio_filtro, ">=");
        }
        if ($dt_fin_filtro != '' && $hs_fin_filtro != "") {
            $hs_fin_filtro = implode(explode(":", $hs_fin_filtro)) . "59";
            $dt_fin_filtro = FuncionesComunes::fechaPHPaMysql($dt_fin_filtro);
            $dt_fin_filtro .=$hs_fin_filtro;

            $new_criterio->addFiltro('dt_movcaja', $dt_fin_filtro, "<=");
        }
        $new_criterio->addFiltro('OP.cd_profesional', $cd_profesional, "=");
        $new_criterio->addFiltro('MC.bl_anulacion', "0", "=");
        //$new_criterio->addFiltro("POP.cd_liquidacionprofesional", "IS NULL", " ");
         $criterio->addFiltro("POP.cd_liquidacionprofesional", "0", "=");

        $valor = addslashes(FormatUtils::getParam('valor', ''));
        $tipo = addslashes(FormatUtils::getParam('tipo', ''));
        $oPracticaordenpracticaManager = new PracticaOrdenpracticaManager();
        $monto = round($oPracticaordenpracticaManager->getTotalALiquidar($new_criterio, $valor, $tipo), 2);


        $xtpl->assign('total', $monto);
        return parent::parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);
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

        $url_alta_liquidacionprofesional = ("doAction?action=alta_liquidacionprofesional&" . $this->getURLQueryString());

        $xtpl->assign('url_alta_liquidacionprofesional', $url_alta_liquidacionprofesional);

        $xtpl->assign('query_excel', urldecode($this->getURLQueryString()));
        $valor = addslashes(FormatUtils::getParam('valor', '0'));
        $tipo = addslashes(FormatUtils::getParam('tipo', 'f'));

        //obtenemos los elementos a mostrar.
        $criterio = $this->getCriterioBusqueda();

        try {
            $entidades = $this->getEntidadManager()->getPracticaordenpracticasDeLiquidacion($criterio, $valor, $tipo);
            $num_rows = $this->getEntidadManager()->getCantidadEntidades($criterio);
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

