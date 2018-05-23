<?php
namespace Admin\Form;
use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element\Checkbox;

class Adduserform extends Form
{
	
	
    public function __construct($name = null,$autoremind=0,$rushorder=0)
    {
        // we want to ignore the name passed
        parent::__construct('menu');
        $this->setAttribute('method', 'post');
	  
		
        
		$this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type'  => 'hidden',
                'style'=>'color:black;'
               
            ),
           
        ));
		
		 $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type'  => 'text',
                'style'=>'color:black;'
               
            ),
           
        ));
		
		 $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type'  => 'text',
                'style'=>'color:black;'
               
            ),
           
        ));
		

		

		
		  $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Opslaan',
                'id' => 'submitbutton',
            ),
        ));
		
		
		
		
     
   
    }
}

