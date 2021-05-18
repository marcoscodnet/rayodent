<?php

/**
 * Acci�n para exportar a pdf.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class PDFMediosAction extends ExportPDFCollectionAction{

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getIListar()
	 */
	protected function getIListar(){
		return new MedioManager();
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getTableModel($items)
	 */
	protected function getTableModel(ItemCollection $items){
		return new MedioTableModel($items);
	}

	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getCampoOrdenDefault()
	 */
	protected function getCampoOrdenDefault(){
		return cd_medio;
	}


	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/pdf/ExportPDFCollectionAction#getOrientacion()
	 */
	protected function getOrientacion(){
		return "L";
	}


}
