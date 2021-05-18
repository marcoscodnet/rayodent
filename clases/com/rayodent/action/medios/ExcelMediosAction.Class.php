<?php

/**
 * Acci�n para exportar a excel.
 *
 * @author modelBuilder
 * @since 18-05-2021
 *
 */
class ExcelMediosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new MedioManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new MedioTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_medio;
	}


	public function getTitulo(){
		return "Listado de Medios";
	}

	public function getNombreArchivo(){
		return "medios";
	}


}
