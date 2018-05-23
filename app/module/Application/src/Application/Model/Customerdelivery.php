<?php
namespace Application\Model;
class Customerdelivery 
{
	public $cd_id;
	public $cd_company;
	public $cd_name;
	public $cd_street;
	public $cd_housenumber;
	public $cd_postal;
	public $cd_place;
	public $cd_country;
	public $cd_phone;
	public $proof_id;
	
  
	
	
	
	public function exchangeArray($data)
	{
	    $this->cd_id     = (isset($data['cd_id'])) ? $data['cd_id'] : null;
		$this->cd_company = (isset($data['cd_company'])) ? $data['cd_company'] : '';
		$this->cd_name = (isset($data['cd_name'])) ? $data['cd_name'] : '';
		$this->cd_street  = (isset($data['cd_street'])) ? $data['cd_street'] : '';
		$this->cd_housenumber = (isset($data['cd_housenumber'])) ? $data['cd_housenumber'] : '';
	    $this->cd_postal = (isset($data['cd_postal'])) ? $data['cd_postal'] : '';
		$this->cd_place = (isset($data['cd_place'])) ? $data['cd_place'] : '';
		$this->cd_country = (isset($data['cd_country'])) ? $data['cd_country'] : '';
		$this->cd_phone = (isset($data['cd_phone'])) ? $data['cd_phone'] : '';
		$this->proof_id = (isset($data['proof_id'])) ? $data['proof_id'] : '';
	}
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	
	
	
	
	

	
	
	
}