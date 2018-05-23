<?php
namespace Admin\Form;
use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element\Checkbox;

class ProefdrukForm extends Form
{
	
	
    public function __construct($name = null,$autoremind=0,$rushorder=0,$size_customer = 0,$add_option=0)
    {
        // we want to ignore the name passed
        parent::__construct('menu');
        $this->setAttribute('method', 'post');
	    $this->setAttribute('enctype','multipart/form-data');
 		$this->add(array(
            'name' => 'proof_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
           
        ));
		
        $this->add(array(
            'name' => 'proof_number',
            'attributes' => array(
                'type'  => 'text',
                'id'=>'proof_number',
                'class'=>'span12',
                'style'=>'color:black; width:214px;'

            ),
           
        ));
		
		 $this->add(array(
            'name' => 'proof_opt_name',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12'
            ),
           
        ));
		
		
		
		$this->add(array(
            'name' => 'proof_opt_maxvalue',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12'
            ),
           
        ));
		
		
		
		
		$this->add(array(
            'name' => 'proof_opt_description',
            
            'attributes' => array(
                 'type'  => 'textarea',
                 'id'=>'proof_opt_description',
               
            ),
           
        ));
		
		
		 $this->add(array(
            'name' => 'o_name[]',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12'
            ),
           
        ));
		
		
		 $this->add(array(
            'name' => 'proof_file',
            'attributes' => array(
                'type'  => 'file',
                'class'=>'span12',
                'style'=>'width:300px;'
          
            ),
           
        ));
		
		$this->add(array(
            'name' => 'proof_extra_name',
            'attributes' => array(
                'type'  => 'text',
                'class'=>'span12',
                'style'=>'color:black; background: white; margin-left:20px; width:300px;'
                
          
            ),
           
        ));
		
		$this->add(array(
            'name' => 'proof_extra_file',
            'attributes' => array(
                'type'  => 'file',
                'class'=>'span12',
                'style'=>'color:black;'
          
            ),
           
        ));
		
		
		 $this->add(array(
            'name' => 'proof_customer_name',
            'attributes' => array(
                'type'  => 'text',
                'style'=>'color:black;'
               
            ),
           
        ));
		
		if($size_customer == 0 ) {
			$this->add(array(
            'name' => 'proof_size_customer',
            'type'  => 'Zend\Form\Element\Checkbox',
            'useHiddenElement' => true,
            'options'=>array('checked_value'=>1,'unchecked_value'=>0)));
			
		} else {
			$this->add(array(
	            'name' => 'proof_size_customer',
	            'type'  => 'Zend\Form\Element\Checkbox',
	            'useHiddenElement' => true,
	            'options'=>array('checked_value'=>1,'unchecked_value'=>0),
	            'attributes' => array(
	                'checked' => 'checked' //set checked to '1'
	            )
	        ));
			
		}
		

        if($autoremind==0) {
            $this->add(array(
                'name' => 'proof_autoremind',
                'type'  => 'Zend\Form\Element\Checkbox',
                'useHiddenElement' => true,
                'options'=>array('checked_value'=>1,'unchecked_value'=>0)));
                
        }    else {
            $this->add(array(
                'name' => 'proof_autoremind',
                'type'  => 'Zend\Form\Element\Checkbox',
                'useHiddenElement' => true,
                'options'=>array('checked_value'=>1,'unchecked_value'=>0),
                'attributes' => array(
                    'checked' => 'checked' //set checked to '1'
                )
            ));
        }
                
                
        if($add_option==0) {
            $this->add(array(
                'name' => 'proof_add_option',
                'type'  => 'Zend\Form\Element\Checkbox',
                'useHiddenElement' => true,
                'options'=>array('checked_value'=>1,'unchecked_value'=>0)));
                
        }    else {
            $this->add(array(
                'name' => 'proof_add_option',
                'type'  => 'Zend\Form\Element\Checkbox',
                'useHiddenElement' => true,
                'options'=>array('checked_value'=>1,'unchecked_value'=>0),
                'attributes' => array(
                    'checked' => 'checked' //set checked to '1'
                )
            ));
        }
		 
		
		 $this->add(array(
            'name' => 'proof_amount',
            'attributes' => array(
                'type'  => 'text',
                'style'=>'color:black;'
              
            ),
           
        ));
		
		
		
	if($rushorder==0) {
		$this->add(array(
            'name' => 'proof_rushorder',
            'type'  => 'Zend\Form\Element\Checkbox',
            'options'=>array('checked_value'=>1,'unchecked_value'=>0)
           
        ));
	} else {
		$this->add(array(
            'name' => 'proof_rushorder',
            'type'  => 'Zend\Form\Element\Checkbox',
            'options'=>array('checked_value'=>1,'unchecked_value'=>0),
             'attributes' => array(
	                'checked' => 'checked' //set checked to '1'
	            )
           
        ));
	}
		
		
		$this->add(array(
            'name' => 'proof_date',
            'attributes' => array(
                'type'  => 'text',
                'id'=>'datepicker',
                'style'=>'color:black;',
                'value'=>date('d-m-Y')
              
            ),
           
        ));
		
		$this->add(array(
            'name' => 'proof_rushdate',
            'attributes' => array(
                'type'  => 'text',
                'id'=>'datepicker2',
                'style'=>'color:black;'
              
            ),
           
        ));
		
		
		$this->add(array(
            'name' => 'proof_time',
            'attributes' => array(
                'type'  => 'text',
               
                'style'=>'color:black;'
            ),
           
        ));
		
		$this->add(array(
            'name' => 'proof_customer_email',
            'attributes' => array(
                'type'  => 'text',
                
                'style'=>'color:black;'
            ),
           
        ));
		
		
		
		
		
		$this->add(array(
            'name' => 'proof_comment',
            'attributes' => array(
                'type'  => 'textarea',
                'class'=>'wysihtml5 span12',
                'id'=>'mustHaveId',
                'rows'=>'5',
                'style'=>'color:black;  background:white;'
                
            ),
           
        ));
		
		
	
		
		$this->add(array(
            'name' => 'proof_rush_comment',
            'attributes' => array(
                'type'  => 'textarea',
                'class'=>'wysihtml5 span12',
                'id'=>'1',
                'rows'=>'5',
                'style'=>'color:black;  background:white;'
                
            ),
           
        ));
		
		
		$this->add(array(
            'name' => 'proof_pay_comment',
            'attributes' => array(
                'type'  => 'textarea',
                'class'=>'wysihtml5 span12',
                'id'=>'4',
                'rows'=>'5',
                'style'=>'color:black;  background:white;'
                
            ),
           
        ));
		
		
		$this->add(array(
            'name' => 'proof_adress_comment',
            'attributes' => array(
                'type'  => 'textarea',
                'class'=>'wysihtml5 span12',
                'id'=>'blaay',
                'rows'=>'5',
                'style'=>'color:black; background:white;'
                
            ),
           
        ));
		
		$this->add(array(
            'name' => 'proof_global_option_comment',
            'attributes' => array(
                'type'  => 'textarea',
                'class'=>'wysihtml5 span12',
                'id'=>'blaat12',
                'rows'=>'5',
                'style'=>'color:black; background:white;'
                
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

