<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ExcelPacientesobrasocialesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new PacienteobrasocialManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PacienteobrasocialTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_pacienteobrasocial;
	}


	public function getTitulo(){
		return "Listado de Pacientesobrasociales";
	}

	public function getNombreArchivo(){
		return "pacientesobrasociales";
	}

	
}
