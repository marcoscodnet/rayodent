<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ExcelProfesionalesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new ProfesionalManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new ProfesionalTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_profesional;
	}


	public function getTitulo(){
		return "Listado de Profesionales";
	}

	public function getNombreArchivo(){
		return "profesionales";
	}

	
}
