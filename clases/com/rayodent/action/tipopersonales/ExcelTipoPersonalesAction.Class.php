<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ExcelTipoPersonalesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new TipoPersonalManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new TipoPersonalTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_tipopersonal;
	}


	public function getTitulo(){
		return "Listado de TipoPersonales";
	}

	public function getNombreArchivo(){
		return "tipopersonales";
	}

	
}
