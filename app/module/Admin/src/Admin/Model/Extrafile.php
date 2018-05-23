<?php
namespace Admin\Model;
use Zend\Authentication\AuthenticationService;

class Extrafile 
{
	public $file_id;
    public $file_name;
    public $file_filename;
	public $proof_id;
	
	
	public function exchangeArray($data)
	{
	    $this->file_id     = (isset($data['file_id'])) ? $data['file_id'] : null;
		$this->file_name = (isset($data['file_name'])) ? $data['file_name'] : null;
		$this->file_filename  = (isset($data['file_filename'])) ? $data['file_filename'] : null;
	
	}
	
  
	
	
	

	
	
	
}