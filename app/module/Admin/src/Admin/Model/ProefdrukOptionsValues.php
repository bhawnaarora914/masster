<?php
namespace Admin\Model;
use Zend\Authentication\AuthenticationService;
use Zend\InputFilter\Factory as InputFactory;     // <-- Add this import
use Zend\InputFilter\InputFilter;                 // <-- Add this import
use Zend\InputFilter\InputFilterAwareInterface;   // <-- Add this import
use Zend\InputFilter\InputFilterInterface;        // <-- Add this import
class ProefdrukOptionsValues
{
	
	
	public $o_id;
	public $proof_opt_id;
	public $o_name;
	public $o_value;
	public $custom;
	public $custom_checked;
  

	
	public function exchangeArray($data)
	{
		$this->o_id     = (isset($data['o_id'])) ? $data['o_id'] : null;
		$this->proof_opt_id = (isset($data['proof_opt_id'])) ? $data['proof_opt_id'] : '';
	    $this->o_name     = (isset($data['o_name'])) ? $data['o_name'] : '';
		$this->o_value     = (isset($data['o_value'])) ? $data['o_value'] : null;
		$this->custom     = (isset($data['custom'])) ? $data['custom'] : '';
		$this->custom_checked     = (isset($data['custom_checked'])) ? $data['custom_checked'] : '';
	
	}
	
	
	public function getOptions()
	{
		return array(
		'XXS',
		'XS',
		'S',
		'M',
		'L',
		'XL',
		'XXL',
		'3XL',
		'4XL',
		'5XL',
		'6XL',
		'7XL',
		'8XL'		
		);
	}
}
	