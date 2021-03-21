<?php

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelMovcajasAction extends ExportExcelCollectionAction {

    protected function getIListar() {
        return new MovcajaManager();
    }

    protected function getTableModel(ItemCollection $items) {
        return new MovcajaTableModel($items);
    }

    protected function getCampoOrdenDefault() {
        return cd_movcaja;
    }

    function getCriterioBusqueda() {
        //recuperamos los parï¿½metros.
        $filtro = urldecode(FormatUtils::getParam('filtro'));
        $campoFiltro = FormatUtils::getParam('campoFiltro', $this->getCampoOrdenDefault());

        //$page = $this->getPagePaginacion();
        $orden = FormatUtils::getParam('orden', 'DESC');
        $campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault());

        $new_criterio = new CriterioBusqueda();
        //Filtro Especial

        $cd_usuario = $_SESSION['cd_usuarioSession'];
        $usuarioManager = new UsuarioRYTManager();
        $oUsuario = $usuarioManager->getUsuarioPorId($cd_usuario);
        $dt_inicio_filtro = "";
        $hs_inicio_filtro = "00:01";
        $movcajaManager = new MovcajaManager();
        $rta = $movcajaManager->hayCajaAbierta($oUsuario->getNu_caja());
        $cd_concepto = $rta['cd_concepto'];
        $cd_movcaja = $rta['cd_movcaja'];
        $cd_turno = $rta['cd_turno'];
        if ($cd_concepto == CD_CONCEPTO_INGRESO) {
            $criterio = new CriterioBusqueda();
            $criterio->addFiltro("cd_movcaja", $cd_movcaja, "=");
            $oMovcaja = $movcajaManager->getMovcaja($criterio);
            $fechayhora = FuncionesComunes::fechaHoraMysqlaPHP($oMovcaja->getDt_movcaja());
            $fechayhora = explode(" ", $fechayhora);
            $dt_inicio_filtro_default = $fechayhora[0];
            $hs_inicio_filtro_default = substr($fechayhora[1], 0, 5);
        }
        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);

        $dt_inicio_filtro = FormatUtils::getParam('dt_inicio_filtro', $dt_inicio_filtro_default);
        $dt_fin_filtro = FormatUtils::getParam('dt_fin_filtro');
        $hs_inicio_filtro = FormatUtils::getParam('hs_inicio_filtro', $hs_inicio_filtro_default);
        $hs_fin_filtro = FormatUtils::getParam('hs_fin_filtro', "23:59");
        $nu_caja = FormatUtils::getParam('nu_caja', "");
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
        if ($nu_caja != "") {
            $new_criterio->addFiltro('nu_caja', $nu_caja, "=");
        } else {
            $cd_usuario = $_SESSION['cd_usuarioSession'];
            $usuarioManager = new UsuarioRYTManager();
            $oUsuario = $usuarioManager->getUsuarioConPerfilPorId($cd_usuario);
            //Si es Admin, muestro el listado de cajas

            if ($oUsuario->getCd_perfil() != CD_PERFIL_ADMINISTRADOR) {
                $new_criterio->addFiltro('nu_caja', $oUsuario->getNu_caja(), "=");
            }
        }

        $new_criterio->addOrden($campoOrden, $orden);
        // $new_criterio->setPage($page);
        //$new_criterio->setRowPerPage(ROW_PER_PAGE);
        return $new_criterio;
    }

    public function getTitulo() {
        return "Listado de Movcajas";
    }

    public function getNombreArchivo() {
        return "movcajas";
    }

}
