<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ExcelTipoconceptosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new TipoconceptoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new TipoconceptoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_tipoconcepto;
	}


	public function getTitulo(){
		return "Listado de Tipoconceptos";
	}

	public function getNombreArchivo(){
		return "tipoconceptos";
	}

	
}
