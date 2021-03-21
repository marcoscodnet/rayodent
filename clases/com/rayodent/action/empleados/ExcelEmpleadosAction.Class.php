<?php 

/**
 * Acción para exportar a excel.
 * 
 * @author modelBuilder
 * @since 28-10-2011
 * 
 */
class ExcelEmpleadosAction extends ExportExcelCollectionAction{

	protected function getIListar(){
		return new EmpleadoManager();
	}

	protected function getTableModel(ItemCollection $items){
		return new EmpleadoTableModel($items);
	}

	protected function getCampoOrdenDefault(){
		return cd_empleado;
	}


	public function getTitulo(){
		return "Listado de Empleados";
	}

	public function getNombreArchivo(){
		return "empleados";
	}

	
}
