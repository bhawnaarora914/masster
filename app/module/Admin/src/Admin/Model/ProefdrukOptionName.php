<?php
namespace Admin\Model;
use Zend\Authentication\AuthenticationService;
use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import

class ProefdrukOptionName  implements InputFilterAwareInterface
{
	public $proof_opt_id;
	public $proof_opt_name;
	public $proof_opt_description;
	public $proof_opt_maxvalue;
	public $proof_id;
	public $o_id;
	public $o_name;
	public $o_value;
	public $custom ;
	public $custom_checked;

  

	
	public function exchangeArray($data)
	{
		$this->proof_opt_id     = (isset($data['proof_opt_id'])) ? $data['proof_opt_id'] : null;
		$this->proof_opt_name = (isset($data['proof_opt_name'])) ? $data['proof_opt_name'] : '';
	    $this->proof_opt_description     = (isset($data['proof_opt_description'])) ? $data['proof_opt_description'] : '';
		$this->proof_id     = (isset($data['proof_id'])) ? $data['proof_id'] : null;
		$this->o_id     = (isset($data['o_id'])) ? $data['o_id'] : '';
		$this->o_name     = (isset($data['o_name'])) ? $data['o_name'] : '';
		$this->custom     = (isset($data['custom'])) ? $data['custom'] : '';
		$this->o_value     = (isset($data['o_value'])) ? $data['o_value'] : null;
		$this->custom_checked     = (isset($data['custom_checked'])) ? $data['custom_checked'] : '';
		$this->proof_opt_maxvalue = (isset($data['proof_opt_maxvalue'])) ? $data['proof_opt_maxvalue'] : '';
	
	}
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	
	  // Add content to this method:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
	
	
	
	public function getInputFilter()
    {
    	throw new \Exception("Not used");
    }
	
	
	
	

	
	
	
}