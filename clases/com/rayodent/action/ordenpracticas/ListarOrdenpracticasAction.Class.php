<?php

/**
 * Acción listar ordenpracticas.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ListarOrdenpracticasAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new OrdenpracticaTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altaordenpractica', 'Agregar Ordenpractica', 'alta_ordenpractica_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_ordenpractica', RYT_ORDENPRACTICA_CD_ORDENPRACTICA);
				
		$filtros[] = $this->buildFiltro('dt_carga', RYT_ORDENPRACTICA_DT_CARGA);
				
		$filtros[] = $this->buildFiltro('cd_turno', RYT_ORDENPRACTICA_CD_TURNO);
				
		$filtros[] = $this->buildFiltro('cd_paciente', RYT_ORDENPRACTICA_CD_PACIENTE);
				
		$filtros[] = $this->buildFiltro('cd_profesional', RYT_ORDENPRACTICA_CD_PROFESIONAL);
				
		$filtros[] = $this->buildFiltro('cd_empleado', RYT_ORDENPRACTICA_CD_EMPLEADO);
				
		$filtros[] = $this->buildFiltro('cd_obrasocialbono', RYT_ORDENPRACTICA_CD_OBRASOCIALBONO);
				
		$filtros[] = $this->buildFiltro('bl_bono', RYT_ORDENPRACTICA_BL_BONO);
				
		$filtros[] = $this->buildFiltro('nu_importebono', RYT_ORDENPRACTICA_NU_IMPORTEBONO);
				
		$filtros[] = $this->buildFiltro('nu_reciboreintegro', RYT_ORDENPRACTICA_NU_RECIBOREINTEGRO);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_ordenpractica(), 'ordenpractica', 'ordenpractica', true, true, true);
    }


    protected function getEntidadManager() {
        return new OrdenpracticaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_ordenpractica';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Ordenpracticas';
    }

    protected function getUrlAccionListar() {
        return 'listar_ordenpracticas';
    }

    protected function getForwardError() {
        return 'listar_ordenpracticas_error';
    }

    protected function getMenuActivo() {
        return "Ordenpracticas";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_ORDENPRACTICA);
        $xtpl->assign('cd_ordenpractica', $entidad->getCd_ordenpractica());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
