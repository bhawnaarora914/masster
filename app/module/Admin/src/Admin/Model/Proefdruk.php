<?php
namespace Admin\Model;
use Zend\Authentication\AuthenticationService;


class Proefdruk  
{
	public $proof_id;
    public $proof_number;
    public $proof_file;
	public $proof_customer_name;
    public $proof_autoremind;
    public $proof_add_option;
	public $proof_paymethod;
	public $proof_amount;
	public $proof_rushorder;
	public $proof_date;
	public $proof_time;
	public $proof_comment;
	public $proof_customer_email;
	public $proof_rushdate;
	public $proof_pay_comment;
	public $proof_rush_comment;
	public $proof_senddate;
	public $proof_status;
	public $proof_approvedate;
	public $remind_date_1;
	public $remind_date_2;
	public $remind_date_3;
	public $proof_extra_file;
	public $proof_extra_name;
	public $proof_adress_comment;
	public $proof_remind_counter;
	public $proof_size_customer;
	public $proof_size_customer_comment;
	
	public function exchangeArray($data)
	{
	    $this->proof_id     = (isset($data['proof_id'])) ? $data['proof_id'] : null;
		$this->proof_number = (isset($data['proof_number'])) ? $data['proof_number'] : '';
		$this->proof_file  = (isset($data['proof_file'])) ? $data['proof_file'] : '';
		$this->proof_customer_name = (isset($data['proof_customer_name'])) ? $data['proof_customer_name'] : '';
		$this->proof_autoremind  = (isset($data['proof_autoremind'])) ? $data['proof_autoremind'] : '';
		$this->proof_add_option  = (isset($data['proof_add_option'])) ? $data['proof_add_option'] : '';
		$this->proof_amount = (isset($data['proof_amount'])) ? str_replace(",",".",$data['proof_amount']) : '';
		$this->proof_rushorder = (isset($data['proof_rushorder'])) ? $data['proof_rushorder'] : '';
		$this->proof_date  = (isset($data['proof_date'])) ? $data['proof_date'] : '';
		$this->proof_time  = (isset($data['proof_time'])) ? $data['proof_time'] : '';
		$this->proof_comment  = (isset($data['proof_comment'])) ? $data['proof_comment'] : ''; 
		$this->proof_customer_email = (isset($data['proof_customer_email'])) ? $data['proof_customer_email'] : ''; 
		$this->proof_rushdate = (isset($data['proof_rushdate'])) ? $data['proof_rushdate'] : ''; 
		$this->proof_pay_comment = (isset($data['proof_pay_comment'])) ? $data['proof_pay_comment'] : ''; 
		$this->proof_rush_comment = (isset($data['proof_rush_comment'])) ? $data['proof_rush_comment'] : ''; 
		$this->proof_paymethod = (isset($data['proof_paymethod'])) ? $data['proof_paymethod'] : ''; 
		$this->proof_senddate = (isset($data['proof_senddate'])) ? $data['proof_senddate'] : ''; 
		$this->proof_senddate = (isset($data['proof_senddate'])) ? $data['proof_senddate'] : ''; 
		$this->proof_status = (isset($data['proof_status'])) ? $data['proof_status'] : ''; 
		$this->proof_approvedate = (isset($data['proof_approvedate'])) ? $data['proof_approvedate'] : ''; 
		$this->remind_date_1 = (isset($data['remind_date_1'])) ? $data['remind_date_1'] : ''; 
		$this->remind_date_2 = (isset($data['remind_date_2'])) ? $data['remind_date_2'] : ''; 
		$this->remind_date_3 = (isset($data['remind_date_3'])) ? $data['remind_date_3'] : ''; 
		$this->proof_extra_file =   (isset($data['proof_extra_file'])) ? $data['proof_extra_file'] : ''; 
		$this->proof_extra_name =   (isset($data['proof_extra_name'])) ? $data['proof_extra_name'] : ''; 
		$this->proof_adress_comment = (isset($data['proof_adress_comment'])) ? $data['proof_adress_comment'] : ''; 
		$this->proof_remind_counter =   (isset($data['proof_remind_counter'])) ? $data['proof_remind_counter'] : ''; 
		$this->proof_size_customer =   (isset($data['proof_size_customer'])) ? $data['proof_size_customer'] : '';
		$this->proof_global_option_comment =   (isset($data['proof_global_option_comment'])) ? $data['proof_global_option_comment'] : '';
		$this->proof_size_customer_comment =   (isset($data['proof_size_customer_comment'])) ? $data['proof_size_customer_comment'] : '';
	}
	
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
	
	
	
	
	
	
	

	
	
	
}