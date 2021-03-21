<?php

/**
 * Acci�n listar cumpleaños del día.
 * 
 * @author modelBuilder
 * @since 15-03-2018
 * 
 */
class ListarCumplesAction extends ListarAction {

	
	public function getQueryString($filtro, $campoFiltro){
		return "?filtro=dt_nacimiento&campoFiltro=".date('Ymd')."&";
	}
	
/**
	 * criterio de b?squeda para filtrar el listado.
	 * @return unknown_type
	 */
	protected function getCriterioBusqueda(){
		//recuperamos los par?metros.
		$filtro = '%'.date('md');
		$campoFiltro = 'dt_nacimiento';

		$page = $this->getPagePaginacion();
		$orden = FormatUtils::getParam('orden',$this->getOrdenDefault());
		$campoOrden = FormatUtils::getParam('campoOrden', $this->getCampoOrdenDefault() );

		//obtenemos las entidades a mostrar.
		$criterio = new CriterioBusqueda();
		//$criterio->put('campoFiltro', $campoFiltro);
		//$criterio->put('filtro', $filtro);

		$this->addSelectedFiltro($criterio,$campoFiltro, $filtro);

		$criterio->addOrden($campoOrden, $orden);
		$criterio->setPage($page);
		$criterio->setRowPerPage(ROW_PER_PAGE);
		return $criterio;
	}
	
	protected function addSelectedFiltro($criterio,$campoFiltro, $filtro){

		
		$criterio->addFiltro($campoFiltro, $filtro, 'LIKE', new FormatValorLike());
	}
	
	
    protected function getListarTableModel(ItemCollection $items) {
        return new CumpleTableModel($items);
    }

    protected function getOpciones() {
        
        return "";
    }

    protected function getFiltros() {

        $filtros = array();
       

        return $filtros;
    }

    protected function parseAcciones(XTemplate $xtpl, $item) {

        //$this->parseAccionesDefault($xtpl, $item, $item->getCd_paciente(), 'paciente', 'paciente', true, true, true);
    }

    protected function getEntidadManager() {
        return new PacienteManager();
    }

    protected function getCampoOrdenDefault() {
        return 'cd_paciente';
    }

    protected function getTitulo() {
        return 'Cumplea&ntilde;os del d&iacute;a';
    }

    protected function getUrlAccionListar() {
        return 'listar_cumples';
    }

    protected function getForwardError() {
        return 'listar_cumples_error';
    }

    protected function getMenuActivo() {
        return "Cumpleanos";
    }

   

}
