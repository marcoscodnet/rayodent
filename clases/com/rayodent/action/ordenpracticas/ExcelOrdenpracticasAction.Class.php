<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 14-12-2011
 * 
 */
class ExcelOrdenpracticasAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new OrdenpracticaManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new OrdenpracticaTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_ordenpractica;
	}


	public function getTitulo(){
		return "Listado de Ordenpracticas";
	}

	public function getNombreArchivo(){
		return "ordenpracticas";
	}

	
}
