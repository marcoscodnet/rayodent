<?php 

/** 
 * Autogenerated class 
 *  
 *  @author modelBuilder 
 *  @since 12-12-2011
 */ 
class Contacto { 
	
	//variables de instancia.
	
	private $cd_contacto;
	
	private $ds_apynom;
	
	
	private $ds_direccion;
	
	private $ds_telefono;
	
	private $ds_movil;
	
	private $ds_telefonotrabajo;
	
	private $ds_email;
	
	private $nu_documento;
	
	private $nu_cuit;
	

	//Constructor.
	public function Contacto() { 
		//TODO inicializar variables.
		
		
		$this->cd_contacto = '';
		
		$this->ds_apynom = '';
		
		$this->ds_direccion = '';
		
		$this->ds_telefono = '';
		
		$this->ds_movil = '';
		
		$this->ds_telefonotrabajo = '';
		
		$this->ds_email = '';
		
		$this->nu_documento = '';
		
		$this->nu_cuit = '';
		
		
	}

	
	
	

	public function getCd_contacto()
	{
	    return $this->cd_contacto;
	}

	public function setCd_contacto($cd_contacto)
	{
	    $this->cd_contacto = $cd_contacto;
	}

	public function getDs_apynom()
	{
	    return $this->ds_apynom;
	}

	public function setDs_apynom($ds_apynom)
	{
	    $this->ds_apynom = $ds_apynom;
	}

	public function getDs_direccion()
	{
	    return $this->ds_direccion;
	}

	public function setDs_direccion($ds_direccion)
	{
	    $this->ds_direccion = $ds_direccion;
	}

	public function getDs_telefono()
	{
	    return $this->ds_telefono;
	}

	public function setDs_telefono($ds_telefono)
	{
	    $this->ds_telefono = $ds_telefono;
	}

	public function getDs_movil()
	{
	    return $this->ds_movil;
	}

	public function setDs_movil($ds_movil)
	{
	    $this->ds_movil = $ds_movil;
	}

	public function getDs_telefonotrabajo()
	{
	    return $this->ds_telefonotrabajo;
	}

	public function setDs_telefonotrabajo($ds_telefonotrabajo)
	{
	    $this->ds_telefonotrabajo = $ds_telefonotrabajo;
	}

	public function getDs_email()
	{
	    return $this->ds_email;
	}

	public function setDs_email($ds_email)
	{
	    $this->ds_email = $ds_email;
	}

	public function getNu_documento()
	{
	    return $this->nu_documento;
	}

	public function setNu_documento($nu_documento)
	{
	    $this->nu_documento = $nu_documento;
	}

	public function getNu_cuit()
	{
	    return $this->nu_cuit;
	}

	public function setNu_cuit($nu_cuit)
	{
	    $this->nu_cuit = $nu_cuit;
	}
} 
?>
