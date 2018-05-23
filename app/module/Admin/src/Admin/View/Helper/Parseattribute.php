<?php namespace Admin\View\Helper;
use Zend\View\Helper\AbstractHelper;  
use Zend\ServiceManager\ServiceLocatorAwareInterface;  
use Zend\ServiceManager\ServiceLocatorInterface;  
 
class Parseattribute extends AbstractHelper implements ServiceLocatorAwareInterface  
{
      
    public function __invoke($form_elem_id)  
    {  
         $sm = $this->getServiceLocator()->getServiceLocator();
		 $Attribute =  $sm->get("Admin\Model\FormattributeTable");
		 return $Attribute->getFormAttribute($form_elem_id,true);
    }  
	
	
	 /** 
     * Set the service locator. 
     * 
     * @param ServiceLocatorInterface $serviceLocator 
     * @return CustomHelper 
     */  
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)  
    {  
        $this->serviceLocator = $serviceLocator;  
        
    }  
    /** 
     * Get the service locator. 
     * 
     * @return \Zend\ServiceManager\ServiceLocatorInterface 
     */  
    public function getServiceLocator()  
    {  
        return $this->serviceLocator;  
    }  
	
	
	
}