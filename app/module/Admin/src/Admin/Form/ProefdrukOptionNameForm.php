<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element\Checkbox;

class ProefdrukOptionNameForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('menu');
        $this->setAttribute('method', 'post');
 	
		
        $this->add(array(
            'name' => 'proof_opt_name',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12',
                'style'=>'background:white; color:black;'
            ),
           
        ));
		
		$this->add(array(
            'name' => 'proof_opt_maxvalue',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12',
                'style'=>'background:white; color:black;'
            ),
           
        ));
		
		
		
		
		$this->add(array(
            'name' => 'proof_opt_description',
            
            'attributes' => array(
                 'type'  => 'textarea',
                 'id'=>'proof_opt_description',
                'style'=>'background:white; color:black;'
               
            ),
           
        ));
		
			$this->add(array(
            'name' => 'proof_id',
            'attributes' => array(
                'type'  => 'hidden',
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

