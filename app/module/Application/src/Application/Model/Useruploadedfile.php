<?php
namespace Application\Model;
class Useruploadedfile 
{
	public $u_fid;
	public $proof_id;
	public $filename;

	
  
	
	
	
	public function exchangeArray($data)
	{
	    $this->u_fid     = (isset($data['u_fid'])) ? $data['u_fid'] : null;
		$this->proof_id = (isset($data['proof_id'])) ? $data['proof_id'] : '';
		$this->filename = (isset($data['filename'])) ? $data['filename'] : '';
	
	}
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	
	
	
	
	

	
	
	
}