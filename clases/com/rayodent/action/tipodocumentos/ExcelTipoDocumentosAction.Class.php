<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ExcelTipoDocumentosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new TipoDocumentoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new TipoDocumentoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_tipodocumento;
	}


	public function getTitulo(){
		return "Listado de TipoDocumentos";
	}

	public function getNombreArchivo(){
		return "tipodocumentos";
	}

	
}
