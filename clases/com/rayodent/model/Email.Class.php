<?php 

/** 
 * Autogenerated class 
 *  
 *  @author Marcos 
 *  @since 10-10-2018
 */ 
class Email { 
	
	//variables de instancia.
	
	private $cd_email;
	
	private $ds_remitente;
	
	private $ds_destinatario;
	
	private $ds_asunto;
	
	private $ds_cuerpo;
	
	private $dt_fecha;
	
	private $nu_email;
	//Constructor.
	public function Email() { 
		//TODO inicializar variables.
		
		
		$this->cd_email = '';
		
		$this->ds_remitente = '';
		
		$this->ds_destinatario = '';
		
		$this->ds_asunto = '';
		
		$this->ds_cuerpo = '';
		
		$this->dt_fecha = '';
		
		$this->nu_email = '';
	}

	

	public function getCd_email()
	{
	    return $this->cd_email;
	}

	public function setCd_email($cd_email)
	{
	    $this->cd_email = $cd_email;
	}

	public function getDs_remitente()
	{
	    return $this->ds_remitente;
	}

	public function setDs_remitente($ds_remitente)
	{
	    $this->ds_remitente = $ds_remitente;
	}

	public function getDs_destinatario()
	{
	    return $this->ds_destinatario;
	}

	public function setDs_destinatario($ds_destinatario)
	{
	    $this->ds_destinatario = $ds_destinatario;
	}

	public function getDs_asunto()
	{
	    return $this->ds_asunto;
	}

	public function setDs_asunto($ds_asunto)
	{
	    $this->ds_asunto = $ds_asunto;
	}

	public function getDs_cuerpo()
	{
	    return $this->ds_cuerpo;
	}

	public function setDs_cuerpo($ds_cuerpo)
	{
	    $this->ds_cuerpo = $ds_cuerpo;
	}

	public function getDt_fecha()
	{
	    return $this->dt_fecha;
	}

	public function setDt_fecha($dt_fecha)
	{
	    $this->dt_fecha = $dt_fecha;
	}

	public function getNu_email()
	{
	    return $this->nu_email;
	}

	public function setNu_email($nu_email)
	{
	    $this->nu_email = $nu_email;
	}
} 
?>
