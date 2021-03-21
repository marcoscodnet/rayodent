<?php

/**
 * Acción listar practicas.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ListarPracticasAction extends ListarAction {

    protected function getListarTableModel(ItemCollection $items) {
        return new PracticaTableModel($items);
    }

    protected function getOpciones() {
        $opciones[] = $this->buildOpcion('altapractica', 'Agregar Pr&aacute;ctica', 'alta_practica_init');
        return $opciones;
    }

    protected function getFiltros() {
        
        $filtros = array();
        		
		$filtros[] = $this->buildFiltro('cd_practica', RYT_PRACTICA_CD_PRACTICA);
				
		$filtros[] = $this->buildFiltro('ds_practica', RYT_PRACTICA_DS_PRACTICA);
		
		$filtros[] = $this->buildFiltro('bl_activa', RYT_OBRASOCIAL_BL_ACTIVA);
		
        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        $this->parseAccionesDefault($xtpl, $item, $item->getCd_practica(), 'practica', 'practica', true, true, true);
    }


    protected function getEntidadManager() {
        return new PracticaManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_practica';
    }

    protected function getTitulo() {
        return 'Administraci&oacute;n de Pr&aacute;cticas';
    }

    protected function getUrlAccionListar() {
        return 'listar_practicas';
    }

    protected function getForwardError() {
        return 'listar_practicas_error';
    }

    protected function getMenuActivo() {
        return "Pr&aacute;cticas";
    }

    protected function getCartelEliminar($entidad) {
		$xtpl = new XTemplate(RYT_TEMPLATE_BAJA_PRACTICA);
        $xtpl->assign('cd_practica', $entidad->getCd_practica());
        $xtpl->parse('main');
        $text = addslashes($xtpl->text('main'));
        return FormatUtils::quitarEnters($text);
    }

}
