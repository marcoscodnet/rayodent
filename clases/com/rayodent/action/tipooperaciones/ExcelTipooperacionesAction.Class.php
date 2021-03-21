<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ExcelTipooperacionesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new TipooperacionManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new TipooperacionTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_tipooperacion;
	}


	public function getTitulo(){
		return "Listado de Tipooperaciones";
	}

	public function getNombreArchivo(){
		return "tipooperaciones";
	}

	
}
