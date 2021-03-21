<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ExcelPracticaobrasocialesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new PracticaobrasocialManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PracticaobrasocialTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_practicaobrasocial;
	}


	public function getTitulo(){
		return "Listado de Practicaobrasociales";
	}

	public function getNombreArchivo(){
		return "practicaobrasociales";
	}

	
}
