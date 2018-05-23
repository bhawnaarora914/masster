<?php
namespace Application\Model;
class Customeroptions 
{
	public $co_id;
    public $co_custname;
	public $co_approvetime;
	public $co_comment;
	public $co_add_comment;
	public $co_paymethod;
	public $proof_id;
	
	
	
	public function exchangeArray($data)
	{
	    $this->co_id     = (isset($data['co_id'])) ? $data['co_id'] : null;
		$this->co_custname = (isset($data['co_custname'])) ? $data['co_custname'] : '';
	    $this->co_approvetime = (isset($data['co_approvetime'])) ? $data['co_approvetime'] : '';
		$this->co_comment = (isset($data['co_comment'])) ? $data['co_comment'] : '';
		$this->co_add_comment = (isset($data['co_add_comment'])) ? $data['co_add_comment'] : '';
		$this->co_paymethod = (isset($data['co_paymethod'])) ? $data['co_paymethod'] : '';
		$this->proof_id = (isset($data['proof_id'])) ? $data['proof_id'] : '';
	}
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	
	
	
	
	

	
	
	
}