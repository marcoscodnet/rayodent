<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 24-11-2011 
 */ 
class PracticaTableModel extends ListarTableModel{

	private $columnNames = array();

	private $columnWidths = array();
	
	public function PracticaTableModel(ItemCollection $items){
		$this->items = $items;
		$this->initColumns();
	}
	
	private function initColumns(){
		
		$this->columnNames[] = RYT_PRACTICA_CD_PRACTICA;
		$this->columnWidths[] = 80;
		
		$this->columnNames[] = RYT_PRACTICA_DS_PRACTICA;
		$this->columnWidths[] = 80;
		
		$this->columnNames[] = RYT_OBRASOCIAL_BL_ACTIVA;
		$this->columnWidths[] = 20;
		
	}
	
		
	/**
	 * (non-PHPdoc)
	 * @see clases/com/cdt/view/tableModel/TableModel#getTitle()
	 */
	function getTitle(){
		return "Practicas";
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
		$oPractica = $anObject;
		$value=0;
		switch ($columnIndex) {
			
			case 0: $value= $oPractica->getCd_practica(); break;
			
			case 1: $value= $oPractica->getDs_practica(); break;
			
			case 2: $value= ($oPractica->getBl_activa())?RYT_YES:RYT_NO; break;
			
			default: $value='';	break;
		}
		return $value;
	}
	
	public function getEncabezados(){
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(0), 'cd_practica', 'cd_practica');
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(1), 'ds_practica', 'ds_practica');
	 	
	 	$encabezados[]= $this->buildTh($this->getColumnName(2), 'bl_activa', 'bl_activa');
	 	
	 	return $encabezados;	
	}
	
}
?>