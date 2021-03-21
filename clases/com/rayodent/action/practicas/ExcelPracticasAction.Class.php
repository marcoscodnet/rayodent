<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ExcelPracticasAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new PracticaManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PracticaTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_practica;
	}


	public function getTitulo(){
		return "Listado de Practicas";
	}

	public function getNombreArchivo(){
		return "practicas";
	}

	
}
