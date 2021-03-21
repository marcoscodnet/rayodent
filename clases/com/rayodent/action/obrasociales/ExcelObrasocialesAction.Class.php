<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 24-11-2011
 * 
 */
class ExcelObrasocialesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new ObrasocialManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new ObrasocialTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_obrasocial;
	}


	public function getTitulo(){
		return "Listado de Obrasociales";
	}

	public function getNombreArchivo(){
		return "obrasociales";
	}

	
}
