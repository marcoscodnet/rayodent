<?php

/**
 * Acción listar movcajas.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class LiquidarAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new LiquidacionTableModel($items);
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
        return 'excel_liquidacion';
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_movcaja(), 'movcaja', 'movcaja', true, false, false);
    }

    protected function getEntidadManager() {
        return new MovcajaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'MC.cd_movcaja';
    }

    protected function getTitulo() {
        return 'Liquidaci&oacute;n';
    }

    protected function getUrlAccionListar() {
        return 'liquidar';
    }

    protected function getForwardError() {
        return 'liquidar_error';
    }

    protected function getMenuActivo() {
        return "Liquidacion";
    }

    protected function getCartelEliminar($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_BAJA_MOVCAJA);
        $xtpl->assign('cd_movcaja', $entidad->getCd_movcaja());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    protected function getCartelAnular($entidad) {
        $xtpl = new XTemplate(RYT_TEMPLATE_ANULAR_MOVCAJA);
        $xtpl->assign('cd_movcaja', $entidad->getCd_movcaja());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

    //Filtros especiales
    protected function getFiltrosEspeciales() {
        $xtpl = new XTemplate(RYT_FILTRO_LIQUIDACION);

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial');
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial');
    
        $xtpl->assign('dt_inicio_filtro', $dt_inicio_filtro);
        $xtpl->assign('dt_fin_filtro', $dt_fin_filtro);
        $xtpl->assign('hs_inicio_filtro', $hs_inicio_filtro);
        $xtpl->assign('hs_fin_filtro', $hs_fin_filtro);
        $xtpl->assign('ds_obrasocial', $ds_obrasocial);
        $xtpl->assign('cd_obrasocial', $cd_obrasocial);


        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
        //Si es Admin, muestro el listado de cajas

        $nu_caja_get = FormatUtils::getParam('nu_caja');

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
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "0");
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial', "");

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&cd_obrasocial=$cd_obrasocial&ds_obrasocial=$ds_obrasocial";
        return $filtros;
    }

    protected

    function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        //obtenemos las entidades a mostrar.
        $criterio = new CriterioBusqueda();
              
        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "0");
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial', "");

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

        $criterio->addFiltro('POS.cd_obrasocial', $cd_obrasocial, "=");
        $criterio->addFiltro('MC.bl_anulacion', "0", "=");

        $criterio->addOrden($campoOrden, $orden);
        $criterio->setPage($page);
        $criterio->setRowPerPage(ROW_PER_PAGE);
        return $criterio;
    }

    protected function getContenido() {

        $xtpl = $this->getXTemplate();
        $xtpl->assign('WEB_PATH', WEB_PATH);

        //recuperamos los parï¿½metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $cd_obrasocial = urldecode(FormatUtils::getParam('cd_obrasocial'));

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

        $xtpl->assign('query_string', $this->getFiltrosEspecialesQueryString());
        $xtpl->assign('query_excel', $this->getURLQueryString());
        //obtenemos los elementos a mostrar.
        $criterio = $this->getCriterioBusqueda();

        try {

            $entidades = $this->getEntidadManager()->getMovcajasDeLiquidacionParaOS($criterio, $cd_obrasocial);
            $num_rows = $this->getEntidadManager()->getCantidadMovcajasDeLiquidacion($criterio);
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

    protected function getXTemplate() {
        return new XTemplate(RYT_TEMPLATE_LISTAR_LIQUIDACION);
    }

    protected function parseContenido(XTemplate $xtpl, $filtro, $oPaginador, $query_string, $entidades, CriterioBusqueda $criterio) {
        $criterio = new CriterioBusqueda();

        $new_criterio = new CriterioBusqueda();
        //Filtro Especial
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', "");
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro', "");
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', "00:00");
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "0");
        $ds_obrasocial = FormatUtils::getParam('ds_obrasocial', "");

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


        $criterio->addFiltro('POS.cd_obrasocial', $cd_obrasocial, "=");
        $criterio->addFiltro('CA.bl_anulacion', "0", "=");

        $oMovCajaManager = new MovcajaManager();
        $monto = $oMovCajaManager->getMontoTotalDeObraSocial($criterio);


        $xtpl->assign('total', $monto);
        return parent::parseContenido($xtpl, $filtro, $oPaginador, $query_string, $entidades, $criterio);
    }

    protected function getURLQueryString() {
        $filtros = "";
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro');
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro');
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro');
        $cd_obrasocial = FormatUtils::getParam('cd_obrasocial', "0");

        $filtros .= "&dt_inicio_filtro=$dt_inicio_filtro&dt_fin_filtro=$dt_fin_filtro&hs_inicio_filtro=$hs_inicio_filtro&hs_fin_filtro=$hs_fin_filtro&cd_obrasocial=$cd_obrasocial";
        return $filtros;
    }

}

