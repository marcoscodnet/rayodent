<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 12-12-2011
 * 
 */
class ExcelPacientesAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new PacienteManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new PacienteTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_paciente;
	}


	public function getTitulo(){
		return "Listado de Pacientes";
	}

	public function getNombreArchivo(){
		return "pacientes";
	}

	
}
