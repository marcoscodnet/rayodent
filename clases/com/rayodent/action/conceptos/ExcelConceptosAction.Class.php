<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class ExcelConceptosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new ConceptoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new ConceptoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_concepto;
	}


	public function getTitulo(){
		return "Listado de Conceptos";
	}

	public function getNombreArchivo(){
		return "conceptos";
	}

	
}
