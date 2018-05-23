<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element\Checkbox;

class ProefdrukOptionsValuesForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('menu');
        $this->setAttribute('method', 'post');
 	
		
        $this->add(array(
            'name' => 'o_name[]',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12'
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

