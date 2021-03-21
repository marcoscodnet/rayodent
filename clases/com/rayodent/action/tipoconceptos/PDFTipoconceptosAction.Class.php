<?php 

/**
 * Acción para exportar a pdf.
 * 
 * @author modelBuilder
 * @since 05-12-2011
 * 
 */
class PDFTipoconceptosAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new TipoconceptoManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new TipoconceptoTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return cd_tipoconcepto;
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "L";
	}

	
}
