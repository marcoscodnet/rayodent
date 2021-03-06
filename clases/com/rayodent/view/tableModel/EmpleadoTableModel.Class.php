<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 28-10-2011 
 */ 
class EmpleadoTableModel extends ListarTableModel{

	private $columnNames = array();

	private $columnWidths = array();
	
	public function EmpleadoTableModel(ItemCollection $items){
		$this->items = $items;
		$this->initColumns();
	}
	
	private function initColumns(){
		
		$this->columnNames[] = RYT_EMPLEADO_CD_EMPLEADO;
		$this->columnWidths[] = 80;
		
		$this->columnNames[] = RYT_EMPLEADO_DS_NOMBRE;
		$this->columnWidths[] = 80;
			
		$this->columnNames[] = RYT_EMPLEADO_DS_DOMICILIO;
		$this->columnWidths[] = 80;
		
		$this->columnNames[] = RYT_EMPLEADO_DS_TELEFONO;
		$this->columnWidths[] = 80;
		
		
	}
	
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Empleados";
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getColumnCount()
	 */
	function getColumnCount(){
		return count($this->columnNames);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getColumnName($columnIndex)
	 */
	function getColumnName($columnIndex){
		return $this->columnNames[$columnIndex];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getColumnWidth($columnIndex)
	 */
	function getColumnWidth($columnIndex){
		return $this->columnWidths[$columnIndex];
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getRowCount()
	 */
	function getRowCount(){
		$this->items->size();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getValueAt($rowIndex, $columnIndex)
	 */
	function getValueAt($rowIndex, $columnIndex){
		$oObject = $this->items->getObjectByIndex($rowIndex);
		return $this->getValue($oObject, $columnIndex);
	}

	public function getValue($anObject, $columnIndex){
		$oEmpleado = $anObject;
		$value=0;
		switch ($columnIndex) {
			
			case 0: $value= $oEmpleado->getCd_empleado(); break;
			
			case 1: $value= $oEmpleado->getDs_nombre(); break;
			
			case 2: $value= $oEmpleado->getDs_domicilio(); break;
			
			case 3: $value= $oEmpleado->getDs_telefono(); break;
			
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_empleado', 'cd_empleado');
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_nombre', 'ds_nombre');
	 		 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(2), 'ds_domicilio', 'ds_domicilio');
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(3), 'ds_telefono', 'ds_telefono');
	 	
	 	return $encabezados;	
	}
	
}
?>
