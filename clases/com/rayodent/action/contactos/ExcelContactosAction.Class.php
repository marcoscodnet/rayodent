<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ExcelContactosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new ContactoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new ContactoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_contacto;
	}


	public function getTitulo(){
		return "Listado de Contactos";
	}

	public function getNombreArchivo(){
		return "contactos";
	}

	
}
