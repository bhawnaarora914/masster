<?php
namespace Admin\Model;
use Zend\Authentication\AuthenticationService;
use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
class User 
{
	public $user_id;
    public $username;
    public $password;
	
	
	public function exchangeArray($data)
	{
	    $this->user_id     = (isset($data['user_id'])) ? $data['user_id'] : null;
		$this->username = (isset($data['username'])) ? $data['username'] : null;
		$this->password  = (isset($data['password'])) ? $data['password'] : null;
	
	}
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	
	

	
	
	
}